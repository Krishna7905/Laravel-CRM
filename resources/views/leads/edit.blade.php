@extends('layouts.app')

@section('content')

<h4>Edit Lead</h4>

<form action="{{ route('leads.update',$lead->id) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $lead->name }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $lead->email }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Phone</label>
            <input type="text" name="phone" value="{{ $lead->phone }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Company</label>
            <input type="text" name="company" value="{{ $lead->company }}" class="form-control">
        </div>

        <div class="col-md-6 mb-3">
            <label>Assign To</label>

            <select name="assigned_to" class="form-control">

                <option value="">Select Sales</option>

                @foreach($employees as $employee)

                <option value="{{ $employee->id }}"
                    {{ $lead->assigned_to == $employee->id ? 'selected' : '' }}>

                    {{ $employee->name }}

                </option>

                @endforeach

            </select>
        </div>

        <div class="col-md-12 mb-3">

            <label>Notes</label>

            <textarea name="notes" class="form-control">{{ $lead->notes }}</textarea>

        </div>

    </div>

    <button class="btn btn-success">Update Lead</button>

</form>

@endsection