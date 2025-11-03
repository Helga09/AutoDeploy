<div>
    <h2>Призначення</h2>
    <div class="">Сервер / мережа призначення, куди буде розгорнуто ваш застосунок.</div>
    <div class="py-4 ">
        <p>Сервер: {{ data_get($destination, 'server.name') }}</p>
        <p>Мережа призначення: {{ $destination->network }}</p>
    </div>
</div>