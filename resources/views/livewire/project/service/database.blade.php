<div>
    <form wire:submit='submit'>
        <div class="flex items-center gap-2 pb-4">
            @if ($database->human_name)
                <h2>{{ Str::headline($database->human_name) }}</h2>
            @else
                <h2>{{ Str::headline($database->name) }}</h2>
            @endif
            <x-forms.button canGate="update" :canResource="$database" type="submit">Зберегти</x-forms.button>
            @can('update', $database)
                <x-modal-confirmation wire:click="convertToApplication" title="Конвертувати в Застосунок"
                    buttonTitle="Конвертувати в Застосунок" submitAction="convertToApplication" :actions="['Вибраний ресурс буде конвертовано в застосунок.']"
                    confirmationText="{{ Str::headline($database->name) }}"
                    confirmationLabel="Будь ласка, підтвердіть виконання дій, ввівши ім'я сервісної бази даних нижче"
                    shortConfirmationLabel="Ім'я сервісної бази даних" />
            @endcan
            @can('delete', $database)
                <x-modal-confirmation title="Підтвердити видалення сервісної бази даних?" buttonTitle="Видалити" isErrorButton
                    submitAction="delete" :actions="['Вибраний контейнер сервісної бази даних буде зупинено та безповоротно видалено.']" confirmationText="{{ Str::headline($database->name) }}"
                    confirmationLabel="Будь ласка, підтвердіть виконання дій, ввівши ім'я сервісної бази даних нижче"
                    shortConfirmationLabel="Ім'я сервісної бази даних" />
            @endcan
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex gap-2">
                <x-forms.input canGate="update" :canResource="$database" label="Ім'я" id="humanName" placeholder="Ім'я"></x-forms.input>
                <x-forms.input canGate="update" :canResource="$database" label="Опис" id="description"></x-forms.input>
                <x-forms.input canGate="update" :canResource="$database" required
                    helper="Ви можете змінити образ, який бажаєте розгорнути.<br><br><span class='dark:text-warning'>УВАГА. Ви можете пошкодити ваші дані. Робіть це лише якщо ви розумієте, що робите.</span>"
                    label="Образ" id="image"></x-forms.input>
            </div>
            <div class="flex items-end gap-2">
                <x-forms.input canGate="update" :canResource="$database" placeholder="5432" disabled="{{ $database->is_public }}" id="publicPort"
                    label="Публічний порт" />
                <x-forms.checkbox canGate="update" :canResource="$database" instantSave id="isPublic" label="Зробити його публічно доступним" />
            </div>
            @if ($db_url_public)
                <x-forms.input label="IP:ПОРТ бази даних (публічний)"
                    helper="Ваші облікові дані доступні у змінних середовища." type="password" readonly
                    wire:model="db_url_public" />
            @endif
        </div>
        <h3 class="pt-2">Розширені налаштування</h3>
        <div class="w-96">
            <x-forms.checkbox canGate="update" :canResource="$database" instantSave="instantSaveExclude" label="Виключити зі статусу сервісу"
                helper="Якщо вам не потрібно моніторити цей ресурс, увімкніть. Корисно, якщо цей сервіс є необов'язковим."
                id="excludeFromStatus"></x-forms.checkbox>
            <x-forms.checkbox canGate="update" :canResource="$database" helper="Відвести логи до налаштованої кінцевої точки відведення логів у налаштуваннях вашого сервера."
                instantSave="instantSaveLogDrain" id="isLogDrainEnabled" label="Відведення логів" />
        </div>
    </form>
</div>