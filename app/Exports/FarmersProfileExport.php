<?php

namespace App\Exports;

use App\Models\Participant;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class FarmersProfileExport implements
    FromCollection,
    WithCustomStartCell,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithDrawings
{
    protected ?string $province;
    protected ?string $startDate;
    protected ?string $endDate;

    public function __construct(?string $province = null, ?string $startDate = null, ?string $endDate = null)
    {
        $this->province  = $province;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        $q = Participant::with([
            'food_restrictions',
            'medical_conditions',
            'trainings',
            'farming_data',
            'emergency_contact',
            'training_results',
        ]);

        if ($this->province) {
            $q->where('province_code', $this->province);
        }
        if ($this->startDate && $this->endDate) {
            $q->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $q->get();
    }

    public function map($p): array
    {
        return [
            $p->full_name,
            $p->phone_number,
            $p->gender,
            $p->civil_status,
            $p->full_address,
            $p->food_restrictions->pluck('food_restriction')->implode(', '),
            $p->medical_conditions->pluck('medical_condition')->implode(', '),
            // $p->trainings
            //     ->map(fn($t) => $t->training_title . ' (' . optional($t->training_date?->format('Y'))->format('Y') . ')')
            //     ->implode('; '),
            $p->trainings->map(function ($t) {
                return $t->training_title . ' (' . optional($t->training_date)->format('Y') . ')';
            })->implode('; '),
            $p->farming_data
                ->map(fn($fd) => $fd->season . ' - ' . $fd->year_training_conducted)
                ->implode('; '),
            optional($p->emergency_contact)->full_name
                . ' (' . optional($p->emergency_contact)->contact_number . ')',
            optional($p->training_results)->training_title_main
                . ' – Gain: ' . optional($p->training_results)->gain_in_knowledge,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [7 => ['font' => ['bold' => true]]];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $e) {
                /** @var Worksheet $sheet */
                $sheet = $e->sheet->getDelegate();

                //
                // 1) Merge H1:J1 and set height for the logo row
                //
                $sheet->mergeCells('A1:K1');
                $sheet->getRowDimension(1)->setRowHeight(90);

                //
                // 2) Organization header (rows 2–3)
                //
                // $sheet
                //     ->mergeCells('A2:K2')->setCellValue('A2','Philippine Rice Research Institute');
                // $sheet->getStyle('A2')->getFont()->setSize(16)->setBold(true);
                // $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                $sheet
                    ->mergeCells('A2:K2')->setCellValue('A2','Central Experiment Station');
                $sheet->getStyle('A2')->getFont()->setSize(12);
                $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');

                $sheet
                    ->mergeCells('A3:K3')->setCellValue('A3','Maligaya, Science City of Muñoz, 3119 Nueva Ecija');
                $sheet->getStyle('A3')->getFont()->setSize(12);
                $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');

                //
                // 3) Title & timestamp (rows 5–6)
                //
                $sheet
                    ->mergeCells('A5:K5')->setCellValue('A5','Farmers Profile Report');
                $sheet->getStyle('A5')->getFont()->setSize(14)->setBold(true);
                $sheet->getStyle('A5')->getAlignment()->setHorizontal('center');

                $sheet
                    ->mergeCells('A6:K6')->setCellValue('A6','Report generated at '.now()->format('F d, Y H:i:s'));
                $sheet->getStyle('A6')->getAlignment()->setHorizontal('center');

                //
                // 4) Column headers (row 7)
                //
                $cols = [
                    'A7'=>'Full Name','B7'=>'Phone Number','C7'=>'Gender',
                    'D7'=>'Civil Status','E7'=>'Address','F7'=>'Food Restrictions',
                    'G7'=>'Medical Conditions','H7'=>'Trainings Attended',
                    'I7'=>'Farm Data','J7'=>'Emergency Contact','K7'=>'Training Result',
                ];
                foreach ($cols as $cell=>$text) {
                    $sheet->setCellValue($cell,$text);
                }
                $sheet->getStyle('A7:K7')->getFont()->setBold(true);

                //
                // 5) Conditional formatting from row 8 onward
                //
                $max = $sheet->getHighestRow();
                for ($r=8; $r<=$max; $r++) {
                    $v = $sheet->getCell("K{$r}")->getValue();
                    if (empty($v) || trim($v)==='-') {
                        $sheet->getStyle("A{$r}:K{$r}")
                              ->getFill()
                              ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                              ->getStartColor()
                              ->setRGB('FFFF99');
                    }
                }
            },
        ];
    }

    /**
     * Tell the exporter to begin mapped rows at A9.
     */
    public function startCell(): string
    {
        return 'A8';
    }

    /**
     * Place your logo into the merged H1:J1 block.
     */
    public function drawings(): array
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('PhilRice Logo');
        $drawing->setPath(public_path('images/philrice-logo.png'));
        $drawing->setHeight(100);

        // anchor at the middle of A1:K1
        $drawing->setCoordinates('H1');
        // no horizontal offset so it’s exactly centered
        $drawing->setOffsetX(0);
        // keep your vertical nudge if you like
        $drawing->setOffsetY(10);
        return [$drawing];
    }

}
