@php use App\Enums\ProxyTypes; @endphp
<div>
    @if ($server->proxyType())
        <div x-init="$wire.loadProxyConfiguration">
            @if ($selectedProxy !== 'NONE')
                <form wire:submit='submit'>
                    <div class="flex items-center gap-2">
                        <h2>Конфігурація</h2>
                        @if ($server->proxy->status === 'exited' || $server->proxy->status === 'removing')
                            @can('update', $server)
                                <x-modal-confirmation title="Підтвердити перемикання проксі?" buttonTitle="Перемкнути проксі"
                                    submitAction="changeProxy" :actions="['Користувацькі конфігурації проксі можуть бути скинуті до налаштувань за замовчуванням.']"
                                    warningMessage="Ця операція може спричинити проблеми. Будь ласка, зверніться до посібника <a href='https://coolify.io/docs/knowledge-base/server/proxies#switch-between-proxies' target='_blank' class='underline text-white'>перемикання між проксі</a> перед продовженням!"
                                    step2ButtonText="Перемкнути проксі" :confirmWithText="false" :confirmWithPassword="false">
                                </x-modal-confirmation>
                            @endcan
                        @else
                            <x-forms.button canGate="update" :canResource="$server"
                                wire:click="$dispatch('error', 'Поточний проксі повинен бути зупинений перед перемиканням')">Перемкнути
                                проксі</x-forms.button>
                        @endif
                        <x-forms.button canGate="update" :canResource="$server" type="submit">Зберегти</x-forms.button>
                    </div>
                    <div class="subtitle">Налаштуйте параметри проксі та розширені опції.</div>
                    <h3>Розширені</h3>
                    <div class="pb-6 w-96">
                        <x-forms.checkbox canGate="update" :canResource="$server"
                            helper="Якщо встановлено, усі ресурси матимуть мітки контейнерів Docker лише для {{ str($server->proxyType())->title() }}.<br>Для програм мітки потрібно генерувати вручну. <br>Ресурси потрібно перезапустити."
                            id="generateExactLabels"
                            label="Генерувати мітки лише для {{ str($server->proxyType())->title() }}" instantSave />
                        <x-forms.checkbox canGate="update" :canResource="$server" instantSave="instantSaveRedirect"
                            id="redirectEnabled" label="Перевизначити обробник запитів за замовчуванням"
                            helper="Запити до невідомих хостів або зупинених служб отримають відповідь 503 або будуть перенаправлені на URL-адресу, яку ви встановили нижче (потрібно спочатку увімкнути)." />
                        @if ($redirectEnabled)
                            <x-forms.input canGate="update" :canResource="$server" placeholder="https://app.coolify.io"
                                id="redirectUrl" label="Перенаправити на (необов'язково)" />
                        @endif
                    </div>
                    @php
                        $proxyTitle =
                            $server->proxyType() === ProxyTypes::TRAEFIK->value
                                ? 'Traefik (Проксі Coolify)'
                                : 'Caddy (Проксі Coolify)';
                    @endphp
                    @if ($server->proxyType() === ProxyTypes::TRAEFIK->value || $server->proxyType() === 'CADDY')
                        <div class="flex items-center gap-2">
                            <h3>{{ $proxyTitle }}</h3>
                            @if ($proxySettings)
                                @can('update', $server)
                                    <x-modal-confirmation title="Скинути конфігурацію проксі?"
                                        buttonTitle="Скинути конфігурацію" submitAction="resetProxyConfiguration"
                                        :actions="[
                                            'Скинути конфігурацію проксі до налаштувань за замовчуванням',
                                            'Усі користувацькі конфігурації будуть втрачені',
                                            'Користувацькі порти та точки входу будуть видалені',
                                        ]" confirmationText="{{ $server->name }}"
                                        confirmationLabel="Будь ласка, підтвердіть, ввівши назву сервера нижче"
                                        shortConfirmationLabel="Назва сервера" step2ButtonText="Скинути конфігурацію"
                                        :confirmWithPassword="false" :confirmWithText="true">
                                    </x-modal-confirmation>
                                @endcan
                            @endif
                        </div>
                    @endif
                    @if (
                        $server->proxy->last_applied_settings &&
                            $server->proxy->last_saved_settings !== $server->proxy->last_applied_settings)
                        <div class="text-red-500 ">Конфігурація не синхронізована. Перезапустіть проксі, щоб застосувати нові
                            конфігурації.
                        </div>
                    @endif
                    <div wire:loading wire:target="loadProxyConfiguration" class="pt-4">
                        <x-loading text="Завантаження конфігурації проксі..." />
                    </div>
                    <div wire:loading.remove wire:target="loadProxyConfiguration">
                        @if ($proxySettings)
                            <div class="flex flex-col gap-2 pt-2">
                                <x-forms.textarea canGate="update" :canResource="$server" useMonacoEditor
                                    monacoEditorLanguage="yaml"
                                    label="Файл конфігурації ( {{ $this->configurationFilePath }} )"
                                    name="proxySettings" id="proxySettings" rows="30" />
                            </div>
                        @endif
                    </div>
                </form>
            @elseif($selectedProxy === 'NONE')
                <div class="flex items-center gap-2">
                    <h2>Конфігурація</h2>
                    @can('update', $server)
                        <x-forms.button wire:click.prevent="changeProxy">Перемкнути проксі</x-forms.button>
                    @endcan
                </div>
                <div class="pt-2 pb-4">Вибрано спеціальний проксі (Немає)</div>
            @else
                <div class="flex items-center gap-2">
                    <h2>Конфігурація</h2>
                    @can('update', $server)
                        <x-forms.button wire:click.prevent="changeProxy">Перемкнути проксі</x-forms.button>
                    @endcan
                </div>
            @endif
        @else
            <div>
                <h2>Конфігурація</h2>
                <div class="subtitle">Оберіть проксі, який ви хочете використовувати на цьому сервері.</div>
                @can('update', $server)
                    <div class="grid gap-4">
                        <x-forms.button class="box" wire:click="selectProxy('NONE')">
                            Спеціальний (Немає)
                        </x-forms.button>
                        <x-forms.button class="box" wire:click="selectProxy('TRAEFIK')">
                            Traefik
                        </x-forms.button>
                        <x-forms.button class="box" wire:click="selectProxy('CADDY')">
                            Caddy
                        </x-forms.button>
                        {{-- <x-forms.button disabled class="box">
                            Nginx
                        </x-forms.button> --}}
                    </div>
                @else
                    <x-callout type="warning" title="Потрібен дозвіл" class="mb-4">
                        У вас немає дозволу на налаштування параметрів проксі для цього сервера.
                    </x-callout>
                @endcan
            </div>
    @endif
</div>