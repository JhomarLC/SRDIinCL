<?php

namespace App\Exports;

use App\Models\Province;
use App\Models\Speaker;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class SpeakerOverviewSheet implements
    FromCollection,
    WithCustomStartCell,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithDrawings,
    WithTitle
{
    protected $province, $date_from, $date_to;

    public function __construct($province = null, $date_from = null, $date_to = null)
    {
        $this->province = $province;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function collection()
    {
        $query = Speaker::with('speaker_topics');

        if ($this->province) {
            $query->whereHas('speaker_topics', function ($q) {
                $q->where('province_code', $this->province);
            });
        }

        return $query->get();
    }

    public function map($speaker): array
    {
        return [
            $speaker->full_name,
            $speaker->speaker_topics->count(),
            $speaker->overall_evaluation_score . ' (' . scoreLabel($speaker->overall_evaluation_score) . ')' ?? 'No evaluations',
            ucfirst($speaker->status),
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

                $this->applyCommonSheetLayout(
                    $e->sheet->getDelegate(),
                    'Speaker Overview',
                    [
                        'Full Name',
                        'Topics Count',
                        'Overall Evaluation Score',
                        'Status'
                    ]
                );

                // 📝 Optional: In the future, you can add merging or formatting here without overriding headers.
            }
        ];
    }

    public function startCell(): string
    {
        return 'A11';
    }

    public function drawings(): array
    {
        return commonDrawing();
    }

    public function title(): string
    {
        return 'Speakers';
    }

    public function headings(): array
    {
        return ['Full Name', 'Topics Count', 'Overall Evaluation Score', 'Status'];
    }

    use SpeakerSheetLayoutTrait; // We'll define this reusable trait below!
}
