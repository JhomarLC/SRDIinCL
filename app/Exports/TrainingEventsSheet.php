<?php

namespace App\Exports;

use App\Models\TrainingEvent;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
class TrainingEventsSheet implements FromCollection, WithMapping, WithTitle, WithCustomStartCell, ShouldAutoSize, WithStyles, WithDrawings
{
    use TrainingSheetLayoutTrait;

    protected $province, $date_from, $date_to;

    public function __construct($province = null, $date_from = null, $date_to = null)
    {
        $this->province = $province;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        return TrainingEvent::with(['province', 'municipality', 'barangay', 'evaluations.overall_training_assessment'])
            ->when($this->province, fn($q) => $q->where('province_code', $this->province))
            ->when($this->date_from && $this->date_to, fn($q) => $q->whereBetween('training_date', [$this->date_from, $this->date_to]))
            ->get();
    }

    public function map($event): array
    {
        return [
            $event->formatted_training_date,
            $event->training_title,
            $event->full_address,
            $event->most_common_goal_achievement,
            $event->most_common_overall_quality,
            ucfirst($event->status),
        ];
    }

    public function title(): string
    {
        return 'Training Events';
    }

    public function startCell(): string
    {
        return 'A11';
    }

    public function styles(Worksheet $sheet): array
    {
        $this->applyCommonSheetLayout($sheet, 'Training Events Overview', [
            'Training Date', 'Title', 'Address', 'Common Goal', 'Overall Quality', 'Status'
        ]);
        return [10 => ['font' => ['bold' => true]]];
    }
    public function drawings(): array
    {
        return commonDrawing();
    }
}
