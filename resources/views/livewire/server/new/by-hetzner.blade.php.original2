<div class="w-full">
    @if ($limit_reached)
        <x-limit-reached name="servers" />
    @else
        @if ($current_step === 1)
            <div class="flex flex-col w-full gap-4">
                @if ($available_tokens->count() > 0)
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <x-forms.select label="Виберіть токен Hetzner" id="selected_token_id"
                                wire:change="selectToken($event.target.value)" required>
                                <option value="">Виберіть збережений токен...</option>
                                @foreach ($available_tokens as $token)
                                    <option value="{{ $token->id }}">
                                        {{ $token->name ?? 'Токен Hetzner' }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="flex items-end">
                            <x-forms.button canGate="create" :canResource="App\Models\Server::class" wire:click="nextStep"
                                :disabled="!$selected_token_id">
                                Продовжити
                            </x-forms.button>
                        </div>
                    </div>

                    <div class="text-center text-sm dark:text-neutral-500">АБО</div>
                @endif

                <x-modal-input isFullWidth
                    buttonTitle="{{ $available_tokens->count() > 0 ? '+ Додати новий токен' : 'Додати токен Hetzner' }}"
                    title="Додати токен Hetzner">
                    <livewire:security.cloud-provider-token-form :modal_mode="true" provider="hetzner" />
                </x-modal-input>
            </div>
        @elseif ($current_step === 2)
            @if ($loading_data)
                <div class="flex items-center justify-center py-8">
                    <div class="text-center">
                        <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary mx-auto"></div>
                        <p class="mt-4 text-sm dark:text-neutral-400">Завантаження даних Hetzner...</p>
                    </div>
                </div>
            @else
                <form class="flex flex-col w-full gap-2" wire:submit='submit'>
                    <div>
                        <x-forms.input id="server_name" label="Назва сервера" helper="Зручна назва для вашого сервера." />
                    </div>

                    <div>
                        <x-forms.select label="Розташування" id="selected_location" wire:model.live="selected_location" required>
                            <option value="">Виберіть розташування...</option>
                            @foreach ($locations as $location)
                                <option value="{{ $location['name'] }}">
                                    {{ $location['city'] }} - {{ $location['country'] }}
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>

                    <div>
                        <x-forms.select label="Тип сервера" id="selected_server_type" wire:model.live="selected_server_type"
                            helper="Дізнайтеся більше про <a class='inline-block underline dark:text-white' href='https://www.hetzner.com/cloud/' target='_blank'>типи серверів Hetzner</a>"
                            required :disabled="!$selected_location">
                            <option value="">
                                {{ $selected_location ? 'Виберіть тип сервера...' : 'Спершу виберіть розташування' }}
                            </option>
                            @foreach ($this->availableServerTypes as $serverType)
                                <option value="{{ $serverType['name'] }}">
                                    {{ $serverType['description'] }} -
                                    {{ $serverType['cores'] }} vCPU
                                    @if (isset($serverType['cpu_vendor_info']) && $serverType['cpu_vendor_info'])
                                        ({{ $serverType['cpu_vendor_info'] }})
                                    @endif
                                    , {{ $serverType['memory'] }}GB RAM, 
                                    {{ $serverType['disk'] }}GB
                                    @if (isset($serverType['architecture']))
                                        [{{ $serverType['architecture'] }}]
                                    @endif
                                    @if (isset($serverType['prices']))
                                        -
                                        €{{ number_format($serverType['prices'][0]['price_monthly']['gross'] ?? 0, 2) }}/mo
                                    @endif
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>

                    <div>
                        <x-forms.select label="Образ" id="selected_image" required :disabled="!$selected_server_type">
                            <option value="">
                                {{ $selected_server_type ? 'Виберіть образ...' : 'Спершу виберіть тип сервера' }}
                            </option>
                            @foreach ($this->availableImages as $image)
                                <option value="{{ $image['id'] }}">
                                    {{ $image['description'] ?? $image['name'] }}
                                    @if (isset($image['architecture']))
                                        ({{ $image['architecture'] }})
                                    @endif
                                </option>
                            @endforeach
                        </x-forms.select>
                    </div>

                    <div>
                        @if ($private_keys->count() === 0)
                            <div class="flex flex-col gap-2">
                                <label class="flex gap-1 items-center mb-1 text-sm font-medium">
                                    Приватний ключ
                                    <x-highlighted text="*" />
                                </label>
                                <div
                                    class="p-4 border border-yellow-500 dark:border-yellow-600 rounded bg-yellow-50 dark:bg-yellow-900/10">
                                    <p class="text-sm mb-3 text-neutral-700 dark:text-neutral-300">
                                        Приватні ключі не знайдено. Вам потрібно створити приватний ключ, щоб продовжити.
                                    </p>
                                    <x-modal-input buttonTitle="Створити новий приватний ключ" title="Новий приватний ключ" isHighlightedButton>
                                        <livewire:security.private-key.create :modal_mode="true" from="server" />
                                    </x-modal-input>
                                </div>
                            </div>
                        @else
                            <x-forms.select label="Приватний ключ" id="private_key_id" required>
                                <option value="">Виберіть приватний ключ...</option>
                                @foreach ($private_keys as $key)
                                    <option value="{{ $key->id }}">
                                        {{ $key->name }}
                                    </option>
                                @endforeach
                            </x-forms.select>
                            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                                Цей ключ SSH буде автоматично доданий до вашого облікового запису Hetzner і використаний для доступу до сервера.
                            </p>
                        @endif
                    </div>
                    <div>
                        <x-forms.datalist label="Додаткові SSH ключі (з Hetzner)" id="selectedHetznerSshKeyIds"
                            helper="Виберіть існуючі ключі SSH з вашого облікового запису Hetzner, щоб додати їх до цього сервера. Ключ Coolify SSH буде додано автоматично."
                            :multiple="true" :disabled="count($hetznerSshKeys) === 0" :placeholder="count($hetznerSshKeys) > 0
                                ? 'Шукайте та виберіть ключі SSH...'
                                : 'Ключі SSH не знайдено в обліковому записі Hetzner'">
                            @foreach ($hetznerSshKeys as $sshKey)
                                <option value="{{ $sshKey['id'] }}">
                                    {{ $sshKey['name'] }} - {{ substr($sshKey['fingerprint'], 0, 20) }}...
                                </option>
                            @endforeach
                        </x-forms.datalist>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-sm font-medium">Конфігурація мережі</label>
                        <div class="flex gap-4">
                            <x-forms.checkbox id="enable_ipv4" label="Увімкнути IPv4"
                                helper="Увімкнути публічну IPv4 адресу для цього сервера" />
                            <x-forms.checkbox id="enable_ipv6" label="Увімкнути IPv6"
                                helper="Увімкнути публічну IPv6 адресу для цього сервера" />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex justify-between items-center gap-2">
                            <label class="text-sm font-medium w-32">Скрипт Cloud-Init</label>
                            @if ($saved_cloud_init_scripts->count() > 0)
                                <div class="flex items-center gap-2 flex-1">
                                    <x-forms.select wire:model.live="selected_cloud_init_script_id" label="" helper="">
                                        <option value="">Завантажити збережений скрипт...</option>
                                        @foreach ($saved_cloud_init_scripts as $script)
                                            <option value="{{ $script->id }}">{{ $script->name }}</option>
                                        @endforeach
                                    </x-forms.select>
                                    <x-forms.button type="button" wire:click="clearCloudInitScript">
                                        Очистити
                                    </x-forms.button>
                                </div>
                            @endif
                        </div>
                        <x-forms.textarea id="cloud_init_script" label=""
                            helper="Додайте скрипт cloud-init, який буде виконано під час створення сервера. Дивіться документацію Hetzner для отримання деталей."
                            rows="8" />

                        <div class="flex items-center gap-2">
                            <x-forms.checkbox id="save_cloud_init_script" label="Зберегти цей скрипт для подальшого використання" />
                            <div class="flex-1">
                                <x-forms.input id="cloud_init_script_name" label="" placeholder="Назва скрипта..." />
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-2 justify-between">
                        <x-forms.button type="button" wire:click="previousStep">
                            Назад
                        </x-forms.button>
                        <x-forms.button isHighlighted canGate="create" :canResource="App\Models\Server::class" type="submit"
                            :disabled="!$private_key_id">
                            Купити та створити сервер{{ $this->selectedServerPrice ? ' (' . $this->selectedServerPrice . '/mo)' : '' }}
                        </x-forms.button>
                    </div>
                </form>
            @endif
        @endif
    @endif
</div>