<x-emails.layout>
<h2>Сертифікати SSL оновлено</h2>

<p>Сертифікати SSL було оновлено для наступних ресурсів:</p>

<ul>
@foreach($resources as $resource)
    <li>{{ $resource->name }}</li>
@endforeach
</ul>

<div style="margin: 20px 0; padding: 15px; background-color: #fff3cd; border: 1px solid #ffeeba; border-radius: 4px;">
    <strong>⚠️ Потрібна дія:</strong> Ці ресурси необхідно розгорнути вручну, щоб нові сертифікати SSL набули чинності. Будь ласка, зробіть це протягом наступних кількох днів, щоб забезпечити доступність ваших підключень до бази даних.
</div>

<p>Старі сертифікати SSL залишатимуться дійсними ще приблизно 14 днів, оскільки ми оновлюємо сертифікати за 14 днів до закінчення їх терміну дії.</p>

@if(isset($urls) && count($urls) > 0)
<div style="margin-top: 20px;">
    <p>Ви можете повторно розгорнути ці ресурси тут:</p>
    <ul>
    @foreach($urls as $name => $url)
        <li><a href="{{ $url }}">{{ $name }}</a></li>
    @endforeach
    </ul>
</div>
@endif
</x-emails.layout>