@extends('layouts.app')

@section('content')

<div class="container">

    <h4>Edit Task</h4>

    <form action="{{ route('tasks.update',$task->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Task Title</label>

            <input type="text"
                name="title"
                value="{{ $task->title }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Description</label>

            <textarea name="description"
                class="form-control">

            {{ $task->description }}

            </textarea>

        </div>

        <div class="mb-3">

            <label>Status</label>

            <select name="status" class="form-control">

                <option value="pending"
                    {{ $task->status=='pending'?'selected':'' }}>
                    Pending
                </option>

                <option value="in_progress"
                    {{ $task->status=='in_progress'?'selected':'' }}>
                    In Progress
                </option>

                <option value="completed"
                    {{ $task->status=='completed'?'selected':'' }}>
                    Completed
                </option>

            </select>

        </div>

        <div class="mb-3">

            <label>Assign Employee</label>

            <select name="assigned_to" class="form-control">

                @foreach($employees as $employee)

                <option value="{{ $employee->id }}"
                    {{ $task->assigned_to==$employee->id?'selected':'' }}>

                    {{ $employee->name }}

                </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-primary">
            Update Task
        </button>

    </form>

</div>

@endsection