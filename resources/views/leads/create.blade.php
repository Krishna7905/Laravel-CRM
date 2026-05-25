@extends('layouts.app')

@section('content')
<h4>Add Lead</h4>

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('leads.store') }}" method="POST" id="leadForm">
    @csrf
    <div class="row">

        <div class="col-md-6 mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                required pattern="[A-Za-z\s]{3,255}" title="Only letters and spaces allowed">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                title="Enter a valid email">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Phone <span class="text-danger">*</span></label>
            <div class="input-group">

                <!-- Country code dropdown -->
                <select name="country_code" class="form-select @error('country_code') is-invalid @enderror"
                    style="max-width: 130px;" required>
                    <option value="">Code</option>
                    @foreach($countries as $code => $name)
                    <option value="{{ $code }}" {{ old('country_code') == $code ? 'selected' : '' }}>
                        {{ $name }} ({{ $code }})
                    </option>
                    @endforeach
                </select>

                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}"
                    required pattern="[0-9]{10}"
                    title="Enter exactly 10 digits">
            </div>
            @error('phone')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Company</label>
            <input type="text" name="company" class="form-control @error('company') is-invalid @enderror">
            @error('company')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Assign To</label>
            <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                <option value="">Select Sales</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                @endforeach
            </select>
            @error('assigned_to')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12 mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" maxlength="1000"></textarea>
            @error('notes')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

    </div>

    <button type="submit" class="btn btn-success">Save Lead</button>
</form>

<script>
    (function() {
        'use strict'
        const forms = document.querySelectorAll('#leadForm');
        Array.from(forms).forEach(form => {
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