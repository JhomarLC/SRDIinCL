<?php
namespace App\Exports;

use App\Models\TrainingEvaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
class TrainingEvaluationsSheet implements FromCollection, WithMapping, WithTitle, WithCustomStartCell, ShouldAutoSize, WithStyles, WithDrawings
{
    use TrainingSheetLayoutTrait;

    protected $province, $date_from, $date_to, $event_id;

    public function __construct($province = null, $date_from = null, $date_to = null, $event_id = null)
    {
        $this->province = $province;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->event_id = $event_id;
    }

    public function collection()
    {
        return TrainingEvaluation::with([
            'training_event.province', 'training_event.municipality', 'training_event.barangay',
            'training_content_evaluation', 'course_management_evaluation', 'overall_training_assessment', 'training_participant_info'
        ])
            ->when($this->event_id, fn($q) => $q->where('training_event_id', $this->event_id))
            ->when($this->province, fn($q) => $q->whereHas('training_event', fn($q2) => $q2->where('province_code', $this->province)))
            ->get();
    }

    public function map($evaluation): array
    {
        $event = $evaluation->training_event;
        $content = $evaluation->training_content_evaluation;
        $course = $evaluation->course_management_evaluation;
        $overall = $evaluation->overall_training_assessment;
        $participant = $evaluation->training_participant_info;
        $contentScore = optional($content)->overall_score;
        $courseScore = optional($course)->overall_score;

        $finalAverage = ($contentScore && $courseScore)
            ? round(($contentScore + $courseScore) / 2, 2)
            : ($contentScore ?? $courseScore ?? null);

        return [
            $event->training_title,
            $event->formatted_training_date,
            $event->full_address,

            optional($participant)->full_name ?? 'Anonymous',
            optional($participant)->age_group ?? '',
            optional($participant)->sex ?? '',
            optional($participant)->province?->name ?? '',
            optional($participant)->primary_sector ?? '',

            // Content Evaluation
            $content->objective_score ?? '',
            $content->objective_comment ?? '',
            $content->relevance_score ?? '',
            $content->relevance_comment ?? '',
            $content->content_completeness_score ?? '',
            $content->content_completeness_comment ?? '',
            $content->lecture_hands_on_score ?? '',
            $content->lecture_hands_on_comment ?? '',
            $content->sequence_score ?? '',
            $content->sequence_comment ?? '',
            $content->duration_score ?? '',
            $content->duration_comment ?? '',
            $content->assessment_method_score ?? '',
            $content->assessment_method_comment ?? '',
            $content->low_score_comment_1 ?? '',

            // Course Management
            $course->coordination_score ?? '',
            $course->time_management_score ?? '',
            $course->speaker_quality_score ?? '',
            $course->facilitators_score ?? '',
            $course->support_staff_score ?? '',
            $course->materials_score ?? '',
            $course->facility_score ?? '',
            $course->accommodation_score ?? '',
            $course->food_quality_score ?? '',
            $course->transportation_score ?? '',
            $course->overall_management_score ?? '',
            $course->low_score_comment_2 ?? '',

            // Overall Assessment
            $overall->goal_achievement ?? '',
            $overall->overall_quality ?? '',
            $overall->recommend_training ? 'Yes' : 'No',
            $overall->recommendation_reason ?? '',
            $overall->additional_feedback_or_suggestions ?? '',
            $overall->preferred_future_trainings ?? '',

            $contentScore ? $contentScore . ' (' . scoreLabel($contentScore) . ')' : 'N/A',
            $courseScore ? $courseScore . ' (' . scoreLabel($courseScore) . ')' : 'N/A',
            $finalAverage ? $finalAverage . ' (' . scoreLabel($finalAverage) . ')' : 'N/A',

            ucfirst($evaluation->status),
        ];
    }


    public function title(): string
    {
        return 'Training Evaluations';
    }

    public function startCell(): string
    {
        return 'A11';
    }

    public function styles(Worksheet $sheet): array
    {
        $this->applyCommonSheetLayout($sheet, 'Training Evaluation Details', [
            'Title', 'Date', 'Address',
            'Participant Name', 'Age Group', 'Sex', 'Province', 'Sector',

            'Objective Score', 'Objective Comment',
            'Relevance Score', 'Relevance Comment',
            'Content Completeness Score', 'Content Completeness Comment',
            'Lecture/Hands-on Score', 'Lecture/Hands-on Comment',
            'Sequence Score', 'Sequence Comment',
            'Duration Score', 'Duration Comment',
            'Assessment Method Score', 'Assessment Method Comment',
            'Low Score Comment 1',

            'Coordination Score', 'Time Management', 'Speaker Quality',
            'Facilitators', 'Support Staff', 'Materials', 'Facility',
            'Accommodation', 'Food Quality', 'Transportation',
            'Overall Management Score', 'Low Score Comment 2',

            'Goal Achievement', 'Overall Quality',
            'Recommend Training?', 'Recommendation Reason',
            'Additional Feedback', 'Preferred Future Trainings',

            'Content Overall Score',
            'Course Overall Score',
            'Final Average Score',

            'Status'
        ]
    );
        return [10 => ['font' => ['bold' => true]
        ]];
    }

    public function drawings(): array
    {
        return commonDrawing();
    }

}
