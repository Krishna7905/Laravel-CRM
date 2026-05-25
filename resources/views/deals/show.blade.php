@extends('layouts.app')

@section('content')
<div class="container">

    <h4 class="mb-4 fw-bold text-primary">Deal Details</h4>

    <div class="card shadow-sm mb-3">
        <div class="card-body">

            <p><strong>Title:</strong> {{ $deal->title }}</p>
            <p><strong>Team:</strong> {{ $deal->contact->name ?? '-' }}</p>
            <p><strong>Value:</strong> ₹{{ $deal->value }}</p>
            <p><strong>Stage:</strong> {{ ucfirst($deal->stage) }}</p>
            <p><strong>Assigned:</strong> {{ $deal->employee->name ?? '-' }}</p>
            <p><strong>Created At:</strong> {{ $deal->created_at->format('d M, Y') }}</p>
            <p><strong>Updated At:</strong> {{ $deal->updated_at->format('d M, Y') }}</p>

        </div>
    </div>

    <a href="{{ route('deals.index') }}" class="btn btn-secondary">Back to Deals</a>

</div>
@endsection