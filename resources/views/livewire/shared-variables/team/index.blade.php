<div>
    <x-slot:title>
        Змінні команди | AutoDeploy
    </x-slot>
    <div class="flex gap-2 items-center">
        <h1>Спільні змінні команди</h1>
        @can('create', App\Models\SharedEnvironmentVariable::class)
            <x-modal-input buttonTitle="+ Додати" title="Нова спільна змінна">
                <livewire:project.shared.environment-variable.add :shared="true" />
            </x-modal-input>
        @endcan
    </div>
    <div class="flex items-center gap-1 subtitle">Ви можете використовувати ці змінні будь-де за допомогою <span
            class="dark:text-warning text-coollabs">@{{ team.VARIABLENAME }}</span> <x-helper
            helper="Більше інформації <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/environment-variables#shared-variables' target='_blank'>тут</a>."></x-helper>
    </div>

    <div class="flex flex-col gap-2">
        @forelse ($team->environment_variables->sort()->sortBy('key') as $env)
            <livewire:project.shared.environment-variable.show wire:key="environment-{{ $env->id }}"
                :env="$env" type="team" />
        @empty
            <div>Змінні середовища не знайдено.</div>
        @endforelse
    </div>
</div>