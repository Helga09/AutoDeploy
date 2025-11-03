{{ Illuminate\Mail\Markdown::parse('---') }}

Дякуємо,<br>
{{ config('app.name') ?? 'AutoDeploy' }}

{{ Illuminate\Mail\Markdown::parse('[Зв\'язатися зі службою підтримки](https://AutoDeploy.io/docs/contact)') }}