<x-emails.layout>
@if ($pull_request_id === 0)
Не вдалося розгорнути нову версію {{ $name }} за адресою [{{ $fqdn }}]({{ $fqdn }}).
@else
Не вдалося розгорнути запит на злиття #{{ $pull_request_id }} для {{ $name }} за адресою
[{{ $fqdn }}]({{ $fqdn }}).
@endif

[Переглянути логи розгортання]({{ $deployment_url }})
</x-emails.layout>