<x-emails.layout>
@if ($pull_request_id === 0)
Нова версія {{ $name }} доступна за адресою [{{ $fqdn }}]({{ $fqdn }}) .
@else
Запит на витяг #{{ $pull_request_id }} {{ $name }} успішно розгорнуто
[{{ $fqdn }}]({{ $fqdn }}).
@endif

[Переглянути журнали розгортання]({{ $deployment_url }})

</x-emails.layout>