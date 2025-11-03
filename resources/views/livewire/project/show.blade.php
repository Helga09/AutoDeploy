<div>
    <x-slot:title>
        {{ data_get_str($project, 'name')->limit(10) }} > Середовища | Coolify
    </x-slot>
    <div class="flex items-center gap-2">
        <h1>Середовища</h1>
        @can('update', $project)
            <x-modal-input buttonTitle="+ Додати" title="Нове середовище">
                <form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='submit'>
                    <x-forms.input placeholder="виробництво" id="name" label="Назва" required />
                    <x-forms.button type="submit">
                        Зберегти
                    </x-forms.button>
                </form>
            </x-modal-input>
        @endcan
        @can('delete', $project)
            <livewire:project.delete-project :disabled="!$project->isEmpty()" :project_id="$project->id" />
        @endcan
    </div>
    <div class="text-xs truncate subtitle lg:text-sm">{{ $project->name }}.</div>
    <div class="grid gap-2 lg:grid-cols-2">
        @forelse ($project->environments->sortBy('created_at') as $environment)
            <div class="gap-2 box group">
                <div class="flex flex-1 mx-6">
                    <a class="flex flex-col justify-center flex-1"
                        href="{{ route('project.resource.index', ['project_uuid' => $project->uuid, 'environment_uuid' => $environment->uuid]) }}">
                        <div class="font-bold dark:text-white"> {{ $environment->name }}</div>
                        <div class="description">
                            {{ $environment->description }}</div>
                    </a>
                    @can('update', $project)
                        <div class="flex items-center justify-center gap-2 text-xs">
                            <a class="font-bold hover:underline"
                                href="{{ route('project.environment.edit', ['project_uuid' => $project->uuid, 'environment_uuid' => $environment->uuid]) }}">
                                Налаштування
                            </a>
                        </div>
                    @endcan
                </div>
            </div>
        @empty
            <p>Середовищ не знайдено.</p>
        @endforelse
    </div>
</div>