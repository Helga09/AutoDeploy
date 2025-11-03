<div>
    <x-slot:title>
        {{ data_get_str($resource, 'name')->limit(10) }} > Журнали | AutoDeploy
    </x-slot>
    <livewire:project.shared.configuration-checker :resource="$resource" />
    @if ($type === 'application')
        <h1>Журнали</h1>
        <livewire:project.application.heading :application="$resource" />
        <div>
            <h2>Журнали</h2>
            @if (str($status)->contains('exited'))
                <div class="pt-4">Ресурс не запущено.</div>
            @else
                <div class="pt-2" wire:loading wire:target="loadAllContainers">
                    Завантаження контейнерів...
                </div>
                <div x-init="$wire.loadAllContainers()" wire:loading.remove wire:target="loadAllContainers">
                    @forelse ($servers as $server)
                        <div class="py-2">
                            <h2>Сервер: {{ $server->name }}</h2>
                            @if ($server->isFunctional())
                                @if (isset($serverContainers[$server->id]) && count($serverContainers[$server->id]) > 0)
                                    @foreach ($serverContainers[$server->id] as $container)
                                        <livewire:project.shared.get-logs
                                            wire:key="{{ data_get($container, 'ID', uniqid()) }}" :server="$server"
                                            :resource="$resource" :container="data_get($container, 'Names')" />
                                    @endforeach
                                @else
                                    <div class="pt-2">На сервері не запущено контейнерів: {{ $server->name }}</div>
                                @endif
                            @else
                                <div class="pt-2">Сервер {{ $server->name }} не функціонує.</div>
                            @endif
                        </div>
                    @empty
                        <div>Не знайдено функціонального сервера для застосунку.</div>
                    @endforelse
                </div>
            @endif
        </div>
    @elseif ($type === 'database')
        <h1>Журнали</h1>
        <livewire:project.database.heading :database="$resource" />
        <div>
            <h2>Журнали</h2>
            @if (str($status)->contains('exited'))
                <div class="pt-4">Ресурс не запущено.</div>
            @else
                <div class="pt-2" wire:loading wire:target="loadAllContainers">
                    Завантаження контейнерів...
                </div>
                <div x-init="$wire.loadAllContainers()" wire:loading.remove wire:target="loadAllContainers">
                    @forelse ($containers as $container)
                        @if (data_get($servers, '0'))
                            <livewire:project.shared.get-logs wire:key='{{ $container }}' :server="data_get($servers, '0')"
                                :resource="$resource" :container="$container" />
                        @else
                            <div>Не знайдено функціонального сервера для бази даних.</div>
                        @endif
                    @empty
                        <div class="pt-2">Контейнери не запущені.</div>
                    @endforelse
                </div>
            @endif
        </div>
    @elseif ($type === 'service')
        <livewire:project.service.heading :service="$resource" :parameters="$parameters" :query="$query" title="Журнали" />
        <div>
            <h2>Журнали</h2>
            @if (str($status)->contains('exited'))
                <div class="pt-4">Ресурс не запущено.</div>
            @else
                <div class="pt-2" wire:loading wire:target="loadAllContainers">
                    Завантаження контейнерів...
                </div>
                <div x-init="$wire.loadAllContainers()" wire:loading.remove wire:target="loadAllContainers">
                    @forelse ($containers as $container)
                        @if (data_get($servers, '0'))
                            <livewire:project.shared.get-logs wire:key='{{ $container }}' :server="data_get($servers, '0')"
                                :resource="$resource" :container="$container" />
                        @else
                            <div>Не знайдено функціонального сервера для сервісу.</div>
                        @endif
                    @empty
                        <div class="pt-2">Контейнери не запущені.</div>
                    @endforelse
                </div>
            @endif
        </div>
    @endif
</div>