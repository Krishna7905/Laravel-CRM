@extends('layouts.app')

@section('content')

<div class="container">

    <h4>Create Task</h4>

    <form action="{{ route('tasks.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Task Title</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Due Date</label>
            <input type="date" name="due_date" class="form-control" id="due_date">
        </div>
        @error('due_date')
        <div class="text-danger mt-1">{{ $message }}</div>
        @enderror

        <div class="mb-3">
            <label>Status</label>

            <select name="status" class="form-control">

                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>

            </select>

        </div>

        <div class="mb-3">

            <label>Team</label>

            <select name="contact_id" class="form-control">

                <option value="">Select Team</option>

                @foreach($contacts as $contact)

                <option value="{{ $contact->id }}">
                    {{ $contact->name }}
                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Assign Employee</label>

            <select name="assigned_to" class="form-control">

                <option value="">Select Employee</option>

                @foreach($employees as $employee)

                <option value="{{ $employee->id }}">
                    {{ $employee->name }}
                </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-success">
            Create Task
        </button>

    </form>

</div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('due_date').setAttribute('min', today);
    });
</script>
@endsection