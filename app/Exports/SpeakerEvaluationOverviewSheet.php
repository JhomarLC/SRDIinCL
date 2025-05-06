<?php

namespace App\Exports;

use App\Models\Province;
use App\Models\SpeakerEvaluation;
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

class SpeakerEvaluationOverviewSheet implements
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
        $query = SpeakerEvaluation::with('speaker_topic.speaker');

        if ($this->province) {
            $query->whereHas('speaker_topic', function ($q) {
                $q->where('province_code', $this->province);
            });
        }

        if ($this->date_from && $this->date_to) {
            $query->whereHas('speaker_topic', function ($q) {
                $q->whereBetween('topic_date', [$this->date_from, $this->date_to]);
            });
        }

        return $query
            ->orderBy('speaker_topic_id') // Sort by topic → ensures consistent grouping
            ->orderBy('id')
            ->get();
    }

    public function map($eval): array
    {
        return [
            $eval->speaker_topic->speaker->full_name,
            $eval->speaker_topic->topic_discussed,
            $eval->speaker_topic->formatted_topic_date,

            $eval->knowledge_score,
            $eval->teaching_method_score,
            $eval->audiovisual_score,
            $eval->clarity_score,
            $eval->question_handling_score,
            $eval->audience_connection_score,
            $eval->content_relevance_score,
            $eval->goal_achievement_score,

            $eval->overall_score . ' ('. scoreLabel($eval->overall_score) . ')',
            $eval->additional_feedback,
            ucfirst($eval->status),
            $eval->speaker_evaluation_info->full_name,
            $eval->speaker_evaluation_info->age_group,
            $eval->speaker_evaluation_info->disability_type,
            $eval->speaker_evaluation_info->tribe_name,
            $eval->speaker_evaluation_info->primary_sector,
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

                // 1️⃣ — Common header layout
                $this->applyCommonSheetLayout(
                    $e->sheet->getDelegate(),
                    'Evaluations Overview',
                    [
                        'Speaker',
                        'Topic',
                        'Date',
                        'Knowledge (K)',
                        'Teaching Method (TM)',
                        'Audio Visual (AV)',
                        'Clarity (C)',
                        'Question Handling (QH)',
                        'Audience Connection (AC)',
                        'Content Relevance (CR)',
                        'Goal Achievement (GA)',
                        'Average Score',
                        'Feedback',
                        'Status',
                        'Respondent',
                        'Age Group',
                        'Disability Type',
                        'Tribe Name',
                        'Primary Sector'
                    ]
                );

                // 2️⃣ — Merge speaker, topic and date cells
                $sheet = $e->sheet->getDelegate();
                $data = $this->collection();
                $rowStart = 11;

                $lastSpeaker = null;
                $lastTopic = null;
                $mergeStartSpeaker = $rowStart;
                $mergeStartTopic = $rowStart;

                foreach ($data as $index => $eval) {
                    $currentRow = $rowStart + $index;
                    $speaker = $eval->speaker_topic->speaker->full_name;
                    $topic = $eval->speaker_topic->topic_discussed;
                    $date = $eval->speaker_topic->formatted_topic_date;

                    /** ----------------- MERGE SPEAKER ------------------ */
                    if ($lastSpeaker === null) {
                        $lastSpeaker = $speaker;
                        $mergeStartSpeaker = $currentRow;
                    } elseif ($speaker !== $lastSpeaker) {
                        if ($mergeStartSpeaker !== $currentRow - 1) {
                            $sheet->mergeCells("A{$mergeStartSpeaker}:A".($currentRow - 1));
                            // Center
                            $sheet->getStyle("A{$mergeStartSpeaker}:A".($currentRow - 1))
                                ->getAlignment()
                                ->setHorizontal('center')
                                ->setVertical('center');
                        }
                        $lastSpeaker = $speaker;
                        $mergeStartSpeaker = $currentRow;
                    }

                    /** ----------------- MERGE TOPIC + DATE ------------------ */
                    $topicKey = $topic . '|' . $date; // treat topic+date as a pair
                    if ($lastTopic === null) {
                        $lastTopic = $topicKey;
                        $mergeStartTopic = $currentRow;
                    } elseif ($topicKey !== $lastTopic) {
                        if ($mergeStartTopic !== $currentRow - 1) {
                            // Merge Topic (B)
                            $sheet->mergeCells("B{$mergeStartTopic}:B".($currentRow - 1));
                            $sheet->getStyle("B{$mergeStartTopic}:B".($currentRow - 1))
                                ->getAlignment()
                                ->setHorizontal('center')
                                ->setVertical('center');

                            // Merge Date (C)
                            $sheet->mergeCells("C{$mergeStartTopic}:C".($currentRow - 1));
                            $sheet->getStyle("C{$mergeStartTopic}:C".($currentRow - 1))
                                ->getAlignment()
                                ->setHorizontal('center')
                                ->setVertical('center');
                        }
                        $lastTopic = $topicKey;
                        $mergeStartTopic = $currentRow;
                    }
                }

                // 📝 Final merge for last speaker group
                $endRow = $rowStart + $data->count() - 1;

                if ($mergeStartSpeaker !== $endRow) {
                    $sheet->mergeCells("A{$mergeStartSpeaker}:A{$endRow}");
                    $sheet->getStyle("A{$mergeStartSpeaker}:A{$endRow}")
                        ->getAlignment()
                        ->setHorizontal('center')
                        ->setVertical('center');
                }

                // 📝 Final merge for last topic group
                if ($mergeStartTopic !== $endRow) {
                    $sheet->mergeCells("B{$mergeStartTopic}:B{$endRow}");
                    $sheet->getStyle("B{$mergeStartTopic}:B{$endRow}")
                        ->getAlignment()
                        ->setHorizontal('center')
                        ->setVertical('center');

                    $sheet->mergeCells("C{$mergeStartTopic}:C{$endRow}");
                    $sheet->getStyle("C{$mergeStartTopic}:C{$endRow}")
                        ->getAlignment()
                        ->setHorizontal('center')
                        ->setVertical('center');
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
        return 'Evaluations';
    }

    use SpeakerSheetLayoutTrait;
}
