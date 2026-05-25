@extends('layouts.app')

@section('content')

<div class="container">
    <h4 class="mb-4">Activity Logs</h4>

    <div class="filter-box mb-3 d-flex align-items-center gap-2">

    <form method="GET" class="d-flex gap-2">

        <select name="module" class="form-select">
            <option value="">All Modules</option>
            <option value="Lead" {{ request('module')=='Lead' ? 'selected' : '' }}>Lead</option>
            <option value="Contact" {{ request('module')=='Contact' ? 'selected' : '' }}>Contact</option>
            <option value="Deal" {{ request('module')=='Deal' ? 'selected' : '' }}>Deal</option>
            <option value="Task" {{ request('module')=='Task' ? 'selected' : '' }}>Task</option>
        </select>

        <button class="btn btn-primary">Apply</button>

    </form>

</div>

    <div class="card shadow">
        <div class="card-body activity">

            @foreach($logs as $log)
                <div class="mb-3 border-bottom pb-2">
                    <strong>{{ $log->description }}</strong><br>
                    <small class="text-muted">
                        {{ $log->user_name }} | 
                        <span class="badge bg-info text-dark">{{ $log->module }}</span> | 
                        {{ $log->created_at->diffForHumans() }}
                    </small>
                </div>
            @endforeach

        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
/* Container */
.activity-wrapper {
    background: #f5f7fb;
    border-radius: 16px;
    padding: 20px;
}

/* Timeline */
.activity-timeline {
    position: relative;
    max-height: 500px;
    overflow-y: auto;
    padding-left: 20px;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    width: 2px;
    height: 100%;
    background: #e5e7eb;
}

/* Item */
.activity-item {
    position: relative;
    margin-bottom: 20px;
    padding-left: 20px;
}

.activity-item::before {
    content: '';
    position: absolute;
    left: -2px;
    top: 6px;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}

/* Module Colors */
.module-Lead::before { background: #3b82f6; }
.module-Contact::before { background: #10b981; }
.module-Deal::before { background: #f59e0b; }
.module-Task::before { background: #ef4444; }

/* Card */
.activity-card {
    background: #fff;
    border-radius: 12px;
    padding: 12px 15px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    transition: 0.2s;
}

.activity-card:hover {
    transform: translateY(-3px);
}

.avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #0d6efd;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 600;
}

.activity-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Filters */
.filter-box {
    background: #fff;
    padding: 12px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
}
</style>
@endsection