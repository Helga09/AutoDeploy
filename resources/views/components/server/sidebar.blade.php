<div class="flex flex-col items-start gap-2 min-w-fit">
    <a class="menu-item {{ $activeMenu === 'general' ? 'menu-item-active' : '' }}"
        href="{{ route('server.show', ['server_uuid' => $server->uuid]) }}">Загальні</a>
    @if ($server->isFunctional())
        <a class="menu-item {{ $activeMenu === 'advanced' ? 'menu-item-active' : '' }}"
            href="{{ route('server.advanced', ['server_uuid' => $server->uuid]) }}">Додатково
        </a>
    @endif
    <a class="menu-item {{ $activeMenu === 'private-key' ? 'menu-item-active' : '' }}"
        href="{{ route('server.private-key', ['server_uuid' => $server->uuid]) }}">Приватний ключ
    </a>
    @if ($server->hetzner_server_id)
        <a class="menu-item {{ $activeMenu === 'cloud-provider-token' ? 'menu-item-active' : '' }}"
            href="{{ route('server.cloud-provider-token', ['server_uuid' => $server->uuid]) }}">Токен Hetzner
        </a>
    @endif
    <a class="menu-item {{ $activeMenu === 'ca-certificate' ? 'menu-item-active' : '' }}"
        href="{{ route('server.ca-certificate', ['server_uuid' => $server->uuid]) }}">Сертифікат ЦС
    </a>
    @if (!$server->isLocalhost())
        <a class="menu-item {{ $activeMenu === 'cloudflare-tunnel' ? 'menu-item-active' : '' }}"
            href="{{ route('server.cloudflare-tunnel', ['server_uuid' => $server->uuid]) }}">Тунель Cloudflare
        </a>
    @endif
    @if ($server->isFunctional())
        <a class="menu-item {{ $activeMenu === 'docker-cleanup' ? 'menu-item-active' : '' }}"
            href="{{ route('server.docker-cleanup', ['server_uuid' => $server->uuid]) }}">Очищення Docker
        </a>
        <a class="menu-item {{ $activeMenu === 'destinations' ? 'menu-item-active' : '' }}"
            href="{{ route('server.destinations', ['server_uuid' => $server->uuid]) }}">Призначення
        </a>
        <a class="menu-item {{ $activeMenu === 'log-drains' ? 'menu-item-active' : '' }}"
            href="{{ route('server.log-drains', ['server_uuid' => $server->uuid]) }}">Відведення логів
        </a>
        <a class="menu-item {{ $activeMenu === 'metrics' ? 'menu-item-active' : '' }}"
            href="{{ route('server.charts', ['server_uuid' => $server->uuid]) }}">Метрики</a>
    @endif
    @if (!$server->isLocalhost())
        <a class="menu-item {{ $activeMenu === 'danger' ? 'menu-item-active' : '' }}"
            href="{{ route('server.delete', ['server_uuid' => $server->uuid]) }}">Налаштування</a>
    @endif
</div>