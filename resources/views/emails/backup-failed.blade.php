<x-emails.layout>
Резервна копія бази даних для {{ $name }} @if($database_name)(db:{{ $database_name }})@endif з частотою {{ $frequency }} завершилася ПОМИЛКОЮ.

### Причина

{{ $output }}
</x-emails.layout>