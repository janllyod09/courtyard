<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ClientsExport implements WithEvents
{
    use Exportable;

    protected $filters;
    protected $rowNumber = 1;
    protected $currentRow;

    public function __construct($filters){
        $this->filters = $filters;
    }

    public function registerEvents(): array{
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->addCustomHeader($event);
            },
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(4);
                $sheet->getColumnDimension('B')->setWidth(25);
                $sheet->getColumnDimension('C')->setWidth(25);
                $sheet->getColumnDimension('D')->setWidth(25);
                $sheet->getColumnDimension('E')->setWidth(25);
                $sheet->getColumnDimension('F')->setWidth(18);
                $sheet->getColumnDimension('G')->setWidth(18);
                $sheet->getColumnDimension('H')->setWidth(18);
                $sheet->getColumnDimension('I')->setWidth(18);


                // Set row height for row 4
                $sheet->getRowDimension(4)->setRowHeight(20); 
; 

                // Merge cells A12 and A13
                $sheet->setCellValue('A4', '');
                $sheet->setCellValue('B4', '	Company Name');
                $sheet->setCellValue('C4', 'Registrant Name');
                $sheet->setCellValue('D4', 'Email');
                $sheet->setCellValue('E4', 'Permit/Contract Number');
                $sheet->setCellValue('F4', 'Mining Type');
                $sheet->setCellValue('G4', 'Product');
                $sheet->setCellValue('H4', 'Permit Type');
                $sheet->setCellValue('I4', 'Permit Location');

                // Apply word wrap
                $sheet->getStyle('A:I')->getAlignment()->setWrapText(true);

                // Column Header
                $sheet->getStyle('A1:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A4:I4')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

                // Rows
                $sheet->getStyle('A4:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C4:I' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $this->currentRow = 5;
                $this->getClients($sheet);
            },
        ];
    }

    private function addCustomHeader(BeforeSheet $event){
        $sheet = $event->sheet;

        // Add custom header
        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', "");

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', "The Mine SHOP");
        $sheet->mergeCells('A3:I3');

        $sheet->setCellValue('A3', "Client List");

        // Apply some basic styling
        $sheet->getStyle('A1:I3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:I3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:I3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
        $sheet->getStyle('A4:I4')->getFont()->setBold(true);
        $sheet->getStyle('2:2')->getFont()->setSize(16);

        $sheet->getStyle('A4:I4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light gray background
            ],
        ]);
    }

    private function getClients($sheet){
        if($this->filters['clients']){
            foreach($this->filters['clients'] as $client){
                $sheet->setCellValue("A{$this->currentRow}", $this->rowNumber);
                $sheet->setCellValue("B{$this->currentRow}", $client->company_name);
                $sheet->setCellValue("C{$this->currentRow}", $client->registrant_name);
                $sheet->setCellValue("D{$this->currentRow}", $client->email);
                $sheet->setCellValue("E{$this->currentRow}", $client->contact_num);
                $sheet->setCellValue("F{$this->currentRow}", strtoupper($client->mining_type));
                $sheet->setCellValue("G{$this->currentRow}", $this->formatJsonColumn($client->product));
                $sheet->setCellValue("H{$this->currentRow}", strtoupper($client->permit_type));
                $sheet->setCellValue("I{$this->currentRow}", $client->permit_location);

                // Apply styling
                $sheet->getStyle('A' . $this->currentRow . ':B' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C' . $this->currentRow . ':E' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('F' . $this->currentRow . ':I' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('A' . $this->currentRow . ':I' . $this->currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
                $sheet->getStyle('A' . $this->currentRow . ':I' . $this->currentRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],
                ]);

                // Enable text wrapping for all cells in this row
                $sheet->getStyle('A' . $this->currentRow . ':I' . $this->currentRow)
                            ->getAlignment()
                            ->setWrapText(true);

                // Set row height to auto
                $this->setRowHeight($sheet, $this->currentRow);
                $this->currentRow++;
                $this->rowNumber++;
            }
        }
    }

    private function formatJsonColumn($jsonString){
        $decoded = json_decode($jsonString, true);
        if (is_array($decoded)) {
            return implode("\n", array_map(function($item) {
                return "• " . $item;
            }, $decoded));
        }
        return $jsonString;
    }

    private function setRowHeight($sheet, $row){
        $highestColumn = $sheet->getHighestColumn();
        $rowHeight = 15; // Base height

        for ($col = 'A'; $col <= $highestColumn; $col++) {
            $cellValue = $sheet->getCell($col . $row)->getValue();
            $lines = substr_count($cellValue, "\n") + 2;
            $cellHeight = $lines * 15; // Assuming 15 points per line
            $rowHeight = max($rowHeight, $cellHeight);
        }

        $sheet->getRowDimension($row)->setRowHeight($rowHeight);
    }
}
