<div class="flex items-center gap-2 pb-4">
    <h2>Журнал розгортання</h2>
    @if ($is_debug_enabled)
        <x-forms.button wire:click.prevent="show_debug">Приховати журнали налагодження</x-forms.button>
    @else
        <x-forms.button wire:click.prevent="show_debug">Показати журнали налагодження</x-forms.button>
    @endif
    @if (isDev())
        <x-forms.button x-on:click="$wire.copyLogsToClipboard().then(text => navigator.clipboard.writeText(text))">Копіювати журнали</x-forms.button>
    @endif
    @if (data_get($application_deployment_queue, 'status') === 'queued')
        <x-forms.button wire:click.prevent="force_start">Примусовий запуск</x-forms.button>
    @endif
    @if (data_get($application_deployment_queue, 'status') === 'in_progress' ||
            data_get($application_deployment_queue, 'status') === 'queued')
        <x-forms.button isError wire:click.prevent="cancel">Скасувати</x-forms.button>
    @endif
</div>