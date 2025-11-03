<div>
    <x-slot:title>
        Сервери | Coolify
    </x-slot>
    <div class="flex items-center gap-2">
        <h1>Сервери</h1>
        @can('createAnyResource')
            <x-modal-input buttonTitle="+ Додати" title="Новий сервер" :closeOutside="false">
                <livewire:server.create />
            </x-modal-input>
        @endcan
    </div>
    <div class="subtitle">Усі ваші сервери тут.</div>
    <div class="grid gap-4 lg:grid-cols-2 -mt-1">
        @forelse ($servers as $server)
            <a href="{{ route('server.show', ['server_uuid' => data_get($server, 'uuid')]) }}"
                @class([
                    'gap-2 border cursor-pointer box group',
                    'border-red-500' =>
                        !$server->settings->is_reachable || $server->settings->force_disabled,
                ])>
                <div class="flex flex-col justify-center mx-6">
                    <div class="font-bold dark:text-white">
                        {{ $server->name }}
                    </div>
                    <div class="description">
                        {{ $server->description }}</div>
                    <div class="flex gap-1 text-xs text-error">
                        @if (!$server->settings->is_reachable)
                            <span>Недоступний</span>
                        @endif
                        @if (!$server->settings->is_reachable && !$server->settings->is_usable)
                            &
                        @endif
                        @if (!$server->settings->is_usable)
                            <span>Не може бути використаний Coolify</span>
                        @endif
                        @if ($server->settings->force_disabled)
                            <span>Вимкнено системою</span>
                        @endif
                    </div>
                </div>
                <div class="flex-1"></div>
            </a>
        @empty
            <div>
                <div>Серверів не знайдено. Без сервера ви мало що зможете зробити.</div>
            </div>
        @endforelse
        @isset($error)
            <div class="text-center text-error">
                <span>{{ $error }}</span>
            </div>
        @endisset
    </div>
</div>