<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Formateur;
use App\Models\Seance;

class FormularExport
{
    protected $formateur;
    protected $seances;
    protected $month;

    public function __construct(Formateur $formateur, $seances, $month)
    {
        $this->formateur = $formateur;
        $this->seances = $seances;
        $this->month = $month;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set column widths
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);

        // Add logo and header
        $sheet->mergeCells('A1:F2');
        $sheet->setCellValue('A1', 'AZROU CENTER');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Add box around trainer information
        $sheet->mergeCells('A4:F7');
        $boxContent = "Nom et prénom du formateur : " . $this->formateur->name . "\n";
        $boxContent .= "Matières enseignées : " . $this->formateur->subjects . "\n";
        $boxContent .= "Période : Du 01/" . str_pad($this->month, 2, '0', STR_PAD_LEFT) . "/2025 au " . 
                      date('t', strtotime('2025-' . $this->month . '-01')) . "/" . 
                      str_pad($this->month, 2, '0', STR_PAD_LEFT) . "/2025\n";
        $boxContent .= "Numéro du compte bancaire : " . $this->formateur->bank_account . "\n";
        $boxContent .= "CIH Bank (Agence Azrou)";
        
        $sheet->setCellValue('A4', $boxContent);
        $sheet->getStyle('A4')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A4:F7')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Table headers with gray background
        $headers = ['DATE', 'HEURE D\'ENTREE', 'HEURE DE SORTIE', 'NOMBRE D\'HEURES', 'PRIX / HEURE', 'Prix Global'];
        $sheet->getStyle('A9:F9')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
        
        $col = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($col . '9', $header);
            $sheet->getStyle($col . '9')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle($col . '9')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            $sheet->getStyle($col . '9')->getFont()->setBold(true);
            $col++;
        }

        // Data rows
        $row = 10;
        $totalHours = 0;
        foreach ($this->seances as $seance) {
            $sheet->setCellValue('A' . $row, date('d/m/Y', strtotime($seance->date)));
            $sheet->setCellValue('B' . $row, date('H:i', strtotime($seance->start_time)));
            $sheet->setCellValue('C' . $row, date('H:i', strtotime($seance->end_time)));
            $sheet->setCellValue('D' . $row, $seance->duration);
            $sheet->setCellValue('E' . $row, '30');
            $sheet->setCellValue('F' . $row, $seance->duration * 30);
            
            // Center align all cells
            $sheet->getStyle('A' . $row . ':F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            
            // Add borders
            $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
            
            $totalHours += $seance->duration;
            $row++;
        }

        // Total row
        $sheet->mergeCells('A' . $row . ':C' . $row);
        $sheet->setCellValue('A' . $row, 'Total');
        $sheet->mergeCells('D' . $row . ':E' . $row);
        $sheet->setCellValue('D' . $row, $totalHours . ' heures × 30 DH');
        $sheet->setCellValue('F' . $row, $totalHours * 30);
        $sheet->getStyle('A' . $row . ':F' . $row)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $sheet->getStyle('A' . $row . ':F' . $row)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row . ':F' . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Signatures
        $row += 3;
        $sheet->mergeCells('A' . $row . ':F' . $row);
        $sheet->setCellValue('A' . $row, 'Signatures :');
        $sheet->getStyle('A' . $row)->getFont()->setBold(true);

        $row++;
        $sheet->mergeCells('A' . $row . ':C' . $row);
        $sheet->mergeCells('D' . $row . ':F' . $row);
        $sheet->setCellValue('A' . $row, 'Centre d\'Azrou :');
        $sheet->setCellValue('D' . $row, 'Le formateur :');

        // Create Excel file
        $writer = new Xlsx($spreadsheet);
        $filename = 'formular_' . $this->formateur->id . '_' . $this->month . '.xlsx';
        $path = storage_path('app/public/' . $filename);
        $writer->save($path);

        return $filename;
    }
} 