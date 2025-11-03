<nav wire:poll.10000ms="checkStatus" class="pb-6">
    <x-resources.breadcrumbs :resource="$application" :parameters="$parameters" :title="$lastDeploymentInfo" :lastDeploymentLink="$lastDeploymentLink" />
    <div class="navbar-main">
        <nav class="flex shrink-0 gap-6 items-center whitespace-nowrap scrollbar min-h-10">
            <a class="{{ request()->routeIs('project.application.configuration') ? 'dark:text-white' : '' }}"
                href="{{ route('project.application.configuration', $parameters) }}">
                Конфігурація
            </a>
            <a class="{{ request()->routeIs('project.application.deployment.index') ? 'dark:text-white' : '' }}"
                href="{{ route('project.application.deployment.index', $parameters) }}">
                Розгортання
            </a>
            <a class="{{ request()->routeIs('project.application.logs') ? 'dark:text-white' : '' }}"
                href="{{ route('project.application.logs', $parameters) }}">
                Журнали
            </a>
            @if (!$application->destination->server->isSwarm())
                @can('canAccessTerminal')
                    <a class="{{ request()->routeIs('project.application.command') ? 'dark:text-white' : '' }}"
                        href="{{ route('project.application.command', $parameters) }}">
                        Термінал
                    </a>
                @endcan
            @endif
            <x-applications.links :application="$application" />
        </nav>
        <div class="flex flex-wrap gap-2 items-center">
            @if ($application->build_pack === 'dockercompose' && is_null($application->docker_compose_raw))
                <div>Будь ласка, завантажте файл Compose.</div>
            @else
                @if (!$application->destination->server->isSwarm())
                    <div>
                        <x-applications.advanced :application="$application" />
                    </div>
                @endif
                <div class="flex flex-wrap gap-2">
                    @if (!str($application->status)->startsWith('exited'))
                        @if (!$application->destination->server->isSwarm())
                            <x-forms.button title="З послідовним оновленням, якщо можливо" wire:click='deploy'>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:text-orange-400"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M10.09 4.01l.496 -.495a2 2 0 0 1 2.828 0l7.071 7.07a2 2 0 0 1 0 2.83l-7.07 7.07a2 2 0 0 1 -2.83 0l-7.07 -7.07a2 2 0 0 1 0 -2.83l3.535 -3.535h-3.988">
                                    </path>
                                    <path d="M7.05 11.038v-3.988"></path>
                                </svg>
                                Перерозгорнути
                            </x-forms.button>
                        @endif
                        @if ($application->build_pack !== 'dockercompose')
                            @if ($application->destination->server->isSwarm())
                                <x-forms.button title="Перерозгорнути службу Swarm (послідовне оновлення)" wire:click='deploy'>
                                    <svg class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <path
                                                d="M19.933 13.041a8 8 0 1 1-9.925-8.788c3.899-1 7.935 1.007 9.425 4.747" />
                                            <path d="M20 4v5h-5" />
                                        </g>
                                    </svg>
                                    Оновити службу
                                </x-forms.button>
                            @else
                                <x-forms.button title="Перезапустити без перезбірки" wire:click='restart'>
                                    <svg class="w-5 h-5 dark:text-warning" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="2">
                                            <path
                                                d="M19.933 13.041a8 8 0 1 1-9.925-8.788c3.899-1 7.935 1.007 9.425 4.747" />
                                            <path d="M20 4v5h-5" />
                                        </g>
                                    </svg>
                                    Перезапустити
                                </x-forms.button>
                            @endif
                        @endif
                        <x-modal-confirmation title="Підтвердити зупинку застосунку?" buttonTitle="Зупинити"
                            submitAction="stop" :checkboxes="$checkboxes" :actions="[
                                'Цей застосунок буде зупинено.',
                                'Усі нестійкі дані цього застосунку буде видалено.',
                            ]" :confirmWithText="false" :confirmWithPassword="false"
                            step1ButtonText="Продовжити" step2ButtonText="Підтвердити">
                            <x-slot:button-title>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-error" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M6 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                                    </path>
                                    <path
                                        d="M14 5m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v12a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z">
                                    </path>
                                </svg>
                                Зупинити
                            </x-slot:button-title>
                        </x-modal-confirmation>
                    @else
                        <x-forms.button wire:click='deploy'>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 dark:text-warning"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M7 4v16l13 -8z" />
                            </svg>
                            Розгорнути
                        </x-forms.button>
                    @endif
                </div>
            @endif
        </div>
    </div>
</nav>