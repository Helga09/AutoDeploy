<div>
    <x-slot:title>
        Термінал | AutoDeploy
        </x-slot>
        <h1>Термінал</h1>
        <div class="flex gap-2 items-end subtitle">
            <div>Виконуйте команди на ваших серверах і контейнерах, не виходячи з браузера.</div>
            <x-helper
                helper="Якщо у вас виникли проблеми з підключенням до сервера, переконайтеся, що порт відкритий.<br>"></x-helper>
        </div>
        <div x-init="$wire.loadContainers()">
            @if ($isLoadingContainers)
                <div class="pt-1">
                    <x-loading text="Завантаження серверів і контейнерів..." />
                </div>
            @else
                @if ($servers->count() > 0)
                    <form class="flex flex-col gap-2 justify-center xl:items-end xl:flex-row"
                        wire:submit="$dispatchSelf('connectToContainer')">
                        <x-forms.select id="selected_uuid" required wire:model.live="selected_uuid">
                            <option value="default">Виберіть сервер або контейнер</option>
                            @foreach ($servers as $server)
                                <option value="{{ $server->uuid }}">{{ $server->name }}</option>
                                @foreach ($containers as $container)
                                    @if ($container['server_uuid'] == $server->uuid)
                                        <option value="{{ $container['uuid'] }}">
                                            {{ $server->name }} -> {{ $container['name'] }}
                                        </option>
                                    @endif
                                @endforeach
                            @endforeach
                        </x-forms.select>
                        <x-forms.button type="submit">Підключитися</x-forms.button>
                    </form>
                @else
                    <div>Не знайдено серверів з доступом до терміналу.</div>
                @endif
            @endif
            <livewire:project.shared.terminal />
        </div>
</div>