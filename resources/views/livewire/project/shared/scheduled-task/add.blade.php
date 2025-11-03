<form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='submit'>
    <x-forms.input placeholder="Запустити cron" id="name" label="Назва" />
    <x-forms.input placeholder="php artisan schedule:run" id="command" label="Команда" />
    <x-forms.input placeholder="0 0 * * * or daily"
        helper="Ви можете використовувати щохвилини, щогодини, щодня, щотижня, щомісяця, щороку або cron-вираз." id="frequency"
        label="Частота" />
    @if ($type === 'application')
        @if ($containerNames->count() > 1)
            <x-forms.select id="container" label="Ім'я контейнера">
                @foreach ($containerNames as $containerName)
                    <option value="{{ $containerName }}">{{ $containerName }}</option>
                @endforeach
            </x-forms.select>
        @else
            <x-forms.input placeholder="php" id="container"
                helper="Ви можете залишити це поле пустим, якщо ваш ресурс має лише один контейнер." label="Ім'я контейнера" />
        @endif
    @elseif ($type === 'service')
        <x-forms.select id="container" label="Ім'я контейнера">
            @foreach ($containerNames as $containerName)
                <option value="{{ $containerName }}">{{ $containerName }}</option>
            @endforeach
        </x-forms.select>
    @endif

    <x-forms.button @click="modalOpen=false" type="submit">
        Зберегти
    </x-forms.button>
</form>