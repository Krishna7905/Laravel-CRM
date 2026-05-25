<?php

namespace App\Observers;

use App\Models\Lead;
use App\Services\ActivityLogService;

class LeadObserver
{
    public function created(Lead $lead)
    {
        ActivityLogService::log(
            'Created',
            'Lead',
            "Created lead: {$lead->name}"
        );
    }

    public function updated(Lead $lead)
    {
        ActivityLogService::log(
            'Updated',
            'Lead',
            "Updated lead: {$lead->name}"
        );
    }

    public function deleted(Lead $lead)
    {
        ActivityLogService::log(
            'Deleted',
            'Lead',
            "Deleted lead: {$lead->name}"
        );
    }
}