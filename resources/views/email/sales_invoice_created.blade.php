@component('mail::message')
    # New Sales Invoice

    {{$mailInfo['mailText']}}

    @component('mail::panel')
        {{$mailInfo['productText']}}
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent




