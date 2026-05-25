@component('mail::message')
# {{ $subjectLine }}

{!! $bodyContent !!}

@component('mail::button', ['url' => url('/')])
Visit CRM
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent