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
    @if (!$server->isLocalhost())
        <a class="menu-item {{ $activeMenu === 'cloudflare-tunnel' ? 'menu-item-active' : '' }}"
            href="{{ route('server.cloudflare-tunnel', ['server_uuid' => $server->uuid]) }}">Тунель Cloudflare
        </a>
    @endif
    @if (!$server->isLocalhost())
        <a class="menu-item {{ $activeMenu === 'danger' ? 'menu-item-active' : '' }}"
            href="{{ route('server.delete', ['server_uuid' => $server->uuid]) }}">Налаштування</a>
    @endif
</div>