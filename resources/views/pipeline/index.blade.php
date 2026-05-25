@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h4 class="mb-4 fw-bold">Lead Pipeline</h4>

    <div class="row g-4 pipeline-board">

        @php
        $statuses = ['new','contacted','qualified','proposal','converted','lost'];
        @endphp

        @foreach($statuses as $status)

        <div class="col pipeline-column">

            <div class="card shadow-sm h-100">

                <div class="card-header status-header status-{{$status}}">
                    {{ ucfirst($status) }}
                </div>

                <div class="card-body pipeline-stage" data-status="{{$status}}">

                    @if(isset($leads[$status]))
                    @foreach($leads[$status] as $lead)

                    <div class="lead-card card mb-3" data-id="{{$lead->id}}">
                        <div class="card-body p-3">

                            <h6 class="fw-bold mb-1">
                                {{$lead->name}}
                            </h6>

                            <small class="text-muted">
                                {{$lead->company}}
                            </small>

                            <div class="mt-2">
                                <span class="badge bg-secondary">
                                    {{$lead->assignedUser->name ?? 'Unassigned'}}
                                </span>
                            </div>

                        </div>
                    </div>

                    @endforeach
                    @endif

                </div>
            </div>

        </div>

        @endforeach

    </div>

</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<script>
    document.querySelectorAll('.pipeline-stage').forEach(stage => {

        new Sortable(stage, {

            group: 'pipeline',

            animation: 200,

            onEnd: function(evt) {

                let leadId = evt.item.dataset.id;
                let status = evt.to.dataset.status;

                fetch('/pipeline/update', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        id: leadId,
                        status: status
                    })
                });

            }

        });

    });
</script>

@endsection