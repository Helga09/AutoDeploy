<div>
    <x-slot:title>
        Змінні проєкту | Coolify
    </x-slot>
    <div class="flex gap-2">
        <h1>Проєкти</h1>
    </div>
    <div class="subtitle">Список ваших проєктів.</div>
    <div class="flex flex-col gap-2">
        @forelse ($projects as $project)
            <a class="box group"
                href="{{ route('shared-variables.project.show', ['project_uuid' => data_get($project, 'uuid')]) }}">
                <div class="flex flex-col justify-center mx-6 ">
                    <div class="box-title">{{ $project->name }}</div>
                    <div class="box-description ">
                        {{ $project->description }}</div>
                </div>
            </a>
        @empty
            <div>
                <div>Проєктів не знайдено.</div>
            </div>
        @endforelse
    </div>
</div>