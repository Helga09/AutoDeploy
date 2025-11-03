<div x-data x-init="@if ($server->hetzner_server_id && $server->cloudProviderToken && !$hetznerServerStatus) $wire.checkHetznerServerStatus() @endif">
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Загальні | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="general" />
        <div class="w-full">
            <form wire:submit.prevent='submit' class="flex flex-col">
                <div class="flex gap-2">
                    <h2>Загальні</h2>
                    @if ($server->hetzner_server_id)
                        <div class="flex items-center">
                            <div @class([
                                'flex items-center gap-1.5 px-2 py-1 text-xs font-semibold rounded transition-all',
                                'bg-white dark:bg-coolgray-100 dark:text-white',
                            ])
                                @if (in_array($hetznerServerStatus, ['starting', 'initializing'])) wire:poll.5s="checkHetznerServerStatus" @endif>
                                <svg class="w-4 h-4" viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="200" height="200" fill="#D50C2D" rx="8" />
                                    <path d="M40 40 H60 V90 H140 V40 H160 V160 H140 V110 H60 V160 H40 Z"
                                        fill="white" />
                                </svg>
                                @if ($hetznerServerStatus)
                                    <span class="pl-1.5">
                                        @if (in_array($hetznerServerStatus, ['starting', 'initializing']))
                                            <svg class="inline animate-spin h-3 w-3 mr-1 text-coollabs dark:text-yellow-500"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        @endif
                                        <span @class([
                                            'text-green-500' => $hetznerServerStatus === 'running',
                                            'text-red-500' => $hetznerServerStatus === 'off',
                                        ])>
                                            {{ ucfirst($hetznerServerStatus) }}
                                        </span>
                                    </span>
                                @else
                                    <span class="pl-1.5">
                                        <svg class="inline animate-spin h-3 w-3 mr-1 text-coollabs dark:text-yellow-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span>Перевірка статусу...</span>
                                    </span>
                                @endif
                            </div>
                            <button wire:loading.remove wire:target="checkHetznerServerStatus" title="Оновити статус"
                                wire:click.prevent='checkHetznerServerStatus(true)'
                                class="mx-1 dark:hover:fill-white fill-black dark:fill-warning">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2a10.016 10.016 0 0 0-7 2.877V3a1 1 0 1 0-2 0v4.5a1 1 0 0 0 1 1h4.5a1 1 0 0 0 0-2H6.218A7.98 7.98 0 0 1 20 12a1 1 0 0 0 2 0A10.012 10.012 0 0 0 12 2zm7.989 13.5h-4.5a1 1 0 0 0 0 2h2.293A7.98 7.98 0 0 1 4 12a1 1 0 0 0-2 0a9.986 9.986 0 0 0 16.989 7.133V21a1 1 0 0 0 2 0v-4.5a1 1 0 0 0-1-1z" />
                                </svg>
                            </button>
                            <button wire:loading wire:target="checkHetznerServerStatus" title="Оновлення статусу"
                                class="mx-1 dark:hover:fill-white fill-black dark:fill-warning">
                                <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M12 2a10.016 10.016 0 0 0-7 2.877V3a1 1 0 1 0-2 0v4.5a1 1 0 0 0 1 1h4.5a1 1 0 0 0 0-2H6.218A7.98 7.98 0 0 1 20 12a1 1 0 0 0 2 0A10.012 10.012 0 0 0 12 2zm7.989 13.5h-4.5a1 1 0 0 0 0 2h2.293A7.98 7.98 0 0 1 4 12a1 1 0 0 0-2 0a9.986 9.986 0 0 0 16.989 7.133V21a1 1 0 0 0 2 0v-4.5a1 1 0 0 0-1-1z" />
                                </svg>
                            </button>
                        </div>
                        @if ($server->cloudProviderToken && !$server->isFunctional() && $hetznerServerStatus === 'off')
                            <x-forms.button wire:click.prevent='startHetznerServer' isHighlighted canGate="update"
                                :canResource="$server">
                                Увімкнути
                            </x-forms.button>
                        @endif
                    @endif
                    @if ($isValidating)
                        <div
                            class="flex items-center gap-1.5 px-2 py-1 text-xs font-semibold rounded bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400">
                            <svg class="inline animate-spin h-3 w-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span>Перевірка...</span>
                        </div>
                    @endif
                    @if ($server->id === 0)
                        <x-modal-confirmation title="Підтвердити зміну налаштувань сервера?" buttonTitle="Зберегти"
                            submitAction="submit" :actions="[
                                'Якщо ви неправильно налаштуєте сервер, ви можете втратити багато функцій Coolify.',
                            ]" :confirmWithText="false" :confirmWithPassword="false"
                            step2ButtonText="Зберегти" canGate="update" :canResource="$server" />
                    @else
                        <x-forms.button type="submit" canGate="update" :canResource="$server"
                            :disabled="$isValidating">Зберегти</x-forms.button>
                        @if ($server->isFunctional())
                            <x-slide-over closeWithX fullScreen>
                                <x-slot:title>Перевірити та налаштувати</x-slot:title>
                                <x-slot:content>
                                    <livewire:server.validate-and-install :server="$server" ask />
                                </x-slot:content>
                                <x-forms.button @click="slideOverOpen=true" wire:click.prevent='validateServer'
                                    isHighlighted canGate="update" :canResource="$server">
                                    Перевірити сервер ще раз
                                </x-forms.button>
                            </x-slide-over>
                        @endif
                    @endif
                </div>
                @if ($server->isFunctional())
                    Сервер доступний та перевірений.
                @else
                    Ви не можете використовувати цей сервер, доки його не буде перевірено.
                @endif
                @if ($isValidating)
                    <div x-data="{ slideOverOpen: true }">
                        <x-slide-over closeWithX fullScreen>
                            <x-slot:title>Перевірка в процесі</x-slot:title>
                            <x-slot:content>
                                <livewire:server.validate-and-install :server="$server" />
                            </x-slot:content>
                        </x-slide-over>
                    </div>
                @endif
                @if (
                    (!$isReachable || !$isUsable) &&
                        $server->id !== 0 &&
                        !$isValidating &&
                        !in_array($hetznerServerStatus, ['initializing', 'starting', 'stopping', 'off']))
                    <x-slide-over closeWithX fullScreen>
                        <x-slot:title>Перевірити та налаштувати</x-slot:title>
                        <x-slot:content>
                            <livewire:server.validate-and-install :server="$server" />
                        </x-slot:content>
                        <x-forms.button @click="slideOverOpen=true"
                            class="mt-8 mb-4 w-full font-bold box-without-bg bg-coollabs hover:bg-coollabs-100"
                            wire:click.prevent='validateServer' isHighlighted>
                            Перевірити сервер та встановити Docker Engine
                        </x-forms.button>
                    </x-slide-over>
                    @if ($server->validation_logs)
                        <h4>Попередні журнали перевірки</h4>
                        <div class="pb-8">
                            {!! $server->validation_logs !!}
                        </div>
                    @endif
                @endif
                @if ((!$isReachable || !$isUsable) && $server->id === 0)
                    <x-forms.button class="mt-8 mb-4 font-bold box-without-bg bg-coollabs hover:bg-coollabs-100"
                        wire:click.prevent='checkLocalhostConnection' isHighlighted>
                        Перевірити сервер
                    </x-forms.button>
                @endif
                @if ($server->isForceDisabled() && isCloud())
                    <x-callout type="danger" title="Сервер вимкнено" class="mt-4">
                        Система вимкнула сервер, оскільки ви перевищили кількість серверів, за які ви заплатили.
                    </x-callout>
                @endif
                <div class="flex flex-col gap-2 pt-4">
                    <div class="flex flex-col gap-2 w-full lg:flex-row">
                        <x-forms.input canGate="update" :canResource="$server" id="name" label="Ім'я" required
                            :disabled="$isValidating" />
                        <x-forms.input canGate="update" :canResource="$server" id="description" label="Опис"
                            :disabled="$isValidating" />
                        @if (!$isSwarmWorker && !$isBuildServer)
                            <x-forms.input canGate="update" :canResource="$server" placeholder="https://example.com"
                                id="wildcardDomain" label="Домен з підстановкою"
                                helper='Домен з підстановкою дозволяє отримувати випадково згенерований домен для ваших нових програм. <br><br>Наприклад, якщо ви встановите "https://example.com" як ваш домен з підстановкою, ваші програми отримуватимуть домени типу "https://randomId.example.com".'
                                :disabled="$isValidating" />
                        @endif

                    </div>
                    <div class="flex flex-col gap-2 w-full lg:flex-row">
                        <x-forms.input canGate="update" :canResource="$server" type="password" id="ip"
                            label="IP-адреса/Домен"
                            helper="IP-адреса (127.0.0.1) або домен (example.com). Переконайтеся, що немає протоколу на зразок http(s)://, тобто ви надаєте FQDN, а не URL."
                            required :disabled="$isValidating" />
                        <div class="flex gap-2">
                            <x-forms.input canGate="update" :canResource="$server" id="user" label="Користувач" required
                                :disabled="$isValidating" />
                            <x-forms.input canGate="update" :canResource="$server" type="number" id="port"
                                label="Порт" required :disabled="$isValidating" />
                        </div>
                    </div>
                    <div class="w-full">
                        <div class="flex items-center mb-1">
                            <label for="serverTimezone">Часовий пояс сервера</label>
                            <x-helper class="ml-2"
                                helper="Часовий пояс сервера. Використовується для резервних копій, cron-завдань тощо." />
                        </div>
                        @can('update', $server)
                            @if ($isValidating)
                                <div class="relative">
                                    <div class="inline-flex relative items-center w-64">
                                        <input readonly disabled autocomplete="off"
                                            class="w-full input opacity-50 cursor-not-allowed"
                                            value="{{ $serverTimezone ?: 'Часовий пояс не встановлено' }}"
                                            placeholder="Часовий пояс сервера">
                                        <svg class="absolute right-0 mr-2 w-4 h-4 opacity-50"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <div x-data="{
                                    open: false,
                                    search: '{{ $serverTimezone ?: '' }}',
                                    timezones: @js($this->timezones),
                                    placeholder: '{{ $serverTimezone ? 'Шукати часовий пояс...' : 'Виберіть часовий пояс сервера' }}',
                                    init() {
                                        this.$watch('search', value => {
                                            if (value === '') {
                                                this.open = true;
                                            }
                                        })
                                    }
                                }">
                                    <div class="relative">
                                        <div class="inline-flex relative items-center w-64">
                                            <input autocomplete="off"
                                                wire:dirty.class.remove='dark:focus:ring-coolgray-300 dark:ring-coolgray-300'
                                                wire:dirty.class="dark:focus:ring-warning dark:ring-warning"
                                                x-model="search" @focus="open = true" @click.away="open = false"
                                                @input="open = true" class="w-full input" :placeholder="placeholder"
                                                wire:model="serverTimezone">
                                            <svg class="absolute right-0 mr-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" @click="open = true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </div>
                                        <div x-show="open"
                                            class="overflow-auto overflow-x-hidden absolute z-50 mt-1 w-64 max-h-60 bg-white rounded-md border shadow-lg dark:bg-coolgray-100 dark:border-coolgray-200 scrollbar">
                                            <template
                                                x-for="timezone in timezones.filter(tz => tz.toLowerCase().includes(search.toLowerCase()))"
                                                :key="timezone">
                                                <div @click="search = timezone; open = false; $wire.set('serverTimezone', timezone); $wire.submit()"
                                                    class="px-4 py-2 text-gray-800 cursor-pointer hover:bg-gray-100 dark:hover:bg-coolgray-300 dark:text-gray-200"
                                                    x-text="timezone"></div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="relative">
                                <div class="inline-flex relative items-center w-64">
                                    <input readonly disabled autocomplete="off"
                                        class="w-full input opacity-50 cursor-not-allowed"
                                        value="{{ $serverTimezone ?: 'Часовий пояс не встановлено' }}" placeholder="Часовий пояс сервера">
                                    <svg class="absolute right-0 mr-2 w-4 h-4 opacity-50"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </div>
                            </div>
                        @endcan
                    </div>

                    <div class="w-full">
                        @if (!$server->isLocalhost())
                            <div class="w-96">
                                @if ($isBuildServerLocked)
                                    <x-forms.checkbox disabled instantSave id="isBuildServer"
                                        helper="Ви не можете використовувати цей сервер як сервер збірки, оскільки він має визначені ресурси."
                                        label="Використовувати як сервер збірки?" />
                                @else
                                    <x-forms.checkbox canGate="update" :canResource="$server" instantSave
                                        id="isBuildServer" label="Використовувати як сервер збірки?" :disabled="$isValidating" />
                                @endif
                            </div>

                            @if (!$server->isBuildServer() && !$server->settings->is_cloudflare_tunnel)
                                <h3 class="pt-6">Swarm <span class="text-xs text-neutral-500">(експериментально)</span>
                                </h3>
                                <div class="pb-4">Прочитайте документацію <a class='underline dark:text-white'
                                        href='https://coolify.io/docs/knowledge-base/docker/swarm'
                                        target='_blank'>тут</a>.
                                </div>
                                <div class="w-96">
                                    @if ($server->settings->is_swarm_worker)
                                        <x-forms.checkbox disabled instantSave type="checkbox" id="isSwarmManager"
                                            helper="Для отримання додаткової інформації прочитайте документацію <a class='dark:text-white' href='https://coolify.io/docs/knowledge-base/docker/swarm' target='_blank'>тут</a>."
                                            label="Це Swarm Manager?" />
                                    @else
                                        <x-forms.checkbox canGate="update" :canResource="$server" instantSave
                                            type="checkbox" id="isSwarmManager"
                                            helper="Для отримання додаткової інформації прочитайте документацію <a class='dark:text-white' href='https://coolify.io/docs/knowledge-base/docker/swarm' target='_blank'>тут</a>."
                                            label="Це Swarm Manager?" :disabled="$isValidating" />
                                    @endif

                                    @if ($server->settings->is_swarm_manager)
                                        <x-forms.checkbox disabled instantSave type="checkbox" id="isSwarmWorker"
                                            helper="Для отримання додаткової інформації прочитайте документацію <a class='dark:text-white' href='https://coolify.io/docs/knowledge-base/docker/swarm' target='_blank'>тут</a>."
                                            label="Це Swarm Worker?" />
                                    @else
                                        <x-forms.checkbox canGate="update" :canResource="$server" instantSave
                                            type="checkbox" id="isSwarmWorker"
                                            helper="Для отримання додаткової інформації прочитайте документацію <a class='dark:text-white' href='https://coolify.io/docs/knowledge-base/docker/swarm' target='_blank'>тут</a>."
                                            label="Це Swarm Worker?" :disabled="$isValidating" />
                                    @endif
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </form>
            @if ($server->isFunctional() && !$server->isSwarm() && !$server->isBuildServer())
                <form wire:submit.prevent='submit'>
                    <div class="flex gap-2 items-center pt-4 pb-2">
                        <h3>Sentinel</h3>
                        <x-helper helper="Sentinel повідомляє про стан вашого сервера та контейнерів, а також збирає метрики." />
                        @if ($server->isSentinelEnabled())
                            <div class="flex gap-2 items-center">
                                @if ($server->isSentinelLive())
                                    <x-status.running status="Синхронізовано" noLoading title="{{ $sentinelUpdatedAt }}" />
                                    <x-forms.button type="submit" canGate="update" :canResource="$server"
                                        :disabled="$isValidating">Зберегти</x-forms.button>
                                    <x-forms.button wire:click='restartSentinel' canGate="update" :canResource="$server"
                                        :disabled="$isValidating">Перезапустити</x-forms.button>
                                    <x-slide-over fullScreen>
                                        <x-slot:title>Журнали Sentinel</x-slot:title>
                                        <x-slot:content>
                                            <livewire:project.shared.get-logs :server="$server"
                                                container="coolify-sentinel" displayName="Sentinel" lazy />
                                        </x-slot:content>
                                        <x-forms.button @click="slideOverOpen=true"
                                            :disabled="$isValidating">Журнали</x-forms.button>
                                    </x-slide-over>
                                @else
                                    <x-status.stopped status="Не синхронізовано" noLoading
                                        title="{{ $sentinelUpdatedAt }}" />
                                    <x-forms.button type="submit" canGate="update" :canResource="$server"
                                        :disabled="$isValidating">Зберегти</x-forms.button>
                                    <x-forms.button wire:click='restartSentinel' canGate="update" :canResource="$server"
                                        :disabled="$isValidating">Синхронізувати</x-forms.button>
                                    <x-slide-over fullScreen>
                                        <x-slot:title>Журнали Sentinel</x-slot:title>
                                        <x-slot:content>
                                            <livewire:project.shared.get-logs :server="$server"
                                                container="coolify-sentinel" displayName="Sentinel" lazy />
                                        </x-slot:content>
                                        <x-forms.button @click="slideOverOpen=true"
                                            :disabled="$isValidating">Журнали</x-forms.button>
                                    </x-slide-over>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="w-96">
                            <x-forms.checkbox canGate="update" :canResource="$server" wire:model.live="isSentinelEnabled"
                                label="Увімкнути Sentinel" :disabled="$isValidating" />
                            @if ($server->isSentinelEnabled())
                                @if (isDev())
                                    <x-forms.checkbox canGate="update" :canResource="$server" id="isSentinelDebugEnabled"
                                        label="Увімкнути Sentinel (з налагодженням)" instantSave :disabled="$isValidating" />
                                @endif
                                <x-forms.checkbox canGate="update" :canResource="$server" instantSave
                                    id="isMetricsEnabled" label="Увімкнути метрики" :disabled="$isValidating" />
                            @else
                                @if (isDev())
                                    <x-forms.checkbox id="isSentinelDebugEnabled" label="Увімкнути Sentinel (з налагодженням)"
                                        disabled instantSave />
                                @endif
                                <x-forms.checkbox instantSave disabled id="isMetricsEnabled"
                                    label="Увімкнути метрики (спочатку увімкніть Sentinel)" />
                            @endif
                        </div>
                        @if (isDev() && $server->isSentinelEnabled())
                            <div class="pt-4" x-data="{
                                customImage: localStorage.getItem('sentinel_custom_docker_image_{{ $server->uuid }}') || '',
                                saveCustomImage() {
                                    localStorage.setItem('sentinel_custom_docker_image_{{ $server->uuid }}', this.customImage);
                                    $wire.set('sentinelCustomDockerImage', this.customImage);
                                }
                            }" x-init="$wire.set('sentinelCustomDockerImage', customImage)">
                                <x-forms.input x-model="customImage" @input.debounce.500ms="saveCustomImage()"
                                    placeholder="e.g., sentinel:latest or myregistry/sentinel:dev"
                                    label="Спеціальний образ Docker для Sentinel (лише для розробників)"
                                    helper="Перевизначити стандартний образ Docker для Sentinel для тестування. Залиште порожнім, щоб використовувати стандартний." />
                            </div>
                        @endif
                        @if ($server->isSentinelEnabled())
                            <div class="flex flex-wrap gap-2 sm:flex-nowrap items-end">
                                <x-forms.input canGate="update" :canResource="$server" type="password" id="sentinelToken"
                                    label="Токен Sentinel" required helper="Токен для Sentinel." :disabled="$isValidating" />
                                <x-forms.button canGate="update" :canResource="$server"
                                    wire:click="regenerateSentinelToken" :disabled="$isValidating">Згенерувати заново</x-forms.button>
                            </div>

                            <x-forms.input canGate="update" :canResource="$server" id="sentinelCustomUrl" required
                                label="URL Coolify"
                                helper="URL вашого екземпляра Coolify. Якщо він порожній, це означає, що ви не встановили FQDN для вашого екземпляра Coolify."
                                :disabled="$isValidating" />

                            <div class="flex flex-col gap-2">
                                <div class="flex flex-wrap gap-2 sm:flex-nowrap">
                                    <x-forms.input canGate="update" :canResource="$server"
                                        id="sentinelMetricsRefreshRateSeconds" label="Частота метрик (секунди)" required
                                        helper="Інтервал, що використовується для збору метрик. Менші значення призводять до більшого використання дискового простору."
                                        :disabled="$isValidating" />
                                    <x-forms.input canGate="update" :canResource="$server" id="sentinelMetricsHistoryDays"
                                        label="Історія метрик (днів)" required
                                        helper="Кількість днів для зберігання даних метрик." :disabled="$isValidating" />
                                    <x-forms.input canGate="update" :canResource="$server"
                                        id="sentinelPushIntervalSeconds" label="Інтервал надсилання (секунди)" required
                                        helper="Інтервал, через який дані метрик надсилаються збирачу."
                                        :disabled="$isValidating" />
                                </div>
                            </div>
                        @endif
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>