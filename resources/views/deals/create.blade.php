@extends('layouts.app')

@section('content')

<div class="container">

    <h4>Create Deal</h4>

    <form action="{{ route('deals.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Deal Title</label>
            <input type="text" name="title" class="form-control">
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
            <label>Deal Value</label>
            <input type="number" name="value" class="form-control">
        </div>

        <div class="mb-3">
            <label>Stage</label>
            <select name="stage" class="form-control">

                <option value="new">New</option>
                <option value="contacted">Contacted</option>
                <option value="proposal">Proposal</option>
                <option value="negotiation">Negotiation</option>
                <option value="won">Won</option>
                <option value="lost">Lost</option>

            </select>
        </div>

        <div class="mb-3">
            <label>Close Date</label>
            <input type="date" name="close_date" class="form-control" id="close_date">
        </div>

        <div class="mb-3">
            <label>Assign Sales</label>
            <select name="assigned_to" class="form-control">

                <option value="">Select Employee</option>

                @foreach($employees as $employee)
                <option value="{{ $employee->id }}">
                    {{ $employee->name }}
                </option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <button class="btn btn-success">
            Create Deal
        </button>

    </form>

</div>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('close_date').setAttribute('min', today);
    });
</script>
@endsection