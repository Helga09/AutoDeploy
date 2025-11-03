<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Доступ до терміналу | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar-security :server="$server" :parameters="$parameters" />
        <div class="w-full">
             <div>
                <div class="flex items-center gap-2">
                    <h2>Доступ до терміналу</h2>
                    <x-helper
                        helper="Визначте, чи можуть користувачі (включно з адміністраторами та власником) отримувати доступ до терміналу для цього сервера та його контейнерів з панелі керування.<br/>Лише адміністратори та власники команди можуть змінити цю налаштування."/>
                    @if (auth()->user()->isAdmin())
                        <div wire:key="terminal-access-change-{{ $isTerminalEnabled }}">
                            <x-modal-confirmation title="Підтвердити зміну доступу до терміналу?"
                                temporaryDisableTwoStepConfirmation
                                buttonTitle="{{ $isTerminalEnabled ? 'Вимкнути термінал' : 'Увімкнути термінал' }}"
                                submitAction="toggleTerminal" :actions="[
                                    $isTerminalEnabled
                                        ? 'Це вимкне доступ до терміналу для цього сервера та всіх його контейнерів.'
                                        : 'Це увімкне доступ до терміналу для цього сервера та всіх його контейнерів.',
                                    $isTerminalEnabled
                                        ? 'Користувачі більше не зможуть отримувати доступ до термінальних інтерфейсів з UI.'
                                        : 'Користувачі зможуть отримувати доступ до термінальних інтерфейсів з UI.',
                                    'Ця зміна набуде чинності негайно.',
                                ]" confirmationText="{{ $server->name }}"
                                shortConfirmationLabel="Назва сервера"
                                step3ButtonText="{{ $isTerminalEnabled ? 'Вимкнути термінал' : 'Увімкнути термінал' }}"
                                isHighlightedButton>
                            </x-modal-confirmation>
                        </div>
                    @endif
                </div>
                <div class="mb-4">Керування доступом до терміналу цього сервера та його контейнерів.</div>
            </div>

            <div class="flex items-center gap-2">
                <h3>Статус терміналу:</h3>
                @if ($isTerminalEnabled)
                    <span
                        class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded dark:text-green-100 dark:bg-green-800">
                        Працює
                    </span>
                @else
                    <span
                        class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded dark:text-red-100 dark:bg-red-800">
                        Вимкнено
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>