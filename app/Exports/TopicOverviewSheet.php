<?php

namespace App\Exports;

use App\Models\Province;
use App\Models\SpeakerTopic;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;

class TopicOverviewSheet implements
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
        $query = SpeakerTopic::with('speaker');

        if ($this->province) {
            $query->where('province_code', $this->province);
        }

        if ($this->date_from && $this->date_to) {
            $query->whereBetween('topic_date', [$this->date_from, $this->date_to]);
        }

        return $query->get();
    }

    public function map($topic): array
    {
        return [
            $topic->speaker->full_name,
            $topic->province->name,
            $topic->municipality->name,
            $topic->barangay->name,
            $topic->topic_discussed,
            $topic->formatted_topic_date,
            $topic->average_evaluation_score . ' (' . scoreLabel($topic->average_evaluation_score) . ')' ?? 'No evaluations',
            ucfirst($topic->status),
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

                // 1️⃣ — Header layout
                $this->applyCommonSheetLayout(
                    $e->sheet->getDelegate(),
                    'Topics Overview',
                    [
                        'Speaker',
                        'Province',
                        'Municipality',
                        'Barangay',
                        'Topic',
                        'Date',
                        'Overall Evaluation',
                        'Status',
                    ]
                );

                $sheet = $e->sheet->getDelegate();
                $data = $this->collection();
                $rowStart = 11;

                /** ------------------- MERGE SPEAKER ------------------- */
                $lastSpeaker = null;
                $mergeStartSpeaker = $rowStart;

                /** ------------------- MERGE TOPIC + DATE ------------------- */
                $lastTopicKey = null;
                $mergeStartTopic = $rowStart;

                foreach ($data as $index => $topic) {
                    $currentRow = $rowStart + $index;
                    $speaker = $topic->speaker->full_name;
                    $topicTitle = $topic->topic_discussed;
                    $date = $topic->formatted_topic_date;

                    /** --- MERGE SPEAKER --- */
                    if ($lastSpeaker === null) {
                        $lastSpeaker = $speaker;
                        $mergeStartSpeaker = $currentRow;
                    } elseif ($speaker !== $lastSpeaker) {
                        if ($mergeStartSpeaker !== $currentRow - 1) {
                            $sheet->mergeCells("A{$mergeStartSpeaker}:A".($currentRow - 1));
                            $sheet->getStyle("A{$mergeStartSpeaker}:A".($currentRow - 1))
                                ->getAlignment()->setHorizontal('center')->setVertical('center');
                        }
                        $lastSpeaker = $speaker;
                        $mergeStartSpeaker = $currentRow;
                    }

                    /** --- MERGE TOPIC + DATE --- */
                    $topicKey = $topicTitle . '|' . $date; // treat Topic+Date as a pair
                    if ($lastTopicKey === null) {
                        $lastTopicKey = $topicKey;
                        $mergeStartTopic = $currentRow;
                    } elseif ($topicKey !== $lastTopicKey) {
                        if ($mergeStartTopic !== $currentRow - 1) {
                            // Merge Topic (B)
                            $sheet->mergeCells("B{$mergeStartTopic}:B".($currentRow - 1));
                            $sheet->getStyle("B{$mergeStartTopic}:B".($currentRow - 1))
                                ->getAlignment()->setHorizontal('center')->setVertical('center');

                            // Merge Date (C)
                            $sheet->mergeCells("C{$mergeStartTopic}:C".($currentRow - 1));
                            $sheet->getStyle("C{$mergeStartTopic}:C".($currentRow - 1))
                                ->getAlignment()->setHorizontal('center')->setVertical('center');
                        }
                        $lastTopicKey = $topicKey;
                        $mergeStartTopic = $currentRow;
                    }
                }

                /** --- Merge remaining groups --- */
                $endRow = $rowStart + $data->count() - 1;

                if ($mergeStartSpeaker !== $endRow) {
                    $sheet->mergeCells("A{$mergeStartSpeaker}:A{$endRow}");
                    $sheet->getStyle("A{$mergeStartSpeaker}:A{$endRow}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');
                }

                if ($mergeStartTopic !== $endRow) {
                    $sheet->mergeCells("B{$mergeStartTopic}:B{$endRow}");
                    $sheet->getStyle("B{$mergeStartTopic}:B{$endRow}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');

                    $sheet->mergeCells("C{$mergeStartTopic}:C{$endRow}");
                    $sheet->getStyle("C{$mergeStartTopic}:C{$endRow}")
                        ->getAlignment()->setHorizontal('center')->setVertical('center');
                }

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
        return 'Topics';
    }

    use SpeakerSheetLayoutTrait;
}
