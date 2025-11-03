<div>
    <x-slot:title>
        Призначення | Coolify
    </x-slot>
    <div class="flex items-center gap-2">
        <h1>Призначення</h1>
        @if ($servers->count() > 0)
            @can('createAnyResource')
                <x-modal-input buttonTitle="+ Додати" title="Нове Призначення">
                    <livewire:destination.new.docker />
                </x-modal-input>
            @endcan
        @endif
    </div>
    <div class="subtitle">Мережеві кінцеві точки для розгортання ваших ресурсів.</div>
    <div class="grid gap-4 lg:grid-cols-2 -mt-1">
        @forelse ($servers as $server)
            @forelse ($server->destinations() as $destination)
                @if ($destination->getMorphClass() === 'App\Models\StandaloneDocker')
                    <a class="box group"
                        href="{{ route('destination.show', ['destination_uuid' => data_get($destination, 'uuid')]) }}">
                        <div class="flex flex-col justify-center mx-6">
                            <div class="box-title">{{ $destination->name }}</div>
                            <div class="box-description">Сервер: {{ $destination->server->name }}</div>
                        </div>
                    </a>
                @endif
                @if ($destination->getMorphClass() === 'App\Models\SwarmDocker')
                    <a class="box group"
                        href="{{ route('destination.show', ['destination_uuid' => data_get($destination, 'uuid')]) }}">
                        <div class="flex flex-col mx-6">
                            <div class="box-title">{{ $destination->name }}</div>
                            <div class="box-description">Сервер: {{ $destination->server->name }}</div>
                        </div>
                    </a>
                @endif
            @empty
                <div>Призначень не знайдено.</div>
            @endforelse
        @empty
            <div>Серверів не знайдено.</div>
        @endforelse
    </div>
</div>