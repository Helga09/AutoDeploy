<div>
    <x-slot:title>
        Налаштування проксі | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    @if ($server->isFunctional())
        <div class="flex flex-col h-full gap-8 sm:flex-row">
            <x-server.sidebar-proxy :server="$server" :parameters="$parameters" />
            <div class="w-full">
                <livewire:server.proxy :server="$server" />
            </div>
        </div>
    @else
        <div>Сервер не перевірений. Спочатку перевірте.</div>
    @endif
</div>