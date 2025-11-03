<x-emails.layout>
Резервне копіювання бази даних для {{ $name }} @if($database_name)(БД:{{ $database_name }})@endif з частотою {{ $frequency }} успішно виконано локально, але не вдалося завантажити до S3.

Помилка S3: {{ $s3_error }}

@if($s3_storage_url)
Перевірте конфігурацію S3: {{ $s3_storage_url }}
@endif
</x-emails.layout>