<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;

class PdfTemplateService
{
    public function fillPdfTemplate($templatePath, $outputPath, $data)
    {
        // Initialize FPDI
        $pdf = new Fpdi();

        // Load the template
        $pdf->AddPage();
        $pdf->setSourceFile($templatePath);
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);

        // Set font for the text
        $pdf->SetFont('Arial', '', 12);

        // Insert data into specific coordinates
        $pdf->SetXY(50, 50); // Adjust coordinates (x, y) for name
        $pdf->Write(0, $data['name']);

        $pdf->SetXY(50, 70); // Adjust coordinates for address
        $pdf->Write(0, $data['address']);

        $pdf->SetXY(50, 90); // Adjust coordinates for position
        $pdf->Write(0, $data['position']);

        $pdf->SetXY(50, 110); // Adjust coordinates for qualification
        $pdf->Write(0, $data['qualification']);

        // Save the output file
        $pdf->Output($outputPath, 'F');

        return $outputPath;
    }
}
