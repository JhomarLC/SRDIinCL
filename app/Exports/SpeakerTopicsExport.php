<?php

namespace App\Exports;

use App\Models\SpeakerTopic;
use App\Models\Speaker;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class SpeakerTopicsExport implements
    FromCollection,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithDrawings,
    WithCustomStartCell
{
    protected $speakerId;
    protected $speakerName;

    public function __construct($speakerId)
    {
        $this->speakerId = $speakerId;
        $this->speakerName = Speaker::find($speakerId)?->full_name ?? 'Unknown Speaker';
    }

    public function collection()
    {
        return SpeakerTopic::with(['province', 'municipality', 'barangay'])
            ->where('speaker_id', $this->speakerId)
            ->get();
    }

    public function map($topic): array
    {
        return [
            $topic->topic_discussed,
            $topic->formatted_topic_date,
            $topic->province->name ?? 'N/A',
            $topic->municipality->name ?? 'N/A',
            $topic->barangay->name ?? 'N/A',
            $topic->average_evaluation_score
                ? $topic->average_evaluation_score . ' (' . scoreLabel($topic->average_evaluation_score) . ')'
                : 'No evaluations',
            ucfirst($topic->status),
        ];
    }

    public function headings(): array
    {
        return [
            'Topic Discussed',
            'Date',
            'Province',
            'Municipality',
            'Barangay',
            'Average Evaluation',
            'Status'
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            10 => ['font' => ['bold' => true]] // Bold headings at row 10
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $e) {
                /** @var Worksheet $sheet */
                $sheet = $e->sheet->getDelegate();

                // 1) Merge and set up header rows
                $sheet->mergeCells('A1:G1');
                $sheet->getRowDimension(1)->setRowHeight(90);

                $sheet->mergeCells('A2:G2')->setCellValue('A2', 'Central Experiment Station');
                $sheet->getStyle('A2')->getFont()->setSize(12);

                $sheet->mergeCells('A3:G3')->setCellValue('A3', 'Maligaya, Science City of Muñoz, 3119 Nueva Ecija');
                $sheet->getStyle('A3')->getFont()->setSize(12);

                // 2) Speaker info row
                $sheet->mergeCells('A4:G4')->setCellValue('A4', 'Speaker: ' . $this->speakerName);
                $sheet->getStyle('A4')->getFont()->setBold(true);

                // 3) Date row
                $sheet->mergeCells('A5:G5')->setCellValue('A5', 'Report Date: ' . now()->format('F d, Y'));
                $sheet->getStyle('A5')->getFont()->setBold(true);

                // 4) Report title
                $sheet->mergeCells('A7:G7')->setCellValue('A7', 'Speaker Topics Report');
                $sheet->getStyle('A7')->getFont()->setSize(14)->setBold(true);

                // 5) Generated timestamp
                $sheet->mergeCells('A8:G8')->setCellValue('A8', 'Generated at: ' . now()->format('F d, Y H:i:s A'));

                // 6) Set the actual column headers at row 10
                $cols = [
                    'A10'=>'Topic Discussed',
                    'B10'=>'Date',
                    'C10'=>'Province',
                    'D10'=>'Municipality',
                    'E10'=>'Barangay',
                    'F10'=>'Average Evaluation',
                    'G10'=>'Status'
                ];
                foreach ($cols as $cell=>$text) {
                    $sheet->setCellValue($cell,$text);
                }
                $sheet->getStyle('A10:G10')->getFont()->setBold(true);
            },
        ];
    }

    public function startCell(): string
    {
        return 'A11'; // Data starts after your headers.
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
}
