<?php

namespace App\Exports;

use App\Models\Province;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

trait TrainingSheetLayoutTrait
{

    public function applyCommonSheetLayout($sheet, $reportTitle, $columnHeaders = [])
    {
        $provinceText = $this->province
            ? ('Province: ' . (Province::where('code', $this->province)->value('name') ?? $this->province))
            : 'Province: All Provinces';

        $dateRangeText = ($this->date_from && $this->date_to)
            ? ('Date Range: ' . Carbon::parse($this->date_from)->format('F d, Y') . ' to ' . Carbon::parse($this->date_to)->format('F d, Y'))
            : 'Date Range: All Dates';

        $sheet->mergeCells('A4:H4')->setCellValue('A4', $provinceText);
        $sheet->mergeCells('A5:H5')->setCellValue('A5', $dateRangeText);

        $sheet->getStyle('A4')->getFont()->setBold(true);
        $sheet->getStyle('A5')->getFont()->setBold(true);

        $sheet->mergeCells('A1:H1');
        $sheet->getRowDimension(1)->setRowHeight(90);

        $sheet->mergeCells('A2:H2')->setCellValue('A2','Central Experiment Station');
        $sheet->mergeCells('A3:H3')->setCellValue('A3','Maligaya, Science City of Muñoz, 3119 Nueva Ecija');

        $sheet->mergeCells('A7:H7')->setCellValue('A7', $reportTitle);
        $sheet->getStyle('A7')->getFont()->setSize(14)->setBold(true);

        $sheet->mergeCells('A8:H8')->setCellValue('A8','Report generated at '.now()->format('F d, Y H:i:s A'));

        // 🔥 Dynamic headers
        $colIndex = 'A';
        foreach ($columnHeaders as $header) {
            $sheet->setCellValue($colIndex.'10', $header);
            $colIndex++;
        }

        // Make headers bold
        $lastCol = chr(ord('A') + count($columnHeaders) - 1);
        $sheet->getStyle('A10:'.$lastCol.'10')->getFont()->setBold(true);
    }

}


// COMMON DRAWING function — helper
if (!function_exists('commonDrawing')) {
    function commonDrawing(): array
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('PhilRice Logo');
        $drawing->setPath(public_path('images/philrice-logo.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetX(0);
        $drawing->setOffsetY(10);

        return [$drawing];
    }
}
