<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TrainingEvaluationFullExport implements WithMultipleSheets
{
    protected $province, $date_from, $date_to;

    public function __construct($province = null, $date_from = null, $date_to = null)
    {
        $this->province = $province;
        $this->date_from = $date_from;
        $this->date_to = $date_to;
    }

    public function sheets(): array
    {
        return [
            new TrainingEventsSheet($this->province, $this->date_from, $this->date_to),
            new TrainingEvaluationsSheet($this->province, $this->date_from, $this->date_to),
        ];
    }
}
