@if ($server->proxySet())
    <div class="flex flex-col items-start gap-2 min-w-fit">
        <a class="{{ request()->routeIs('server.proxy') ? 'menu-item menu-item-active' : 'menu-item' }}"
            href="{{ route('server.proxy', $parameters) }}">
            <button>Конфігурація</button>
        </a>
        <a class="{{ request()->routeIs('server.proxy.dynamic-confs') ? 'menu-item menu-item-active' : 'menu-item' }}"
            href="{{ route('server.proxy.dynamic-confs', $parameters) }}">
            <button>Динамічні конфігурації</button>
        </a>
        <a class="{{ request()->routeIs('server.proxy.logs') ? 'menu-item menu-item-active' : 'menu-item' }}"
            href="{{ route('server.proxy.logs', $parameters) }}">
            <button>Журнали</button>
        </a>
    </div>
@endif