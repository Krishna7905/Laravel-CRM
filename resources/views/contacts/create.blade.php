@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">
        <div class="card-header">
            <h4 class="fw-bold text-primary mb-0">Create Team</h4>
        </div>

        <div class="card-body">

            <form action="{{ route('contacts.store') }}" method="POST">
                @csrf

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Name <span class="text-danger" >*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            required pattern="[A-Za-z\s]{3,255}" title="Only letters and spaces allowed">
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                            title="Enter a valid email">
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label fw-semibold">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone') }}">
                        @error('phone')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="company" class="form-label fw-semibold">Company</label>
                        <input type="text" id="company" name="company" class="form-control" value="{{ old('company') }}">
                        @error('company')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="assigned_to" class="form-label fw-semibold">Assign Employee</label>
                        <select id="assigned_to" name="assigned_to" class="form-control">
                            <option value="">Select Employee</option>
                            @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ old('assigned_to') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('assigned_to')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="notes" class="form-label fw-semibold">Notes</label>
                        <textarea id="notes" name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                        @error('notes')
                        <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn btn-success">
                    Save Contact
                </button>

            </form>

        </div>
    </div>

</div>

@endsection

@section('styles')
<style>
    .form-control {
        border-radius: 6px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #0d6efd;
    }

    .btn-success {
        border-radius: 6px;
        text-transform: uppercase;
    }

    label {
        font-size: 0.95rem;
    }
</style>
@endsection