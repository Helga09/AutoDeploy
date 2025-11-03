<div>
    <x-slot:title>
        Змінна проєкту | AutoDeploy
    </x-slot>
    <div class="flex gap-2 items-center">
        <h1>Спільні змінні для {{ data_get($project, 'name') }}</h1>
        @can('update', $project)
            <x-modal-input buttonTitle="+ Додати" title="Нова спільна змінна">
                <livewire:project.shared.environment-variable.add :shared="true" />
            </x-modal-input>
        @endcan
    </div>
    <div class="flex flex-wrap gap-1 subtitle">
        <div>Ви можете використовувати ці змінні будь-де за допомогою</div>
        <div class="dark:text-warning text-coollabs">@{{ project.VARIABLENAME }} </div>
        <x-helper
            helper="Більше інформації <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/environment-variables#shared-variables' target='_blank'>тут</a>."></x-helper>
    </div>
    <div class="flex flex-col gap-2">
        @forelse ($project->environment_variables->sort()->sortBy('key') as $env)
            <livewire:project.shared.environment-variable.show wire:key="environment-{{ $env->id }}"
                :env="$env" type="project" />
        @empty
            <div>Змінні оточення не знайдено.</div>
        @endforelse
    </div>
</div>