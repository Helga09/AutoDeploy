<x-emails.layout>
@foreach ($databases as $database_name => $databases)

@if(data_get($databases,'failed_count') > 0)

<div style="color:red">

"{{ $database_name }}" резервні копії: Були деякі невдалі резервні копії. Будь ласка, увійдіть та перевірте логи для отримання додаткової інформації.

</div>

@else

"{{ $database_name }}" резервні копії: Усі резервні копії були успішними.

@endif

@endforeach
</x-emails.layout>