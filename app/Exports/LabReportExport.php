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

class LabReportExport implements FromCollection, WithHeadings, ShouldAutoSize, WithDefaultStyles, WithStyles
{
    protected $data;
    protected $from;
    protected $to;
    protected $total_cost;

    public function __construct($data, $from = null, $to = null)
    {
        $this->data = $data;
        $this->from = $from;
        $this->to = $to;
        $this->total_cost = $data->filter(function ($item) {
            return is_numeric($item['cost']); // Include only numeric values
        })->sum('cost');
    }

    public function styles(Worksheet $sheet)
    {
        // Set page layout to fit content on one page
        $sheet->getPageSetup()
            ->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE) // Landscape orientation
            ->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4) // A4 paper size
            ->setFitToWidth(1) // Fit to one page wide
            ->setFitToHeight(0); // Unlimited height (useful for long tables)

        // Set margins
        $sheet->getPageMargins()
            ->setTop(0.5) // Top margin (in inches)
            ->setBottom(0.5)
            ->setLeft(0.3)
            ->setRight(0.3);

        // Center horizontally
        $sheet->getPageSetup()
            ->setHorizontalCentered(true);

        if (auth()->user()->is_doctor) {
            return $this->styleForDoctor($sheet);
        }

        return $this->styleForAdmin($sheet);
    }

    private function styleForDoctor(Worksheet &$sheet)
    {
        // Style header row
        $sheet->getStyle("A3:K3")->applyFromArray([
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
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->mergeCells('A2:K2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->mergeCells("A{$lastRow}:K{$lastRow}"); // Merge first four cells in total row
        $sheet->setCellValue("A{$lastRow}", 'Total'); // Write "Total" directly in the merged cell
        $sheet->getStyle("A{$lastRow}:K{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->getStyle("E{$lastRow}:K{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->getStyle("A2:K2")->applyFromArray([
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
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->mergeCells("A{$lastRow}:K{$lastRow}"); // Merge first four cells in total row
        $sheet->setCellValue("A{$lastRow}", 'Total'); // Write "Total" directly in the merged cell
        $sheet->getStyle("A{$lastRow}:K{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
        $sheet->getStyle("E{$lastRow}:K{$lastRow}")->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 18,
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
            'font' => [
                'size' => 18,
            ],
        ];
    }

    public function collection()
    {
        $data = [];
        $i = 1;

        foreach ($this->data as $order) {
            $data[] = [
                'No.' => $i,
                'Order Date' => $order->created_at->format("d-m-Y"),
                'Patient Id' => $order->patient->code,
                'Patient' => $order->patient->name,
                'Work' => $order->work,
                'Extra Data' => collect($order->custom_data)
                    ->filter() // Remove null values
                    ->map(function ($data) {
                        return $data['name'] . ": " . $data['value'];
                    })
                    ->implode(', '),
                'Tooth' => $order->tooth,
                'Lab' => $order->lab->name,
                'Received Date' => $order->received?->format("d-m-Y"),
                'Done' => $order->done ? "YES" : "NO",
                'Cost' => $order->cost,
            ];
            $i++;
        }

        // Add total row with "Total" text directly in the merged cell
        $data[] = [
            'No.' => "",
            'Order Date' => "",
            'Patient Id' => "",
            'Patient' => "",
            'Work' => "",
            'Extra Data' => "",
            'Tooth' => "",
            'Lab' => "",
            'Received Date' => "",
            'Done' => "",
            'Cost' => $this->total_cost,
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
                    '',
                    '',
                    '',
                    '',
                    '' // Merging to span across 6 columns
                ],
                [
                    'No.',
                    'Order Date',
                    'Patient Id',
                    'Patient',
                    'Work',
                    'Extra Data',
                    'Tooth',
                    'Lab',
                    'Received Date',
                    'Done',
                    'Cost',
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
                '',
                '',
                '',
                '',
                '' // Merging to span across 6 columns
            ],
            [
                'No.',
                'Order Date',
                'Patient Id',
                'Patient',
                'Work',
                'Extra Data',
                'Tooth',
                'Lab',
                'Received Date',
                'Done',
                'Cost',
            ],
        ];
    }
}
