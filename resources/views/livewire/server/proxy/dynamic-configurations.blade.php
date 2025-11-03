<div>
    <x-slot:title>
        Динамічна Конфігурація Проксі | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar-proxy :server="$server" :parameters="$parameters" />
        @if ($server->isFunctional())
            <div class="w-full">
                <div class="flex gap-2">
                    <div>
                        <div class="flex gap-2">
                            <h2>Динамічні Конфігурації</h2>
                            <x-forms.button wire:click="loadDynamicConfigurations">Перезавантажити</x-forms.button>
                            @can('update', $server)
                                <x-modal-input buttonTitle="+ Додати" title="Нова Динамічна Конфігурація">
                                    <livewire:server.proxy.new-dynamic-configuration :server_id="$server->id" />
                                </x-modal-input>
                            @endcan
                        </div>
                        <div class='pb-4'>Тут ви можете додати динамічні конфігурації проксі.</div>
                    </div>
                </div>
                <div wire:loading wire:target="initLoadDynamicConfigurations">
                    <x-loading text="Завантаження динамічних конфігурацій..." />
                </div>
                <div x-init="$wire.initLoadDynamicConfigurations" class="flex flex-col gap-4">
                    @if ($contents?->isNotEmpty())
                        @foreach ($contents as $fileName => $value)
                            <div class="flex flex-col gap-2 py-2">
                                @if (str_replace('|', '.', $fileName) === 'AutoDeploy.yaml' ||
                                        str_replace('|', '.', $fileName) === 'Caddyfile' ||
                                        str_replace('|', '.', $fileName) === 'AutoDeploy.caddy' ||
                                        str_replace('|', '.', $fileName) === 'default_redirect_503.yaml' ||
                                        str_replace('|', '.', $fileName) === 'default_redirect_503.caddy')
                                    <div>
                                        <h3 class="dark:text-white">Файл: {{ str_replace('|', '.', $fileName) }}</h3>
                                    </div>
                                    <x-forms.textarea disabled name="proxy_settings"
                                        wire:model="contents.{{ $fileName }}" rows="5" />
                                @else
                                    <livewire:server.proxy.dynamic-configuration-navbar :server_id="$server->id"
                                        :server="$server" :fileName="$fileName" :value="$value ?? ''" :newFile="false"
                                        wire:key="{{ $fileName }}-{{ $loop->index }}" />
                                    <x-forms.textarea disabled wire:model="contents.{{ $fileName }}"
                                        rows="10" />
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div wire:loading.remove> Динамічні конфігурації не знайдено.</div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>