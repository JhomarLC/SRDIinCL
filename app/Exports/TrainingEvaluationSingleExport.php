<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TrainingEvaluationSingleExport implements WithMultipleSheets
{
    protected $event_id;

    public function __construct($event_id)
    {
        $this->event_id = $event_id;
    }

    public function sheets(): array
    {
        return [
            new TrainingEvaluationsSheet(null, null, null, $this->event_id),
        ];
    }
}
