<div>
    <x-slot:title>
        {{ data_get_str($project, 'name')->limit(10) }} > Редагувати | Coolify
        </x-slot>
        <form wire:submit='submit' class="flex flex-col pb-10">
            <div class="flex gap-2">
                <h1>{{ data_get_str($project, 'name')->limit(15) }}</h1>
                <div class="flex items-end gap-2">
                    <x-forms.button type="submit">Зберегти</x-forms.button>
                    <livewire:project.delete-project :disabled="!$project->isEmpty()" :project_id="$project->id" />
                </div>
            </div>
            <div class="pt-2 pb-10">Редагуйте деталі проєкту тут.</div>
            <div class="flex gap-2">
                <x-forms.input label="Назва" id="name" />
                <x-forms.input label="Опис" id="description" />
            </div>
        </form>
</div>