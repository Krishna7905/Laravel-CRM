@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h3 class="fw-bold">Team Details</h3>

        <div>

            <a href="{{ route('contacts.edit',$contact->id) }}"
                class="btn btn-warning">
                Edit
            </a>

            <a href="{{ route('contacts.index') }}"
                class="btn btn-secondary">
                Back
            </a>

        </div>

    </div>


    <div class="row">

        <div class="col-md-8">

            <div class="card shadow-sm mb-4">

                <div class="card-header">

                    <strong>Contact Information</strong>

                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="text-muted">Name</label>
                            <p class="fw-semibold">{{ $contact->name }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Email</label>
                            <p>{{ $contact->email ?? '-' }}</p>
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="text-muted">Phone</label>
                            <p>{{ $contact->phone ?? '-' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Company</label>
                            <p>{{ $contact->company ?? '-' }}</p>
                        </div>

                    </div>


                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="text-muted">Assigned Sales</label>
                            <p>{{ $contact->assignedUser->name ?? 'Not Assigned' }}</p>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted">Created By</label>
                            <p>{{ $contact->creator->name ?? '-' }}</p>
                        </div>

                    </div>

                </div>

            </div>


            <div class="card shadow-sm">

                <div class="card-header">

                    <strong>Notes</strong>

                </div>

                <div class="card-body">

                    <p>

                        {{ $contact->notes ?? 'No notes available' }}

                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card shadow-sm mb-4">

                <div class="card-header">
                    Contact Summary
                </div>

                <div class="card-body">

                    <p>

                        <strong>ID :</strong> {{ $contact->id }}

                    </p>

                    <p>

                        <strong>Created :</strong> {{ $contact->created_at->format('d M Y') }}

                    </p>

                    <p>

                        <strong>Updated :</strong> {{ $contact->updated_at->diffForHumans() }}

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection