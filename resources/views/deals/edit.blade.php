@extends('layouts.app')

@section('content')

<div class="container">

    <h4>Edit Deal</h4>

    <form action="{{ route('deals.update',$deal->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Deal Title</label>
            <input type="text"
                name="title"
                value="{{ $deal->title }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Team</label>

            <select name="contact_id" class="form-control">

                @foreach($contacts as $contact)

                <option value="{{ $contact->id }}"
                    {{ $deal->contact_id==$contact->id ? 'selected':'' }}>

                    {{ $contact->name }}

                </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">
            <label>Value</label>

            <input type="number"
                name="value"
                value="{{ $deal->value }}"
                class="form-control">
        </div>

        <div class="mb-3">

            <label>Stage</label>

            <select name="stage" class="form-control">

                <option value="new" {{ $deal->stage=='new'?'selected':'' }}>New</option>

                <option value="contacted" {{ $deal->stage=='contacted'?'selected':'' }}>Contacted</option>

                <option value="proposal" {{ $deal->stage=='proposal'?'selected':'' }}>Proposal</option>

                <option value="negotiation" {{ $deal->stage=='negotiation'?'selected':'' }}>Negotiation</option>

                <option value="won" {{ $deal->stage=='won'?'selected':'' }}>Won</option>

                <option value="lost" {{ $deal->stage=='lost'?'selected':'' }}>Lost</option>

            </select>

        </div>

        <div class="mb-3">

            <label>Assign Sales</label>

            <select name="assigned_to" class="form-control">

                @foreach($employees as $employee)

                <option value="{{ $employee->id }}"
                    {{ $deal->assigned_to==$employee->id?'selected':'' }}>

                    {{ $employee->name }}

                </option>

                @endforeach

            </select>

        </div>

        <button class="btn btn-primary">
            Update Deal
        </button>

    </form>

</div>

@endsection