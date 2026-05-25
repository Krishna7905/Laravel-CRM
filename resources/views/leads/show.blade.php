@extends('layouts.app')

@section('content')

<h4>Lead Details</h4>

<div class="card">

    <div class="card-body">

        <p><b>Name:</b> {{ $lead->name }}</p>

        <p><b>Email:</b> {{ $lead->email }}</p>

        <p><b>Phone:</b> {{ $lead->phone }}</p>

        <p><b>Company:</b> {{ $lead->company }}</p>

        <p><b>Status:</b> {{ $lead->status }}</p>

        <p><b>Assigned To:</b> {{ $lead->assignedUser->name ?? '-' }}</p>

        <p><b>Notes:</b> {{ $lead->notes }}</p>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal">
            Send Email
        </button>

        <div class="modal fade" id="emailModal">
            <div class="modal-dialog modal-lg">
                <form action="{{ route('leads.sendMail', $lead->id) }}" method="POST">
                    @csrf

                    <div class="modal-content">
                        <div class="modal-header">
                            <h5>Send Email</h5>
                        </div>
                        

                        <div class="modal-body">

                            <input type="text" name="subject" class="form-control mb-2" placeholder="Subject" required>

                            <textarea name="body" class="form-control" rows="6" placeholder="Write email..." required></textarea>

                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-success">Send</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>

    </div>

</div>
<!-- <small class="text-muted">
    Sent by {{ $log->user->name ?? 'System' }}
</small> -->
<h3>{{ $lead->name }}</h3>
<p><strong>Email:</strong> {{ $lead->email }}</p>

<hr>
<h4 class="mt-4 mb-3">Email Timeline</h4>

@if($lead->emailLogs->count())

    <div class="timeline">

    @foreach($lead->emailLogs as $log)

        <div class="timeline-item">

            <div class="timeline-card">

                <div class="timeline-header">
                    <span class="timeline-title"> --> Email Sent</span>
                    <span class="timeline-date">
                        {{ $log->created_at->format('d M Y, h:i A') }}
                    </span>
                </div>

                <div class="timeline-subject">
                    {{ $log->subject }}
                </div>

                <div class="timeline-body">
                    {!! $log->body !!}
                </div>

                <div class="timeline-user">
                    Sent by {{ $log->user->name ?? 'System' }}
                </div>

            </div>

        </div>

    @endforeach

</div>

@else
    <p class="text-muted">No emails sent yet.</p>
@endif

@endsection