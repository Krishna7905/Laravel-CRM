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
</style>
@endsection


@section('content')
<div class="container-fluid py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-1 fw-semibold">Employees</h4>

        <div class="d-flex gap-2">
            <a href="{{ route('employees.create') }}" class="btn btn-primary px-4">
                Add Employee
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">

            <table id="employeeTable" class="table table-striped table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>

                        <td class="text-end">
                            <div class="action-group">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-edit action-btn">Edit</a>

                                <form action="{{ route('employees.destroy', $employee   ->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete action-btn"
                                        onclick="return confirm('Pakka Task Delete kr du?')">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">
                            No employees found
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

        $('#employeeTable').DataTable({
            order: [
                [0, "asc"]
            ],
            pageLength: 10,
            lengthChange: false,
        });

    });
</script>
@endsection