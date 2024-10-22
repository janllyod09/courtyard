<?php

namespace App\Exports;

use App\Models\CpMonthlyReports;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SafetyHealthMonthlyReportExport implements WithEvents
{
    use Exportable;

    protected $filters;
    protected $currentRow;
    protected $allReports;
    protected $specificReport;

    protected $cumulative = [];

    public function __construct($filters){
        $this->filters = $filters;
        $this->specificReport = $filters['report'];
        $this->fetchAllReports();
    }

    protected function fetchAllReports()
    {
        $year = Carbon::parse($this->specificReport->month)->year;
        $this->allReports = CpMonthlyReports::with(['nonLostTimeAccidents', 'nonFatalLostTimeAccidents', 'fatalLostTimeAccidents', 'monthlyDeseases'])
            ->where('user_id', $this->specificReport->user_id)
            ->where('permit_number', $this->specificReport->permit_number)
            ->whereYear('month', $year)
            ->orderBy('month')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->month)->format('F');
            });
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
                $sheet->getColumnDimension('A')->setWidth(8);
                $sheet->getColumnDimension('B')->setWidth(8);
                $sheet->getColumnDimension('C')->setWidth(8);
                for ($col = 'D'; $col <= 'P'; $col++) {
                    $sheet->getColumnDimension($col)->setWidth(12);
                }


                // Set row height for row 4
                $sheet->getRowDimension(4)->setRowHeight(20); 
; 

                // Merge cells A12 and A13
                $sheet->mergeCells('A4:C4');
                $sheet->setCellValue('A4', 'Tabulation');
                $sheet->setCellValue('D4', 'January');
                $sheet->setCellValue('E4', 'February');
                $sheet->setCellValue('F4', 'March');
                $sheet->setCellValue('G4', 'April');
                $sheet->setCellValue('H4', 'May');
                $sheet->setCellValue('I4', 'June');
                $sheet->setCellValue('J4', 'July');
                $sheet->setCellValue('K4', 'August');
                $sheet->setCellValue('L4', 'September');
                $sheet->setCellValue('M4', 'October');
                $sheet->setCellValue('N4', 'November');
                $sheet->setCellValue('O4', 'December');
                $sheet->setCellValue('P4', 'Cumulative');

                // Apply word wrap
                $sheet->getStyle('A:P')->getAlignment()->setWrapText(true);

                // Column Header
                $sheet->getStyle('A1:P3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A4:P4')->getAlignment()->setHorizontal(Alignment::VERTICAL_CENTER);

                // Rows
                $sheet->getStyle('A4:B' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
                $sheet->getStyle('C4:P' . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $this->monthlyData($sheet);
                $this->monthlyAccidentIllness($sheet);
                $this->monthlyDeseases($sheet);
                $this->quarterEmergencyDrill($sheet);
            },
        ];
    }

    private function addCustomHeader(BeforeSheet $event){
        $sheet = $event->sheet;

        // Add custom header
        $sheet->mergeCells('A1:P1');
        $sheet->setCellValue('A1', "The Mine SHOP");

        $sheet->mergeCells('A2:P2');
        $sheet->setCellValue('A2', "SAFETY AND HEALTH REPORT FOR THE MONTH OF " .  strtoupper($this->filters['monthYear']));
        $sheet->mergeCells('A3:P3');
        // $sheet->setCellValue('A3', $this->filters['client'] ? 'Company: ' . $this->filters['client']->company_name : '' );
        $sheet->setCellValue('A3', 'Permit No.: ' . $this->specificReport->permit_number);

        // Apply some basic styling
        $sheet->getStyle('A1:P3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:P3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:P3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
        $sheet->getStyle('A4:P4')->getFont()->setBold(true);
        $sheet->getStyle('2:2')->getFont()->setSize(16);
        $sheet->getStyle('3:3')->getFont()->setSize(14);

        $sheet->getStyle('A4:P4')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light green background
            ],
        ]);
    }

    private function monthlyData($sheet)
    {
        $this->currentRow = 5;
        $firstRow = $this->currentRow;
    
        $dataPoints = [
            'Date Encoded' => 'date_encoded',
            'Non-Lost Time Accident' => 'non_lost_time_accident',
            'Lost Time Accident (Non-Fatal)' => 'non_fatal_lost_time_accident',
            'Lost Time Accident (Fatal)' => 'fatal_lost_time_accident',
            'Days Lost' => ['nflt_days_lost', 'flt_days_lost'],
            'Manhours Worked' => 'man_hours',
            'Number of Employees' => ['male_workers', 'female_workers'],
            'Minutes of CSHC Meetings' => 'minutes'
        ];
    
        foreach ($dataPoints as $label => $field) {
            $sheet->mergeCells("A{$this->currentRow}:C{$this->currentRow}");
            $sheet->setCellValue("A{$this->currentRow}", $label);
    
            $cumulativeValue = 0;
            foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $index => $month) {
                $cellAddress = chr(68 + $index) . $this->currentRow;
                $report = $this->allReports[$month] ?? null;
    
                if ($report) {
                    if (is_array($field)) {
                        $value = array_sum(array_map(function($f) use ($report) {
                            return $report->$f;
                        }, $field));
                    } else {
                        $value = $field === 'minutes' ? basename($report->$field) : $report->$field;
                    }
    
                    $sheet->setCellValue($cellAddress, $value);
    
                    if ($report->id === $this->specificReport->id) {
                        $sheet->getStyle($cellAddress)->getFont()->setBold(true);
                    }
    
                    // Update cumulative calculation
                    if ($field !== 'minutes' && $field !== 'date_encoded' && $label !== 'Number of Employees') {
                        $cumulativeValue += $value;
                        $this->cumulative[$label] = $cumulativeValue;
                    }
                }
            }
    
            // Set cumulative value and cell styling
            if ($field !== 'minutes' && $field !== 'date_encoded' && $label !== 'Number of Employees') {
                $sheet->setCellValue("P{$this->currentRow}", $cumulativeValue);
            } else {
                $sheet->getStyle("P{$this->currentRow}")
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setARGB('595959');
            }
    
            $this->currentRow++;
        }
    
        $lastRow = $this->currentRow - 1;
    
        $sheet->getStyle("D{$firstRow}:P{$lastRow}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle("D{$firstRow}:P{$lastRow}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$firstRow}:P{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);
    }

    private function monthlyAccidentIllness($sheet){
        $sheet->mergeCells('A13:P13');
        $sheet->mergeCells('A14:P14');
        $sheet->mergeCells('A15:C15');
        $sheet->setCellValue('A15', 'Injured Personel');
        $sheet->mergeCells('D15:G15');
        $sheet->setCellValue('D15', 'Kind of Accident');
        $sheet->mergeCells('H15:J15');
        $sheet->setCellValue('H15', 'Type of Injury Recorded');
        $sheet->mergeCells('K15:M15');
        $sheet->setCellValue('K15', 'Part of the Body Injured');
        $sheet->mergeCells('N15:P15');
        $sheet->setCellValue('N15', 'Treatment');

        $sheet->getRowDimension(15)->setRowHeight(20); 
        $sheet->getStyle("A15")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('D15:P15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15:P15')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A15:P15')->getFont()->setBold(true);
        $sheet->getStyle('A15:P15')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light green background
            ],
        ]);

        // $sheet->getStyle('L15:P15')->applyFromArray([
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => Border::BORDER_THIN,
        //             'color' => ['argb' => 'FF000000'], // Black color
        //         ],
        //     ],
        //     'fill' => [
        //         'fillType' => Fill::FILL_SOLID,
        //         'color' => ['argb' => 'FFC1F0C8'], // Light green background
        //     ],
        // ]);
        
        $this->getInjuredPersonel($sheet);
    }

    private function getInjuredPersonel($sheet){
        $this->currentRow = 16;
        $injuredPersonnel = $this->filters['injuredPersonnel'];

        // Process non-lost time accidents
        $count = 1;
        foreach ($injuredPersonnel['nonLostTimeAccidents'] as $accident) {
            $this->addAccidentRow($sheet, $accident, $count);
            $count++;
        }

        // Process non-fatal lost time accidents
        $count = 1;
        foreach ($injuredPersonnel['nonFatalLostTimeAccidents'] as $accident) {
            $this->addAccidentRow($sheet, $accident, $count);
            $count++;
        }
    }

    private function addAccidentRow($sheet, $accident, $count){
        $sheet->mergeCells('A' . $this->currentRow .':C' . $this->currentRow);
        $sheet->setCellValue('A' . $this->currentRow, $count . '. ' . $accident->name);
        $sheet->mergeCells('D' . $this->currentRow .':G' . $this->currentRow);
        $sheet->setCellValue('D' . $this->currentRow, $this->formatJsonColumn($accident->kind_of_accident));
        $sheet->mergeCells('H' . $this->currentRow .':J' . $this->currentRow);
        $sheet->setCellValue('H' . $this->currentRow, $this->formatJsonColumn($accident->type_of_injury));
        
        $sheet->mergeCells('K' . $this->currentRow .':M' . $this->currentRow);
        $sheet->setCellValue('K' . $this->currentRow, $this->formatJsonColumn($accident->part_of_body_injured));
        
        $sheet->mergeCells('N' . $this->currentRow .':P' . $this->currentRow);
        $sheet->setCellValue('N' . $this->currentRow, $this->formatJsonColumn($accident->treatment));


        // Apply styling
        $sheet->getStyle('A' . $this->currentRow . ':P' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('A' . $this->currentRow . ':P' . $this->currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('A' . $this->currentRow . ':P' . $this->currentRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Enable text wrapping for all cells in this row
        $sheet->getStyle('A' . $this->currentRow . ':P' . $this->currentRow)
                    ->getAlignment()
                    ->setWrapText(true);

        // Set row height to auto
        $this->setRowHeight($sheet, $this->currentRow);

        $this->currentRow++;
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

    private function monthlyDeseases($sheet){
        $row = $this->currentRow += 2;

        $sheet->mergeCells("A{$row}:D{$row}");
        $sheet->setCellValue("A{$row}", "Deseases Recorded this Month");
        $sheet->setCellValue("E{$row}", "No. of Cases");
        $sheet->mergeCells("F{$row}:H{$row}");
        $sheet->setCellValue("F{$row}", "Treatment");
        
        // Frequency
        $sheet->mergeCells("K{$row}:L{$row}");
        $sheet->setCellValue("K{$row}", "Frequency Rate");
        $sheet->mergeCells("M{$row}:N{$row}");
        $sheet->setCellValue("M{$row}", "Severity Rate");
        $sheet->mergeCells("O{$row}:P{$row}");
        $sheet->setCellValue("O{$row}", "Incindent Rate");


        $sheet->getRowDimension($row)->setRowHeight(20); 
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("E{$row}:H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$row}:H{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$row}:H{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light green background
            ],
        ]);

        $sheet->getStyle("K{$row}:P{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("K{$row}:P{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("K{$row}:P{$row}")->getFont()->setBold(true);
        $sheet->getStyle("K{$row}:P{$row}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light green background
            ],
        ]);

        $this->getDeseases($sheet, $row);
    }

    private function getDeseases($sheet, $row){
        $this->currentRow = $row + 1;
        $injuredPersonnel = $this->filters['injuredPersonnel'];

        // Frequency
        $frequencyRate = ($this->cumulative['Lost Time Accident (Non-Fatal)'] + 
                          $this->cumulative['Lost Time Accident (Fatal)']) / 
                          $this->cumulative['Manhours Worked'] * 1000000;

        $severityRate = $this->cumulative['Days Lost'] / 
                        $this->cumulative['Manhours Worked'] * 1000000;

        $incidentRate = ($this->cumulative['Non-Lost Time Accident'] + 
                        $this->cumulative['Lost Time Accident (Non-Fatal)'] +
                        $this->cumulative['Lost Time Accident (Fatal)']) * 200000 / 
                        $this->cumulative['Manhours Worked'];

        $sheet->mergeCells("K{$this->currentRow}:L{$this->currentRow}");
        $sheet->setCellValue("K{$this->currentRow}", number_format((float)$frequencyRate,2, '.', ','));
        $sheet->mergeCells("M{$this->currentRow}:N{$this->currentRow}");
        $sheet->setCellValue("M{$this->currentRow}", number_format((float)$severityRate,2, '.', ','));
        $sheet->mergeCells("O{$this->currentRow}:P{$this->currentRow}");
        $sheet->setCellValue("O{$this->currentRow}", number_format((float)$incidentRate,2, '.', ','));

        $sheet->getStyle('K' . $this->currentRow . ':P' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('K' . $this->currentRow . ':P' . $this->currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('K' . $this->currentRow . ':P' . $this->currentRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Process deseases
        foreach ($injuredPersonnel['monthlyDeseases'] as $desease) {
            $this->addDeseaseRow($sheet, $desease);
        }
    }

    private function addDeseaseRow($sheet, $desease){
        $sheet->mergeCells("A{$this->currentRow}:D{$this->currentRow}");
        $sheet->setCellValue("A{$this->currentRow}", $desease->desease);
        $sheet->setCellValue("E{$this->currentRow}", $desease->no_of_cases);
        $sheet->mergeCells("F{$this->currentRow}:H{$this->currentRow}");
        $sheet->setCellValue("F{$this->currentRow}", $desease->response);

        
        // Apply styling
        $sheet->getStyle('A' . $this->currentRow . ':H' . $this->currentRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A' . $this->currentRow . ':H' . $this->currentRow)->getAlignment()->setVertical(Alignment::VERTICAL_TOP);
        $sheet->getStyle('A' . $this->currentRow . ':H' . $this->currentRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ]);

        // Enable text wrapping for all cells in this row
        $sheet->getStyle('A' . $this->currentRow . ':H' . $this->currentRow)
                    ->getAlignment()
                    ->setWrapText(true);

        // Set row height to auto
        $sheet->getRowDimension($this->currentRow)->setRowHeight(-1);

        $this->currentRow++;
    }

    private function quarterEmergencyDrill($sheet){
        $formatDate = function($value) {
            $date = Carbon::parse($value)->format('m/d/Y');
            return $date;
        };
        $row = $this->currentRow += 2;
        $drillReports = $this->filters['quarterlyEmergencyReports'];

        $sheet->mergeCells("A{$row}:B{$row}");
        $sheet->setCellValue("A{$row}", "Quarter");
        $sheet->mergeCells("C{$row}:F{$row}");
        $sheet->setCellValue("C{$row}", "Emergency Drill Conducted");
        $sheet->mergeCells("G{$row}:H{$row}");
        $sheet->setCellValue("G{$row}", "Date Uploaded");

        $sheet->getRowDimension($row)->setRowHeight(20); 
        $sheet->getStyle("A{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("C{$row}:H{$row}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$row}:H{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$row}:H{$row}")->getFont()->setBold(true);
        $sheet->getStyle("A{$row}:H{$row}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'], // Black color
                ],
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'color' => ['argb' => 'FFC1F0C8'], // Light green background
            ],
        ]);

        $row++;
        $start = $row;
        $data = $row;
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue("A{$row}", "1st");
            $sheet->mergeCells("C{$row}:F{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");
        $row++;
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue("A{$row}", "2nd");
            $sheet->mergeCells("C{$row}:F{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");
        $row++;
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue("A{$row}", "3rd");
            $sheet->mergeCells("C{$row}:F{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");
        $row++;
            $sheet->mergeCells("A{$row}:B{$row}");
            $sheet->setCellValue("A{$row}", "4th");
            $sheet->mergeCells("C{$row}:F{$row}");
            $sheet->mergeCells("G{$row}:H{$row}");

        if($drillReports){
            foreach($drillReports as $report){
                switch($report->quarter){
                    case 1:
                        $sheet->setCellValue("C{$data}", $report->type_of_emergency_drill);
                        $sheet->setCellValue("G{$data}", $formatDate($report->date_uploaded));
                        break;
                    case 2:
                        $oldData = $data;
                        $data++;
                        $sheet->setCellValue("C{$data}", $report->type_of_emergency_drill);
                        $sheet->setCellValue("G{$data}", $formatDate($report->date_uploaded));
                        $data = $oldData;
                        break;
                    case 3:
                        $oldData = $data;
                        $data+=2;
                        $sheet->setCellValue("C{$data}", $report->type_of_emergency_drill);
                        $sheet->setCellValue("G{$data}", $formatDate($report->date_uploaded));
                        $data = $oldData;
                        break;
                    case 4:
                        $oldData = $data;
                        $data+=3;
                        $sheet->setCellValue("C{$data}", $report->type_of_emergency_drill);
                        $sheet->setCellValue("G{$data}", $formatDate($report->date_uploaded));
                        $data = $oldData;
                        break;
                    default:
                        break;
                }
            }
        }

        $end = $start + 3;
        $sheet->getStyle("C{$start}:C{$end}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle("G{$start}:G{$end}")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$start}:H{$end}")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ]
        ]);
    }

}
