<x-emails.layout>
Ресурс ({{ $containerName }}) було несподівано зупинено на {{ $serverName }}.

@if ($url)
Будь ласка, перевірте, що відбувається [тут]({{ $url }}).
@endif
</x-emails.layout>