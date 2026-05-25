@extends('layouts.app')

@section('content')

<div class="container">

    <h4 class="mb-4 fw-bold text-primary">Add Employee</h4>

    <form action="{{ route('employees.store') }}" method="POST" class="needs-validation" novalidate>
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Name</label>
            <input type="text" name="name" id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}" required>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @else
            <div class="invalid-feedback">Please enter employee name.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email</label>
            <input type="email" name="email" id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}" required>
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @else
            <div class="invalid-feedback">Please enter a valid email address.</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input type="password" name="password" id="password"
                class="form-control @error('password') is-invalid @enderror" required minlength="6">
            @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
            @else
            <div class="invalid-feedback">Password must be at least 6 characters.</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save me-1"></i> Save
        </button>

    </form>

</div>

@endsection

@section('styles')
<style>
    .form-control {
        border-radius: 6px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
    }

    .btn-success {
        border-radius: 6px;
        text-transform: uppercase;
        font-weight: 500;
        padding: 6px 18px;
    }

    label {
        font-size: 0.95rem;
    }

    .invalid-feedback {
        display: block;
    }
</style>
@endsection

@section('scripts')
<script>
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })();
</script>
@endsection