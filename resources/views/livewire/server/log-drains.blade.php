<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Витоки журналів | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="log-drains" />
        <div class="w-full">
            @if ($server->isFunctional())
                <div class="flex gap-2 items-center">
                    <h2>Витоки журналів</h2>
                    <x-loading wire:target="instantSave" wire:loading.delay />
                </div>
                <div>Надсилає журнали сервісів стороннім інструментам.</div>
                <div class="flex flex-col gap-4 pt-4">
                    <div class="p-4 border dark:border-coolgray-300 border-neutral-200">
                        <form wire:submit='submit("newrelic")' class="flex flex-col">
                            <h3>New Relic</h3>
                            <div class="w-32">
                                @if ($isLogDrainAxiomEnabled || $isLogDrainCustomEnabled)
                                    <x-forms.checkbox disabled id="isLogDrainNewRelicEnabled" label="Увімкнено" />
                                @else
                                    <x-forms.checkbox instantSave canGate="update" :canResource="$server"
                                        id="isLogDrainNewRelicEnabled" label="Увімкнено" />
                                @endif
                            </div>
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col w-full gap-2 xl:flex-row">
                                    @if ($server->isLogDrainEnabled())
                                        <x-forms.input disabled type="password" required id="logDrainNewRelicLicenseKey"
                                            label="Ліцензійний ключ" />
                                        <x-forms.input disabled required id="logDrainNewRelicBaseUri"
                                            placeholder="https://log-api.eu.newrelic.com/log/v1"
                                            helper="Для використання в ЄС: https://log-api.eu.newrelic.com/log/v1<br>Для використання в США: https://log-api.newrelic.com/log/v1"
                                            label="Кінцева точка" />
                                    @else
                                        <x-forms.input canGate="update" :canResource="$server" type="password" required
                                            id="logDrainNewRelicLicenseKey" label="Ліцензійний ключ" />
                                        <x-forms.input canGate="update" :canResource="$server" required
                                            id="logDrainNewRelicBaseUri"
                                            placeholder="https://log-api.eu.newrelic.com/log/v1"
                                            helper="Для використання в ЄС: https://log-api.eu.newrelic.com/log/v1<br>Для використання в США: https://log-api.newrelic.com/log/v1"
                                            label="Кінцева точка" />
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-6">
                                <x-forms.button canGate="update" :canResource="$server" type="submit">
                                    Зберегти
                                </x-forms.button>
                            </div>
                        </form>

                        <h3>Axiom</h3>
                        <div class="w-32">
                            @if ($isLogDrainNewRelicEnabled || $isLogDrainCustomEnabled)
                                <x-forms.checkbox disabled id="isLogDrainAxiomEnabled" label="Увімкнено" />
                            @else
                                <x-forms.checkbox instantSave canGate="update" :canResource="$server"
                                    id="isLogDrainAxiomEnabled" label="Увімкнено" />
                            @endif
                        </div>
                        <form wire:submit='submit("axiom")' class="flex flex-col">
                            <div class="flex flex-col gap-4">
                                <div class="flex flex-col w-full gap-2 xl:flex-row">
                                    @if ($server->isLogDrainEnabled())
                                        <x-forms.input disabled type="password" required id="logDrainAxiomApiKey"
                                            label="Ключ API" />
                                        <x-forms.input disabled required id="logDrainAxiomDatasetName"
                                            label="Назва набору даних" />
                                    @else
                                        <x-forms.input canGate="update" :canResource="$server" type="password" required
                                            id="logDrainAxiomApiKey" label="Ключ API" />
                                        <x-forms.input canGate="update" :canResource="$server" required
                                            id="logDrainAxiomDatasetName" label="Назва набору даних" />
                                    @endif
                                </div>
                            </div>
                            <div class="flex justify-end gap-4 pt-6">
                                <x-forms.button canGate="update" :canResource="$server" type="submit">
                                    Зберегти
                                </x-forms.button>
                            </div>
                        </form>
                        <h3>Користувацький FluentBit</h3>
                        <div class="w-32">
                            @if ($isLogDrainNewRelicEnabled || $isLogDrainAxiomEnabled)
                                <x-forms.checkbox disabled id="isLogDrainCustomEnabled" label="Увімкнено" />
                            @else
                                <x-forms.checkbox instantSave canGate="update" :canResource="$server"
                                    id="isLogDrainCustomEnabled" label="Увімкнено" />
                            @endif
                        </div>
                        <form wire:submit='submit("custom")' class="flex flex-col">
                            <div class="flex flex-col gap-4">
                                @if ($server->isLogDrainEnabled())
                                    <x-forms.textarea disabled rows="6" required id="logDrainCustomConfig"
                                        label="Користувацька конфігурація FluentBit" />
                                    <x-forms.textarea disabled id="logDrainCustomConfigParser"
                                        label="Користувацька конфігурація парсера" />
                                @else
                                    <x-forms.textarea canGate="update" :canResource="$server" rows="6" required
                                        id="logDrainCustomConfig" label="Користувацька конфігурація FluentBit" />
                                    <x-forms.textarea canGate="update" :canResource="$server"
                                        id="logDrainCustomConfigParser" label="Користувацька конфігурація парсера" />
                                @endif

                            </div>
                            <div class="flex justify-end gap-4 pt-6">
                                <x-forms.button canGate="update" :canResource="$server" type="submit">
                                    Зберегти
                                </x-forms.button>
                            </div>
                        </form>

                    </div>
                </div>
            @else
                <div>Сервер не перевірено. Спочатку перевірте.</div>
            @endif
        </div>
    </div>
</div>