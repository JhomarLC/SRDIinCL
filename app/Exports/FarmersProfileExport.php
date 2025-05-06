<?php

namespace App\Exports;

use App\Models\Participant;
use App\Models\Province;
use App\Models\TrainingResults;
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
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class FarmersProfileExport implements
    FromCollection,
    WithCustomStartCell,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithDrawings,
    WithMultipleSheets,
    WithTitle
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
            $q->whereHas('training_results', function ($query) {
                $query->where('ts_province_code', $this->province);
            });
        }
           // Date range filter — both participant created_at and training_results.training_date_main
        if ($this->startDate && $this->endDate) {
            $q->whereHas('training_results', function ($query) {
                $query->whereBetween('training_date_main', [$this->startDate, $this->endDate]);
            });
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
                . ' – Gain in Knowledge: ' . optional($p->training_results)->gain_in_knowledge,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [9 => ['font' => ['bold' => true]]];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $e) {
                /** @var Worksheet $sheet */
                $sheet = $e->sheet->getDelegate();

                //
                // 0) Show Province and Date Range filters in rows 4 and 5
                //
                $provinceText = $this->province
                    ? ('Province: ' . (Province::where('code', $this->province)->value('name') ?? $this->province))
                    : 'Province: All Provinces';

                $dateRangeText = ($this->startDate && $this->endDate)
                    ? ('Date Range: ' . Carbon::parse($this->startDate)->format('F d, Y') . ' to ' . Carbon::parse($this->endDate)->format('F d, Y'))
                    : 'Date Range: All Dates';

                $sheet->mergeCells('A4:K4')->setCellValue('A4', $provinceText);
                $sheet->mergeCells('A5:K5')->setCellValue('A5', $dateRangeText);

                $sheet->getStyle('A4')->getFont()->setBold(true);
                $sheet->getStyle('A5')->getFont()->setBold(true);

                //
                // 1) Merge H1:J1 and set height for the logo row (you already have this)
                //
                $sheet->mergeCells('A1:K1');
                $sheet->getRowDimension(1)->setRowHeight(90);

                //
                // 2) Organization header (rows 2–3)
                //
                $sheet
                    ->mergeCells('A2:K2')->setCellValue('A2','Central Experiment Station');
                $sheet->getStyle('A2')->getFont()->setSize(12);

                $sheet
                    ->mergeCells('A3:K3')->setCellValue('A3','Maligaya, Science City of Muñoz, 3119 Nueva Ecija');
                $sheet->getStyle('A3')->getFont()->setSize(12);

                //
                // 3) Title & timestamp (rows 7-8 now)
                //
                $sheet
                    ->mergeCells('A7:K7')->setCellValue('A7','Farmers Profile Report');
                $sheet->getStyle('A7')->getFont()->setSize(14)->setBold(true);

                $sheet
                    ->mergeCells('A8:K8')->setCellValue('A8','Report generated at '.now()->format('F d, Y H:i:s A'));

                //
                // 4) Column headers (row 8)
                //
                $cols = [
                    'A10'=>'Full Name','B10'=>'Phone Number','C10'=>'Gender',
                    'D10'=>'Civil Status','E10'=>'Address','F10'=>'Food Restrictions',
                    'G10'=>'Medical Conditions','H10'=>'Trainings Attended',
                    'I10'=>'Farm Data','J10'=>'Emergency Contact','K10'=>'Training Result',
                ];
                foreach ($cols as $cell=>$text) {
                    $sheet->setCellValue($cell,$text);
                }
                $sheet->getStyle('A10:K10')->getFont()->setBold(true);

                //
                // 5) Conditional formatting from row 9 onward
                //
                $max = $sheet->getHighestRow();
                for ($r=11; $r<=$max; $r++) {
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
        return 'A11';
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
        $drawing->setCoordinates('A1');
        // no horizontal offset so it’s exactly centered
        $drawing->setOffsetX(0);
        // keep your vertical nudge if you like
        $drawing->setOffsetY(10);
        return [$drawing];
    }

    public function sheets(): array
    {
        $sheets = [];

        // If the user filtered by province → only one sheet
        if ($this->province) {
            $sheets[] = new FarmersProfileExport($this->province, $this->startDate, $this->endDate);
        } else {
            // No province filter → create a sheet for all data
            $sheets[] = new FarmersProfileExport(null, $this->startDate, $this->endDate);

            // Also create one sheet per province
            $provinces = TrainingResults::query()
                ->when($this->startDate && $this->endDate, function ($query) {
                    $query->whereBetween('training_date_main', [$this->startDate, $this->endDate]);
                })
                ->whereHas('participant') // Only provinces that have participants
                ->distinct()
                ->pluck('ts_province_code');

            foreach ($provinces as $province) {
                $sheets[] = new FarmersProfileExport($province, $this->startDate, $this->endDate);
            }
        }

        return $sheets;
    }


    public function title(): string
    {
        if ($this->province) {
            $provinceName = Province::where('code', $this->province)->value('name');
            return 'Province - ' . ($provinceName ?? $this->province);
        }
        return 'All Provinces';
    }
}
