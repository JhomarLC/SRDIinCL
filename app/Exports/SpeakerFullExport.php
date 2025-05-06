<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SpeakerFullExport implements WithMultipleSheets
{
    protected $province;
    protected $date_from;
    protected $date_to;

    public function __construct($province = null, $date_from = null, $date_to = null)
    {
        $this->province = $province;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function sheets(): array
    {
        return [
            new SpeakerOverviewSheet($this->province, $this->date_from, $this->date_to),
            new TopicOverviewSheet($this->province, $this->date_from, $this->date_to),
            new SpeakerEvaluationOverviewSheet($this->province, $this->date_from, $this->date_to),
        ];
    }
}
