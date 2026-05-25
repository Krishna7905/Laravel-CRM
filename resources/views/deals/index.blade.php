@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .action-group {
        display: flex;
        justify-content: flex-end;
        gap: 6px;
    }

    .action-btn {
        font-size: 13px;
        padding: 5px 12px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        background: #fff;
        color: #495057;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .action-btn:hover {
        background: #f8f9fa;
    }

    .action-btn.primary {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    .action-btn.primary:hover {
        background: #0d6efd;
        color: #fff;
    }

    .action-btn.danger {
        border-color: #dc3545;
        color: #dc3545;
    }

    .action-btn.danger:hover {
        background: #dc3545;
        color: #fff;
    }

    .badge {
        border-radius: 20px;
        font-size: 12px;
        letter-spacing: 0.5px;
    }
</style>
@endsection


@section('content')
<div class="container-fluid py-4">


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-1 fw-semibold">Deals</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('deals.create') }}" class="btn btn-primary px-4">Add Deal</a>
        </div>
    </div>

    <div id="bulkActions" class="card border-0 shadow-sm mb-3 d-none">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <div class="fw-medium"><span id="selectedCount">0</span> selected</div>

            <!-- <div class="d-flex gap-2">
                <button id="bulkDelete" class="btn btn-sm btn-outline-danger">Delete Selected</button>
            </div> -->
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">

            <table id="dealsTable" class="table table-striped table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th><input type="checkbox" id="selectAll"></th>
                        <th>Title</th>
                        <th>Team</th>
                        <th>Value</th>
                        <th>Stage</th>
                        <th>Assigned</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($deals as $deal)
                    <tr>
                        <td>
                            <input type="checkbox" class="rowCheckbox" value="{{ $deal->id }}">
                        </td>

                        <td>{{ $deal->title }}</td>
                        <td>{{ $deal->contact->name ?? '-' }}</td>
                        <td>₹{{ number_format($deal->value) }}</td>

                        @php
                        $stageColors = [
                        'prospecting' => 'primary',
                        'qualification' => 'info',
                        'proposal' => 'warning',
                        'negotiation' => 'dark',
                        'won' => 'success',
                        'lost' => 'danger',
                        ];
                        @endphp

                        <td>
                            <span class="badge px-3 py-2 fw-semibold 
        bg-{{ $stageColors[$deal->stage] ?? 'secondary' }}">
                                {{ ucfirst($deal->stage) }}
                            </span>
                        </td>

                        <td>{{ $deal->employee->name ?? 'Unassigned' }}</td>

                        <td class="text-end">
                            <div class="action-group">
                                <a href="{{ route('deals.show', $deal->id) }}" class="btn btn-view action-btn">View</a>
                                <a href="{{ route('deals.edit', $deal->id) }}" class="btn btn-edit action-btn">Edit</a>

                                <form action="{{ route('deals.destroy', $deal->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete action-btn"
                                        onclick="return confirm('Pakka deal delete kr du?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No deals found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>


</div>
@endsection


@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {

        $('#dealsTable').DataTable({
            order: [
                [1, "asc"]
            ],
            pageLength: 10,
            lengthChange: false,
        });

        const bulkBar = $('#bulkActions');
        const selectedCount = $('#selectedCount');

        $('#selectAll').change(function() {
            $('.rowCheckbox').prop('checked', $(this).prop('checked'));
            updateBulkBar();
        });

        $('.rowCheckbox').change(updateBulkBar);

        function updateBulkBar() {
            let count = $('.rowCheckbox:checked').length;
            selectedCount.text(count);
            bulkBar.toggleClass('d-none', count === 0);
        }

    });
</script>
@endsection