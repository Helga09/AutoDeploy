{{ Illuminate\Mail\Markdown::parse('---') }}

Дякуємо,<br>
{{ config('app.name') ?? 'AutoDeploy' }}

{{ Illuminate\Mail\Markdown::parse('') }}