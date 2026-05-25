<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\ActivityLogController;

use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home
Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

// AUTH REQUIRED 
Route::middleware(['auth'])->group(function () {

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

 

    // Leads
    Route::resource('leads', LeadController::class);
    Route::post('/leads-import', [LeadController::class, 'import'])->name('leads.import');
    Route::get('/leads-export', [LeadController::class, 'export'])->name('leads.export');

    // Contacts
    Route::resource('contacts', ContactController::class);

    // Deals
    Route::resource('deals', DealController::class);

    // Tasks
    Route::resource('tasks', TaskController::class);

    // Employees
    Route::resource('employees', EmployeeController::class);
// Leads Resource
Route::resource('leads', LeadController::class);

// Bulk Actions
Route::post('/leads/bulk-delete', [LeadController::class, 'bulkDelete'])->name('leads.bulkDelete');
Route::post('/leads/bulk-status', [LeadController::class, 'bulkStatus'])->name('leads.bulkStatus');

// Import Export
Route::post('/leads-import', [LeadController::class, 'import'])->name('leads.import');
Route::get('/leads-export', [LeadController::class, 'export'])->name('leads.export');
Route::middleware(['auth'])->group(function () {

    Route::get('/pipeline', [PipelineController::class, 'index'])
        ->name('pipeline.index');

    Route::post('/pipeline/update', [PipelineController::class, 'updateStatus'])
        ->name('pipeline.update');

});

    // ACTIVITY LOGS 
    Route::get('/activities', [ActivityLogController::class, 'index'])
        ->name('activities.index');

        // Emails   
        Route::post('/leads/{lead}/send-mail', [LeadController::class, 'sendMail'])
    ->name('leads.sendMail');
    // trashed leads
   Route::get('/leads-trash', [LeadController::class, 'trash'])->name('leads.trash');
Route::post('/leads/{id}/restore', [LeadController::class, 'restore'])->name('leads.restore');
Route::delete('/leads/{id}/force-delete', [LeadController::class, 'forceDelete'])->name('leads.forceDelete');
    
    });
require __DIR__.'/auth.php';