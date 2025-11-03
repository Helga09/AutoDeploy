<div>
    <x-slot:title>
        {{ data_get_str($resource, 'name')->limit(10) }} > Заплановані завдання | Coolify
    </x-slot>
    @if ($type === 'application')
        <h1>Заплановане завдання</h1>
        <livewire:project.application.heading :application="$resource" />
    @elseif ($type === 'service')
        <livewire:project.service.heading :service="$resource" :parameters="$parameters" />
    @endif

    <form wire:submit="submit" class="w-full">
        <div class="flex flex-col gap-2 pb-2">
            <div class="flex gap-2 items-end">
                <h2>Заплановане завдання</h2>
                <x-forms.button type="submit">
                    Зберегти
                </x-forms.button>
                @if ($resource->isRunning())
                    <x-forms.button type="button" wire:click="executeNow">
                        Виконати негайно
                    </x-forms.button>
                @endif
                <x-modal-confirmation title="Підтвердити видалення запланованого завдання?" isErrorButton buttonTitle="Видалити"
                    submitAction="delete({{ $task->id }})" :actions="['Вибране заплановане завдання буде видалено назавжди.']" confirmationText="{{ $task->name }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву запланованого завдання нижче"
                    shortConfirmationLabel="Назва запланованого завдання" :confirmWithPassword="false"
                    step2ButtonText="Видалити назавжди" />

            </div>
            <div class="w-48">
                <x-forms.checkbox instantSave id="isEnabled" label="Увімкнено" />
            </div>
            <div class="flex gap-2 w-full">
                <x-forms.input placeholder="Назва" id="name" label="Назва" required />
                <x-forms.input placeholder="php artisan schedule:run" id="command" label="Команда" required />
                <x-forms.input placeholder="0 0 * * * or daily" id="frequency" label="Частота" required />
                @if ($type === 'application')
                    <x-forms.input placeholder="php"
                        helper="Ви можете залишити це поле пустим, якщо ваш ресурс має лише один контейнер." id="container"
                        label="Назва контейнера" />
                @elseif ($type === 'service')
                    <x-forms.input placeholder="php"
                        helper="Ви можете залишити це поле пустим, якщо ваш ресурс має лише одну службу у вашому стеку. В іншому випадку використовуйте назву стеку, без випадкового згенерованого ID. Наприклад, якщо у вашому стеку є служба mysql, використовуйте mysql."
                        id="container" label="Назва служби" />
                @endif
            </div>
    </form>

    <div class="pt-4">
        <h3 class="py-4">Останні виконання <span class="text-xs text-neutral-500">(натисніть, щоб переглянути вивід)</span></h3>
        <livewire:project.shared.scheduled-task.executions :taskId="$task->id" />
    </div>
</div>