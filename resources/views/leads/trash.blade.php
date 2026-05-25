@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"> Trash Leads</h3>

        <a href="{{ route('leads.index') }}" class="btn btn-outline-primary">
            <-- Back to Leads
        </a>
    </div>

    @if($leads->count() > 0)

    <div class="row g-4">

        @foreach($leads as $lead)

        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100 trash-card">

                <div class="card-body">

                    <h5 class="fw-semibold mb-1">{{ $lead->name }}</h5>
                    <p class="text-muted small mb-2">{{ $lead->email }}</p>

                    <span class="badge bg-danger mb-3">
                        Deleted: {{ $lead->deleted_at->format('d M Y, h:i A') }}
                    </span>

                    <div class="d-flex gap-2">

                        {{-- Restore --}}
                        <form action="{{ route('leads.restore', $lead->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success btn-sm w-100">
                                 Restore
                            </button>
                        </form>

                        {{-- Permanent Delete --}}
                        <form action="{{ route('leads.forceDelete', $lead->id) }}" method="POST"
                              onsubmit="return confirm('Permanently delete? This cannot be undone!')">
                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm w-100">
                                 Delete
                            </button>
                        </form>

                    </div>

                </div>

            </div>
        </div>

        @endforeach

    </div>

    @else

        <div class="text-center mt-5">
            <h5 class="text-muted">No deleted leads found</h5>
        </div>

    @endif

</div>
@endsection