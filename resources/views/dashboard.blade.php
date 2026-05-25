@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    .kpi-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }

    .kpi-card h6 {
        opacity: 0.8;
        font-size: 14px;
    }

    .kpi-card h3 {
        font-weight: bold;
    }

    .kpi-icon {
        position: absolute;
        right: 15px;
        bottom: 10px;
        font-size: 40px;
        opacity: 0.2;
    }

    .bg-gradient-blue {
        background: linear-gradient(45deg, #0d6efd, #4dabf7);
    }

    .bg-gradient-green {
        background: linear-gradient(45deg, #198754, #51cf66);
    }

    .bg-gradient-orange {
        background: linear-gradient(45deg, #fd7e14, #ffa94d);
    }

    .bg-gradient-red {
        background: linear-gradient(45deg, #dc3545, #ff6b6b);
    }


    .card {
        border-radius: 12px;
    }


    .activity-item {
        border-left: 3px solid #0d6efd;
        padding-left: 10px;
        margin-bottom: 10px;
    }
</style>
@endsection


@section('content')
<div class="container-fluid py-4 dashboard-wrapper">


    <div class="d-flex justify-content-between mb-4">
        <h3 class="fw-bold text-primary">Dashboard Overview</h3>
    </div>


    <div class="row g-3">

        <div class="col-md-3">
            <div class="kpi-card bg-gradient-blue">
                <h6>Total Leads</h6>
                <h3>{{ $totalLeads }}</h3>
                <i class="fa fa-user-plus kpi-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card bg-gradient-green">
                <h6>Total Contacts</h6>
                <h3>{{ $totalContacts }}</h3>
                <i class="fa fa-address-book kpi-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card bg-gradient-orange">
                <h6>Total Deals</h6>
                <h3>{{ $totalDeals }}</h3>
                <i class="fa fa-handshake kpi-icon"></i>
            </div>
        </div>

        <div class="col-md-3">
            <div class="kpi-card bg-gradient-red">
                <h6>Total Tasks</h6>
                <h3>{{ $totalTasks }}</h3>
                <i class="fa fa-tasks kpi-icon"></i>
            </div>
        </div>

    </div>

    <!-- REVENUE  -->
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card shadow-sm p-3">
                <h5>Total Revenue</h5>
                <h2 class="text-success fw-bold">₹{{ number_format($totalRevenue) }}</h2>
            </div>
        </div>
    </div>

    <!-- CHARTS  -->
    <div class="row mt-4">

        <!-- Monthly Deals -->
        <div class="col-md-8">
            <div class="card shadow-sm p-3">
                <h5>Monthly Deals Overview</h5>
                <canvas id="dealsChart"></canvas>
            </div>
        </div>

       
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <h5>Task Status</h5>
                <canvas id="taskChart"></canvas>
            </div>
        </div>

    </div>

    <div class="row mt-4">

        <!-- Pipeline -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Sales Pipeline</h5>
                <canvas id="pipelineChart"></canvas>
            </div>
        </div>

        <!-- Activity -->
        <div class="col-md-6">
            <div class="card shadow-sm p-3">
                <h5>Recent Activities</h5>

                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <strong>{{ $activity->action }}</strong><br>
                    <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                </div>
                @empty
                <p class="text-muted">No recent activities</p>
                @endforelse

            </div>
        </div>

    </div>

    <!--  RECENT DATA  -->
    <div class="row mt-4">

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Recent Leads</div>
                <ul class="list-group list-group-flush">
                    @foreach($recentLeads as $lead)
                    <li class="list-group-item">
                        {{ $lead->name }}
                        <span class="badge bg-secondary float-end">
                            {{ ucfirst($lead->status) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">Recent Tasks</div>
                <ul class="list-group list-group-flush">
                    @foreach($recentTasks as $task)
                    <li class="list-group-item">
                        {{ $task->title }}
                        <span class="badge bg-info float-end">
                            {{ ucfirst($task->status) }}
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>

</div>
@endsection


@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {

        new Chart(document.getElementById('dealsChart'), {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    label: 'Deals',
                    data: @json($dealCounts),
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true
                }]
            }
        });

        new Chart(document.getElementById('taskChart'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Completed'],
                datasets: [{
                    data: @json($taskChart)
                }]
            }
        });

        new Chart(document.getElementById('pipelineChart'), {
            type: 'bar',
            data: {
                labels: @json(array_keys($pipelineData)),
                datasets: [{
                    label: 'Deals',
                    data: @json(array_values($pipelineData))
                }]
            }
        });

    });
</script>
@endsection