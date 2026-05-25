<?php
namespace App\Observers;

use App\Models\Deal;
use App\Services\ActivityLogService;

class DealObserver
{
    public function created(Deal $deal)
    {
        ActivityLogService::log('Created','Deal',"Created deal: {$deal->title}");
    }

    public function updated(Deal $deal)
    {
        ActivityLogService::log('Updated','Deal',"Updated deal: {$deal->title}");
    }

    public function deleted(Deal $deal)
    {
        ActivityLogService::log('Deleted','Deal',"Deleted deal: {$deal->title}");
    }
}