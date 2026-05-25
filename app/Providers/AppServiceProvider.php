<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Lead;
use App\Models\Contact;
use App\Models\Deal;
use App\Models\Task;

use App\Observers\LeadObserver;
use App\Observers\ContactObserver;
use App\Observers\DealObserver;
use App\Observers\TaskObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Lead::observe(LeadObserver::class);
        Contact::observe(ContactObserver::class);
        Deal::observe(DealObserver::class);
        Task::observe(TaskObserver::class);
    }
}