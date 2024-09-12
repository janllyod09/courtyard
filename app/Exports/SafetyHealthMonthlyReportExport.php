<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Illuminate\Support\Collection;

class SafetyHealthMonthlyReportExport implements FromCollection, WithEvents
{
    use Exportable;

    protected $filters;

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
            },
        ];
    }

    private function addCustomHeader(BeforeSheet $event){
        $sheet = $event->sheet;

        // Add custom header
        $sheet->mergeCells('A1:P1');
        $sheet->setCellValue('A1', "MGAR CP PORTAL");

        $sheet->mergeCells('A2:P2');
        $sheet->setCellValue('A2', "SAFETY AND HEALTH REPORT FOR THE MONTH OF " .  strtoupper($this->filters['monthYear']));
        $sheet->mergeCells('A3:P3');

        // Apply some basic styling
        $sheet->getStyle('A1:P3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1:P3')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:A3')->getFont()->setBold(true);
        $sheet->getStyle('A1:P3')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_NONE);
        $sheet->getStyle('A4:P4')->getFont()->setBold(true);
        $sheet->getStyle('2:2')->getFont()->setSize(16);

        $sheet->getStyle('A4:P4')->applyFromArray([
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
    public function collection(){
        return new Collection();
    }

    // public function collection(){
    //     $formatDate = function($value) {
    //         $date = Carbon::parse($value)->format('F d, Y');
    //         return $date;
    //     };

    //     $formatCurrency = function($value) {
    //         if($value == 0 || $value == null){
    //             return "-";
    //         }
    //         return '₱ ' . number_format((float)$value, 2, '.', ',');
    //     };

    //     return $this->filters['organizations']->get()
    //         ->map(function ($user) use ($formatDate, $formatCurrency) {
    //             $this->rowNumber++;
    //             $sg_step = null;
    //             $cosTag = "";
    //             if($user->plantilla_sg_step){
    //                 $sg_step = $user->plantilla_sg_step;
    //             }else if($user->cos_reg_sg_step){
    //                 $sg_step = $user->cos_reg_sg_step;
    //                 $cosTag = " - Regular";
    //             }else if($user->cos_sk_sg_step){
    //                 $sg_step = $user->cos_sk_sg_step;
    //                 $cosTag = " - SK";
    //             }else{
    //                 $sg_step = "-";
    //             }

    //             $rate = null;
    //             if($user->plantilla_rate){
    //                 $rate = $user->plantilla_rate;
    //             }else if($user->cos_reg_rate){
    //                 $rate = $user->cos_reg_rate;
    //             }else if($user->cos_sk_rate){
    //                 $rate = $user->cos_sk_rate;
    //             }

    //             $appointment = null;
    //             if($user->appointment != "cos" && $user->appointment != "ct"){
    //                 $appointment = explode(',', $user->appointment);
    //                 if($appointment[0] == 'pa'){
    //                     $appointment = 'Presidential Appointee';
    //                 }else{
    //                     $appointment = 'Plantilla';
    //                 }
    //             }else{
    //                 if($user->appointment == "ct"){
    //                     $appointment = 'Co-Terminus';
    //                 }else{
    //                     $appointment = 'COS' . $cosTag;
    //                 }
    //             }

    //             $status = null;
    //             switch($user->active_status){
    //                 case 0:
    //                     $status = 'Inactive';
    //                     break;
    //                 case 1:
    //                     $status = 'Active';
    //                     break;
    //                 case 2:
    //                     $status = 'Resigned';
    //                     break;
    //                 case 3:
    //                     $status = 'Retired';
    //                     break;
    //             }

    //             return [
    //                 $this->rowNumber,
    //                 'Name' => $user->name,
    //                 'Email' => $user->email,
    //                 'Employee ID' => $user->emp_code,
    //                 'Position' => $user->position,
    //                 'Appointment' => $appointment,
    //                 'Office/Division' => $user->office_division,
    //                 'Unit' => $user->unit ?: '-',
    //                 'SG/STEP' => $sg_step,
    //                 'Rate Per Month' => $formatCurrency($rate),
    //                 'Date Employed' => $formatDate($user->date_hired),
    //                 'Status' => $status,
    //             ];
    //         });
    // }
}
