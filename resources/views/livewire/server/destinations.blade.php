<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Призначення | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="destinations" />
        <div class="w-full">
            @if ($server->isFunctional())
                <div class="flex items-end gap-2">
                    <h2>Призначення</h2>
                    @can('update', $server)
                        <x-modal-input buttonTitle="+ Додати" title="Нове призначення">
                            <livewire:destination.new.docker :server_id="$server->id" />
                        </x-modal-input>
                    @endcan
                    <x-forms.button canGate="update" :canResource="$server" isHighlighted wire:click='scan'>Сканувати призначення</x-forms.button>
                </div>
                <div>Призначення використовуються для відокремлення ресурсів за мережею.</div>
                <h4 class="pt-4 pb-2">Доступні призначення</h4>
                <div class="flex gap-2">
                    @foreach ($server->standaloneDockers as $docker)
                        <a href="{{ route('destination.show', ['destination_uuid' => data_get($docker, 'uuid')]) }}">
                            <x-forms.button>{{ data_get($docker, 'network') }} </x-forms.button>
                        </a>
                    @endforeach
                    @foreach ($server->swarmDockers as $docker)
                        <a href="{{ route('destination.show', ['destination_uuid' => data_get($docker, 'uuid')]) }}">
                            <x-forms.button>{{ data_get($docker, 'network') }} </x-forms.button>
                        </a>
                    @endforeach
                </div>
                @if ($networks->count() > 0)
                    <div class="pt-2">
                        <h3 class="pb-4">Знайдені призначення</h3>
                        <div class="flex flex-wrap gap-2 ">
                            @foreach ($networks as $network)
                                <div class="min-w-fit">
                                    <x-forms.button canGate="update" :canResource="$server" wire:click="add('{{ data_get($network, 'Name') }}')">Додати
                                        {{ data_get($network, 'Name') }}</x-forms.button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <div>Сервер не перевірено. Спочатку перевірте.</div>
            @endif
        </div>
    </div>
</div>