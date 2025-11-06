<nav wire:poll.10000ms="checkStatus" class="pb-6">
    <x-resources.breadcrumbs :resource="$database" :parameters="$parameters" />
    <x-slide-over @startdatabase.window="slideOverOpen = true" closeWithX fullScreen>
        <x-slot:title>Запуск Бази Даних</x-slot:title>
        <x-slot:content>
            <livewire:activity-monitor header="Журнали" fullHeight />
        </x-slot:content>
    </x-slide-over>
    <div class="navbar-main">
        <nav
            class="flex overflow-x-scroll shrink-0 gap-6 items-center whitespace-nowrap sm:overflow-x-hidden scrollbar min-h-10">
            <a class="{{ request()->routeIs('project.database.configuration') ? 'dark:text-white' : '' }}"
                href="{{ route('project.database.configuration', $parameters) }}">
                Конфігурація
            </a>

            <a class="{{ request()->routeIs('project.database.logs') ? 'dark:text-white' : '' }}"
                href="{{ route('project.database.logs', $parameters) }}">
                Журнали
            </a>
            @can('canAccessTerminal')
                <a class="{{ request()->routeIs('project.database.command') ? 'dark:text-white' : '' }}"
                    href="{{ route('project.database.command', $parameters) }}">
                    Термінал
                </a>
            @endcan
        </nav>
        @if ($database->destination->server->isFunctional())
            <div class="flex flex-wrap gap-2 items-center">
                @if (!str($database->status)->startsWith('exited'))
                    <x-modal-confirmation title="Підтвердити перезапуск бази даних?" buttonTitle="Перезапустити" submitAction="restart"
                        :actions="[
                            'Ця база даних буде недоступна під час перезапуску.',
                            'Якщо база даних зараз використовується, дані можуть бути втрачені.',
                        ]" :confirmWithText="false" :confirmWithPassword="false" step2ButtonText="Перезапустити Базу Даних"
                        :dispatchEvent="true" dispatchEventType="restartEvent">
                        <x-slot:button-title>
                            <svg class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path d="M19.933 13.041a8 8 0 1 1-9.925-8.788c3.899-1 7.935 1.007 9.425 4.747" />
                                    <path d="M20 4v5h-5" />
                                </g>
                            </svg>
                            Перезапустити
                        </x-slot:button-title>
                    </x-modal-confirmation>
                    <x-modal-confirmation title="Підтвердити зупинку бази даних?" buttonTitle="Зупинити" submitAction="stop"
                        :checkboxes="$checkboxes" :actions="[
                            'Цю базу даних буде зупинено.',
                            'Якщо база даних зараз використовується, дані можуть бути втрачені.',
                            'Усі непостійні дані цієї бази даних (контейнери, мережі, невикористовувані образи) буде видалено (не хвилюйтеся, дані не втрачаються, і ви можете запустити базу даних знову).',
                        ]" :confirmWithText="false" :confirmWithPassword="false"
                        step1ButtonText="Продовжити" step2ButtonText="Підтвердити">
                        <x-slot:button-title>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-error" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M6 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                                </path>
                                <path
                                    d="M14 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                                </path>
                            </svg>
                            Зупинити
                        </x-slot:button-title>
                    </x-modal-confirmation>
                @else
                    <button @click="$wire.dispatch('startEvent')" class="gap-2 button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 4v16l13 -8z" />
                        </svg>
                        Запустити
                    </button>
                @endif
                @script
                    <script>
                        $wire.$on('startEvent', () => {
                            window.dispatchEvent(new CustomEvent('startdatabase'));
                            $wire.$call('start');
                        });
                        $wire.$on('restartEvent', () => {
                            $wire.$dispatch('info', 'Перезапуск бази даних.');
                            window.dispatchEvent(new CustomEvent('startdatabase'));
                            $wire.$call('restart');
                        });
                    </script>
                @endscript
            </div>
        @else
            <div class="text-error">Базовий сервер не працює.</div>
        @endif
    </div>
</nav>