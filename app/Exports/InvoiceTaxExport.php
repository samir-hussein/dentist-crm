<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Style;

class InvoiceTaxExport implements FromCollection, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles
{
    protected $data;
    protected $from;
    protected $to;
    protected $total_fees;
    protected $total_paid;

    public function __construct($data, $from = null, $to = null)
    {
        $this->data = $data;
        $this->from = $from;
        $this->to = $to;
        $this->total_fees = $data->sum("fees");
        $this->total_paid = $data->sum("paid");
    }

    public function styles(Worksheet $sheet)
    {
        if (auth()->user()->is_doctor) {
            return $this->styleForDoctor($sheet);
        }

        return $this->styleForAdmin($sheet);
    }

    private function styleForDoctor(Worksheet &$sheet)
    {
        // Style header row
        $sheet->getStyle("A3:G3")->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_DARKGREEN],
            ],
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
        ]);

        // Merge cells for the period row (row 1)
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);

        // Merge cells for the period row (row 1)
        $sheet->mergeCells('A2:G2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);

        // Style total row
        $lastRow = $this->data->count() + 4; // Adjust for headings and total row
        $sheet->mergeCells("A{$lastRow}:E{$lastRow}"); // Merge first four cells in total row
        $sheet->setCellValue("A{$lastRow}", 'Total'); // Write "Total" directly in the merged cell
        $sheet->getStyle("A{$lastRow}:E{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Align "Total" text to the left
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);

        // Apply style for the total fees and paid columns (E and F)
        $sheet->getStyle("E{$lastRow}:G{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);
    }

    private function styleForAdmin(Worksheet &$sheet)
    {
        // Style header row
        $sheet->getStyle("A2:G2")->applyFromArray([
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => Color::COLOR_DARKGREEN],
            ],
            'font' => [
                'name' => 'Arial',
                'bold' => true,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
        ]);

        // Merge cells for the period row (row 1)
        $sheet->mergeCells('A1:G1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);

        // Style total row
        $lastRow = $this->data->count() + 3; // Adjust for headings and total row
        $sheet->mergeCells("A{$lastRow}:E{$lastRow}"); // Merge first four cells in total row
        $sheet->setCellValue("A{$lastRow}", 'Total'); // Write "Total" directly in the merged cell
        $sheet->getStyle("A{$lastRow}:E{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, // Align "Total" text to the left
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);

        // Apply style for the total fees and paid columns (E and F)
        $sheet->getStyle("E{$lastRow}:G{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 14,
                'color' => [
                    'rgb' => 'FFFFFF'
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => [
                    'argb' => Color::COLOR_DARKGREEN,
                ],
            ],
        ]);
    }

    public function defaultStyles(Style $defaultStyle)
    {
        return [
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ];
    }

    public function collection()
    {
        $data = [];
        $i = 1;

        foreach ($this->data as $invoice) {
            $data[] = [
                'No.' => $i,
                'Name' => $invoice->patient->name,
                'Invoice No.' => $invoice->id,
                'Date' => $invoice->created_at->format('Y-m-d'),
                'Treatment' => $invoice->treatment,
                'Fees' => $invoice->fees,
                'Paid' => $invoice->paid,
            ];
            $i++;
        }

        // Add total row with "Total" text directly in the merged cell
        $data[] = [
            'No.' => '',  // Empty cell
            'Name' => '',         // Keep this empty; "Total" will be set in styles method
            'Invoice No.' => '',  // Empty cell
            'Date' => '',         // Empty cell
            'Treatment' => '',    // Empty cell
            'Fees' => $this->total_fees, // Total Fees
            'Paid' => $this->total_paid, // Total Paid
        ];

        return collect($data);
    }

    public function headings(): array
    {
        $period = "Period : " . ($this->from ?? 'N/A') . " to " . ($this->to ?? 'N/A');

        if (auth()->user()->is_doctor) {
            return [
                [
                    auth()->user()->name,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '' // Merging to span across 6 columns
                ],
                [
                    $period,
                    '',
                    '',
                    '',
                    '',
                    '',
                    '' // Merging to span across 6 columns
                ],
                [
                    'No.',
                    'Name',
                    'Invoice No.',
                    'Date',
                    'Treatment',
                    'Fees',
                    'Paid',
                ],
            ];
        }

        return [
            [
                $period,
                '',
                '',
                '',
                '',
                '',
                '' // Merging to span across 6 columns
            ],
            [
                'No.',
                'Name',
                'Invoice No.',
                'Date',
                'Treatment',
                'Fees',
                'Paid',
            ],
        ];
    }
}
