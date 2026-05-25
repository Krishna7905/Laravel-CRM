<?php
namespace App\Observers;

use App\Models\Contact;
use App\Services\ActivityLogService;

class ContactObserver
{
    public function created(Contact $contact)
    {
        ActivityLogService::log('Created','Contact',"Created contact: {$contact->name}");
    }

    public function updated(Contact $contact)
    {
        ActivityLogService::log('Updated','Contact',"Updated contact: {$contact->name}");
    }

    public function deleted(Contact $contact)
    {
        ActivityLogService::log('Deleted','Contact',"Deleted contact: {$contact->name}");
    }
}