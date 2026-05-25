@extends('layouts.app')

@section('content')

<div class="container">

    <h3>Edit Employee</h3>

    <form action="{{ route('employees.update',$employee->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $employee->name }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" value="{{ $employee->email }}" class="form-control">
        </div>

        <button class="btn btn-primary">
            Update
        </button>

    </form>

</div>

@endsection