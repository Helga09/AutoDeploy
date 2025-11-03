<div>
    <form class="flex flex-col gap-2 pb-6" wire:submit='submit'>
        <div class="flex items-start gap-2">
            <div class="">
                <h1>Деталі сховища</h1>
                <div class="subtitle">{{ $storage->name }}</div>
                <div class="flex items-center gap-2 pb-4">
                    <div>Поточний статус:</div>
                    @if ($isUsable)
                        <span
                            class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded dark:text-green-100 dark:bg-green-800">
                            Придатне
                        </span>
                    @else
                        <span
                            class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded dark:text-red-100 dark:bg-red-800">
                            Непридатне
                        </span>
                    @endif
                </div>
            </div>
            <x-forms.button canGate="update" :canResource="$storage" type="submit">Зберегти</x-forms.button>

            @can('delete', $storage)
                <x-modal-confirmation title="Підтвердити видалення сховища?" isErrorButton buttonTitle="Видалити"
                    submitAction="delete({{ $storage->id }})" :actions="[
                        'Вибране сховище буде остаточно видалено з AutoDeploy.',
                        'Якщо сховище використовується завданнями резервного копіювання, ці завдання зберігатимуть резервні копії лише локально на сервері.',
                    ]" confirmationText="{{ $storage->name }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву сховища нижче"
                    shortConfirmationLabel="Назва сховища" :confirmWithPassword="false" step2ButtonText="Видалити назавжди" />
            @endcan
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$storage" label="Назва" id="name" />
            <x-forms.input canGate="update" :canResource="$storage" label="Опис" id="description" />
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$storage" required label="Кінцева точка" id="endpoint" />
            <x-forms.input canGate="update" :canResource="$storage" required label="Бакет" id="bucket" />
            <x-forms.input canGate="update" :canResource="$storage" required label="Регіон" id="region" />
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$storage" required type="password" label="Ключ доступу"
                id="key" />
            <x-forms.input canGate="update" :canResource="$storage" required type="password" label="Секретний ключ"
                id="secret" />
        </div>
        @can('validateConnection', $storage)
            <x-forms.button class="mt-4" isHighlighted wire:click="testConnection">
                Перевірити з'єднання
            </x-forms.button>
        @endcan
    </form>
</div>