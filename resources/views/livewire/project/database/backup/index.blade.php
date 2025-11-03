<div>
    <x-slot:title>
        {{ data_get_str($database, 'name')->limit(10) }} > Резервні копії | Coolify
    </x-slot>
    <h1>Резервні копії</h1>
    <livewire:project.shared.configuration-checker :resource="$database" />
    <livewire:project.database.heading :database="$database" />
    <div>
        <div class="flex gap-2">
            <h2 class="pb-4">Заплановані резервні копії</h2>
            @can('update', $database)
                <x-modal-input buttonTitle="+ Додати" title="Нова запланована резервна копія">
                    <livewire:project.database.create-scheduled-backup :database="$database" />
                </x-modal-input>
            @endcan
        </div>
        <livewire:project.database.scheduled-backups :database="$database" />
    </div>
</div>