<div class="pb-6">
    <x-slide-over @startproxy.window="slideOverOpen = true" fullScreen>
        <x-slot:title>Журнали запуску проксі</x-slot:title>
        <x-slot:content>
            <livewire:activity-monitor header="Logs" fullHeight />
        </x-slot:content>
    </x-slide-over>
    <div class="flex items-center gap-2">
        <h1>Сервер</h1>
    </div>
    <div class="subtitle">{{ data_get($server, 'name') }}</div>
    <div class="navbar-main">
        <nav
            class="flex items-center gap-6 overflow-x-scroll sm:overflow-x-hidden scrollbar min-h-10 whitespace-nowrap pt-2">
            <a class="{{ request()->routeIs('server.show') ? 'dark:text-white' : '' }}"
                href="{{ route('server.show', [
                    'server_uuid' => data_get($server, 'uuid'),
                ]) }}">
                Конфігурація
            </a>

            <a class="{{ request()->routeIs('server.resources') ? 'dark:text-white' : '' }}"
                href="{{ route('server.resources', [
                    'server_uuid' => data_get($server, 'uuid'),
                ]) }}">
                Ресурси
            </a>
            @can('canAccessTerminal')
                <a class="{{ request()->routeIs('server.command') ? 'dark:text-white' : '' }}"
                    href="{{ route('server.command', [
                        'server_uuid' => data_get($server, 'uuid'),
                    ]) }}">
                    Термінал
                </a>
            @endcan
        </nav>
        <div class="order-first sm:order-last">
            <div>
                @script
                    <script>
                        $wire.$on('checkProxyEvent', () => {
                            try {
                                $wire.$call('checkProxy');
                            } catch (error) {
                                console.error(error);
                                $wire.$dispatch('error', 'Не вдалося перевірити статус проксі. Будь ласка, спробуйте ще раз.');
                            }
                        });
                        $wire.$on('restartEvent', () => {
                            $wire.$dispatch('info', 'Ініціюється перезапуск проксі.');
                            $wire.$call('restart');
                        });
                        $wire.$on('startProxy', () => {
                            window.dispatchEvent(new CustomEvent('startproxy'))
                            $wire.$call('startProxy');
                        });
                        $wire.$on('stopEvent', () => {
                            $wire.$call('stop');
                        });
                    </script>
                @endscript
            </div>
        </div>
    </div>
</div>