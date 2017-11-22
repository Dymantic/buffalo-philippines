@component('mail::message')
# Buffalo Philippines Site Inquiry

@component('mail::panel')
    **From:** {{ $name }}<br>
    **Email:** {{ $email }}
@endcomponent

{{ $inquiry }}

@endcomponent