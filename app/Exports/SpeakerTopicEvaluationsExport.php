<?php

namespace App\Exports;

use App\Models\SpeakerTopic;
use App\Models\Speaker;
use App\Models\SpeakerEvaluation;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;

class SpeakerTopicEvaluationsExport implements
    FromCollection,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithDrawings,
    WithCustomStartCell
{
    protected $topicId;
    protected $topic;
    protected $speaker;

    public function __construct($topicId)
    {
        $this->topic = SpeakerTopic::with('speaker')->findOrFail($topicId);
        $this->speaker = $this->topic->speaker;
        $this->topicId = $topicId;
    }

    public function collection()
    {
        return SpeakerEvaluation::with('speaker_evaluation_info')
            ->where('speaker_topic_id', $this->topicId)
            ->get();
    }

    public function map($eval): array
    {
        return [
            $eval->speaker_evaluation_info->full_name ?? 'N/A',
            $eval->overall_score . ' (' . scoreLabel($eval->overall_score) . ')',
            ucfirst($eval->status),
            $eval->knowledge_score,
            $eval->teaching_method_score,
            $eval->audiovisual_score,
            $eval->clarity_score,
            $eval->question_handling_score,
            $eval->audience_connection_score,
            $eval->content_relevance_score,
            $eval->goal_achievement_score,
            $eval->additional_feedback ?? 'None'
        ];
    }

    public function headings(): array
    {
        return [
            'Full Name',
            'Overall Score',
            'Status',
            'Knowledge',
            'Teaching Method',
            'Audio-Visual',
            'Clarity',
            'Question Handling',
            'Audience Connection',
            'Content Relevance',
            'Goal Achievement',
            'Additional Feedback'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            10 => ['font' => ['bold' => true]]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $e) {
                $sheet = $e->sheet->getDelegate();

                // Logo row
                $sheet->mergeCells('A1:L1');
                $sheet->getRowDimension(1)->setRowHeight(90);

                // Organization headers
                $sheet->mergeCells('A2:L2')->setCellValue('A2', 'Central Experiment Station');
                $sheet->getStyle('A2')->getFont()->setSize(12);

                $sheet->mergeCells('A3:L3')->setCellValue('A3', 'Maligaya, Science City of Muñoz, 3119 Nueva Ecija');
                $sheet->getStyle('A3')->getFont()->setSize(12);

                // Speaker and Topic rows
                $sheet->mergeCells('A4:L4')->setCellValue('A4', 'Speaker: ' . ($this->speaker->full_name ?? 'Unknown'));
                $sheet->getStyle('A4')->getFont()->setBold(true);

                $sheet->mergeCells('A5:L5')->setCellValue('A5', 'Topic: ' . ($this->topic->topic_discussed ?? 'Unknown'));
                $sheet->getStyle('A5')->getFont()->setBold(true);

                // Report Title
                $sheet->mergeCells('A7:L7')->setCellValue('A7', 'Speaker Topic Evaluations Report');
                $sheet->getStyle('A7')->getFont()->setSize(14)->setBold(true);

                // Timestamp
                $sheet->mergeCells('A8:L8')->setCellValue('A8', 'Generated at: ' . now()->format('F d, Y H:i:s A'));

                // Set column headers manually at row 10
                $headers = [
                    'A10' => 'Full Name',
                    'B10' => 'Overall Score',
                    'C10' => 'Status',
                    'D10' => 'Knowledge',
                    'E10' => 'Teaching Method',
                    'F10' => 'Audio-Visual',
                    'G10' => 'Clarity',
                    'H10' => 'Question Handling',
                    'I10' => 'Audience Connection',
                    'J10' => 'Content Relevance',
                    'K10' => 'Goal Achievement',
                    'L10' => 'Additional Feedback'
                ];

                foreach ($headers as $cell => $value) {
                    $sheet->setCellValue($cell, $value);
                }

                $sheet->getStyle('A10:L10')->getFont()->setBold(true);
            },
        ];
    }

    public function drawings(): array
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('PhilRice Logo');
        $drawing->setPath(public_path('images/philrice-logo.png'));
        $drawing->setHeight(100);
        $drawing->setCoordinates('A1');
        $drawing->setOffsetY(10);

        return [$drawing];
    }

    public function startCell(): string
    {
        return 'A11'; // Start data after header rows
    }
}
