<div wire:poll.10000ms="checkStatus" class="pb-6">
    <livewire:project.shared.configuration-checker :resource="$service" />
    <x-slide-over @startservice.window="slideOverOpen = true" closeWithX fullScreen>
        <x-slot:title>Запуск сервісу</x-slot:title>
        <x-slot:content>
            <livewire:activity-monitor header="Журнали" fullHeight />
        </x-slot:content>
    </x-slide-over>
    <h1>{{ $title }}</h1>
    <x-resources.breadcrumbs :resource="$service" :parameters="$parameters" />
    <div class="navbar-main" x-data>
        <nav class="flex shrink-0 gap-6 items-center whitespace-nowrap scrollbar min-h-10">
            <a class="{{ request()->routeIs('project.service.configuration') ? 'dark:text-white' : '' }}"
                href="{{ route('project.service.configuration', $parameters) }}">
                <button>Конфігурація</button>
            </a>
            <a class="{{ request()->routeIs('project.service.logs') ? 'dark:text-white' : '' }}"
                href="{{ route('project.service.logs', $parameters) }}">
                <button>Журнали</button>
            </a>
            @can('canAccessTerminal')
                <a class="{{ request()->routeIs('project.service.command') ? 'dark:text-white' : '' }}"
                    href="{{ route('project.service.command', $parameters) }}">
                    <button>Термінал</button>
                </a>
            @endcan
            <x-services.links :service="$service" />
        </nav>
        @if ($service->isDeployable)
            <div class="flex flex-wrap order-first gap-2 items-center sm:order-last">
                <x-services.advanced :service="$service" />
                @if (str($service->status)->contains('running'))
                    <x-forms.button title="Перезапустити" @click="$wire.dispatch('restartEvent')">
                        <svg class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path d="M19.933 13.041a8 8 0 1 1-9.925-8.788c3.899-1 7.935 1.007 9.425 4.747" />
                                <path d="M20 4v5h-5" />
                            </g>
                        </svg>
                        Перезапустити
                    </x-forms.button>
                    <x-modal-confirmation title="Підтвердити зупинку сервісу?" buttonTitle="Зупинити" :dispatchEvent="true"
                        submitAction="stop" dispatchEventType="stopEvent" :checkboxes="$checkboxes" :actions="[__('service.stop'), __('resource.non_persistent')]"
                        :confirmWithText="false" :confirmWithPassword="false" step1ButtonText="Продовжити" step2ButtonText="Підтвердити">
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
                @elseif (str($service->status)->contains('degraded'))
                    <x-forms.button title="Перезапустити" @click="$wire.dispatch('restartEvent')">
                        <svg class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2">
                                <path d="M19.933 13.041a8 8 0 1 1-9.925-8.788c3.899-1 7.935 1.007 9.425 4.747" />
                                <path d="M20 4v5h-5" />
                            </g>
                        </svg>
                        Перезапустити
                    </x-forms.button>
                    <x-modal-confirmation title="Підтвердити зупинку сервісу?" buttonTitle="Зупинити" :dispatchEvent="true"
                        submitAction="stop" dispatchEventType="stopEvent" :checkboxes="$checkboxes" :actions="[__('service.stop'), __('resource.non_persistent')]"
                        :confirmWithText="false" :confirmWithPassword="false" step1ButtonText="Продовжити" step2ButtonText="Підтвердити">
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
                @elseif (str($service->status)->contains('exited'))
                    <button @click="$wire.dispatch('startEvent')" class="gap-2 button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 4v16l13 -8z" />
                        </svg>
                        Розгорнути
                    </button>
                @else
                    <x-modal-confirmation title="Підтвердити зупинку сервісу?" buttonTitle="Зупинити" :dispatchEvent="true"
                        submitAction="stop" dispatchEventType="stopEvent" :checkboxes="$checkboxes" :actions="[__('service.stop'), __('resource.non_persistent')]"
                        :confirmWithText="false" :confirmWithPassword="false" step1ButtonText="Продовжити" step2ButtonText="Підтвердити">
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
                    <button @click="$wire.dispatch('startEvent')" class="gap-2 button">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 4v16l13 -8z" />
                        </svg>
                        Розгорнути
                    </button>
                @endif
            </div>
        @else
            <div class="flex flex-wrap order-first gap-2 items-center sm:order-last">
                <div class="text-error">
                    Неможливо розгорнути. <a class="underline font-bold cursor-pointer"
                        href="{{ route('project.service.environment-variables', $parameters) }}">
                        Відсутні обов'язкові змінні оточення.</a>
                </div>
            </div>
        @endif
    </div>
    @script
        <script>
            $wire.$on('stopEvent', () => {
                $wire.$dispatch('info',
                    'Сервіс плавно зупиняється.<br/><br/>Це може зайняти деякий час залежно від сервісу.');
                $wire.$call('stop');
            });
            $wire.$on('startEvent', async () => {
                const isDeploymentProgress = await $wire.$call('checkDeployments');
                if (isDeploymentProgress) {
                    $wire.$dispatch('error',
                        'Розгортання вже триває.<br><br>Ви можете примусово розгорнути в розділі «Розширені налаштування».');
                    return;
                }
                window.dispatchEvent(new CustomEvent('startservice'));
                $wire.$call('start');
            });
            $wire.$on('forceDeployEvent', () => {
                window.dispatchEvent(new CustomEvent('startservice'));
                $wire.$call('forceDeploy');
            });
            $wire.$on('restartEvent', async () => {
                const isDeploymentProgress = await $wire.$call('checkDeployments');
                if (isDeploymentProgress) {
                    $wire.$dispatch('error',
                        'Розгортання вже триває.<br><br>Ви можете примусово розгорнути в розділі «Розширені налаштування».');
                    return;
                }
                $wire.$dispatch('info',
                    'Сервіс плавно зупиняється.<br/><br/>Це може зайняти деякий час залежно від сервісу.');
                window.dispatchEvent(new CustomEvent('startservice'));
                $wire.$call('restart');
            });
            $wire.$on('pullAndRestartEvent', () => {
                $wire.$dispatch('info', 'Витягуємо нові образи та перезапускаємо сервіс.');
                window.dispatchEvent(new CustomEvent('startservice'));
                $wire.$call('pullAndRestartEvent');
            });
            $wire.on('imagePulled', () => {
                window.dispatchEvent(new CustomEvent('startservice'));
                $wire.$dispatch('info', 'Перезапускаємо сервіс.');
            });
        </script>
    @endscript
</div>