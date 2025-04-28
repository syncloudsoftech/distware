<x-mail::message>
# License details

Please find your license code below required to activate the software:

<x-mail::panel>
<div style="text-align: center; font-family: monospace">{{ $license->code }}</div>
</x-mail::panel>

To download the software on your system, please click the below button and enter the license code shown above:

<x-mail::button :url="route('download')">
Download
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
