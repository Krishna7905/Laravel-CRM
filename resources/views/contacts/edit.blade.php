@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header">

            <h4>Edit Team</h4>

        </div>

        <div class="card-body">

            <form action="{{ route('contacts.update',$contact->id) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Name</label>
                        <input type="text"
                            name="name"
                            value="{{ $contact->name }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email"
                            name="email"
                            value="{{ $contact->email }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Phone</label>
                        <input type="text"
                            name="phone"
                            value="{{ $contact->phone }}"
                            class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Company</label>
                        <input type="text"
                            name="company"
                            value="{{ $contact->company }}"
                            class="form-control">
                    </div>

                    <div class="col-md-12 mb-3">

                        <label>Assign Sales</label>

                        <select name="assigned_to" class="form-control">

                            <option value="">Select Sales</option>

                            @foreach($employees as $employee)

                            <option value="{{ $employee->id }}"
                                {{ $contact->assigned_to == $employee->id ? 'selected' : '' }}>

                                {{ $employee->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>
                </div>

                <button class="btn btn-primary">

                    Update Contact

                </button>

            </form>

        </div>

    </div>

</div>

@endsection