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

    table.dataTable thead th {
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-1 fw-semibold">Leads</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('leads.export', request()->query()) }}" class="btn btn-outline-success px-4">Export</a>
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#importModal">Import</button>
            <a href="{{ route('leads.create') }}" class="btn btn-primary px-4">Add Lead</a>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('leads.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Search</label>
                        <input type="text" name="search" class="form-control" placeholder="Search name, email, phone" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Status</label>
                        <select name="status" class="form-select">
                            <option value="">All</option>
                            <option value="new" {{ request('status')=='new'?'selected':'' }}>New</option>
                            <option value="contacted" {{ request('status')=='contacted'?'selected':'' }}>Contacted</option>
                            <option value="qualified" {{ request('status')=='qualified'?'selected':'' }}>Qualified</option>
                            <option value="proposal" {{ request('status')=='proposal'?'selected':'' }}>Proposal</option>
                            <option value="converted" {{ request('status')=='converted'?'selected':'' }}>Converted</option>
                            <option value="lost" {{ request('status')=='lost'?'selected':'' }}>Lost</option>
                        </select>
                    </div>
                    <div class="col-md-5 d-flex gap-2">
                        <button class="btn btn-dark px-4">Apply</button>
                        <a href="{{ route('leads.index') }}" class="btn btn-outline-secondary px-4">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- BULK ACTION BAR -->
    <div id="bulkActions" class="card border-0 shadow-sm mb-3 d-none">
        <div class="card-body py-2 d-flex justify-content-between align-items-center">
            <div class="fw-medium"><span id="selectedCount">0</span> selected</div>
            <div class="d-flex gap-2">
                <select id="bulkStatus" class="form-select form-select-sm" style="width:180px;">
                    <option value="">Change Status</option>
                    <option value="new">New</option>
                    <option value="contacted">Contacted</option>
                    <option value="qualified">Qualified</option>
                    <option value="proposal">Proposal</option>
                    <option value="lost">Lost</option>
                </select>
                <button id="bulkDelete" class="btn btn-sm btn-outline-danger">Delete Selected</button>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table id="leadsTable" class="table table-striped table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width:40px;"><input type="checkbox" id="selectAll"></th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Assigned</th>
                        <th class="text-end">Actions</th>
                        <a href="{{ route('leads.trash') }}" class="btn btn-danger mb-3">
                            View Trash
                        </a>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $lead)
                    <tr>
                        <td><input type="checkbox" class="rowCheckbox" value="{{ $lead->id }}"></td>
                        <td>{{ $lead->name }}</td>
                        <td>{{ $lead->email }}</td>
                        <td>{{ $lead->phone }}</td>
                        <td>
                            <select class="form-select form-select-sm status" data-id="{{ $lead->id }}">
                                <option value="new" {{ $lead->status=='new'?'selected':'' }}>New</option>
                                <option value="contacted" {{ $lead->status=='contacted'?'selected':'' }}>Contacted</option>
                                <option value="qualified" {{ $lead->status=='qualified'?'selected':'' }}>Qualified</option>
                                <option value="proposal" {{ $lead->status=='proposal'?'selected':'' }}>Proposal</option>
                                <option value="converted" {{ $lead->status=='converted'?'selected':'' }}>Converted</option>
                                <option value="lost" {{ $lead->status=='lost'?'selected':'' }}>Lost</option>
                            </select>
                        </td>
                        <td>{{ $lead->employee->name ?? 'Unassigned' }}</td>
                        <td class="text-end">
                            <div class="action-group">
                                <a href="{{ route('leads.show', $lead->id) }}" class="btn btn-view action-btn">View</a>
                                <a href="{{ route('leads.edit', $lead->id) }}" class="btn btn-edit action-btn">Edit</a>
                                <form action="{{ route('leads.destroy', $lead->id) }}" method="POST"
                                    onsubmit="return confirm('Move to trash?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-warning btn-sm"> Trash</button>
                                </form>

                            </div>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No leads found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- PAGINATION -->
    <div class="mt-3">{{ $leads->links() }}</div>

</div>


<!-- IMPORT MODAL -->
<div class="modal fade" id="importModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('leads.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Import Leads</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="file" name="file" class="form-control" required>
                    <small class="text-muted">CSV format: name,email,phone,status</small>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function() {

        $('#leadsTable').DataTable({
            "order": [
                [1, "asc"]
            ],
            "pageLength": 10,
            "lengthChange": false,
        });

        $('.status').change(function() {
            let leadId = $(this).data('id');
            let status = $(this).val();
            fetch(`/leads/${leadId}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    status: status
                })
            });
        });

        // BULK ACTIONS
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

        // BULK DELETE
        $('#bulkDelete').click(function() {
            let ids = $('.rowCheckbox:checked').map(function() {
                return $(this).val();
            }).get();
            if (!ids.length) return;
            if (!confirm('Delete selected leads?')) return;
            fetch("{{ route('leads.bulkDelete') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    ids: ids
                })
            }).then(() => location.reload());
        });

        // BULK STATUS
        $('#bulkStatus').change(function() {
            let ids = $('.rowCheckbox:checked').map(function() {
                return $(this).val();
            }).get();
            let status = $(this).val();
            if (!ids.length || !status) return;
            fetch("{{ route('leads.bulkStatus') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    ids: ids,
                    status: status
                })
            }).then(() => location.reload());
        });

        // EXPORT CSV
        $('#exportBtn').click(function() {
            window.location.href = "{{ route('leads.export', request()->query()) }}";
        });

    });
</script>
@endsection