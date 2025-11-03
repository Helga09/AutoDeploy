<form wire:submit="submit">
    <div class="flex items-end gap-2">
        <x-forms.input id="filename" label="Ім'я файлу" />
        <x-forms.button type="submit">Зберегти</x-forms.button>
        <x-modal-confirmation title="Підтвердити видалення ініціалізаційного скрипта?" buttonTitle="Видалити" isErrorButton
            submitAction="delete" :actions="[
                'Ініціалізаційний скрипт цієї бази даних буде безповоротно видалено з бази даних та сервера.',
                'Якщо ви активно використовуєте цей ініціалізаційний скрипт, це може спричинити помилки під час повторного розгортання.',
            ]" confirmationText="{{ $filename }}"
            confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву ініціалізаційного скрипта нижче"
            shortConfirmationLabel="Ім'я ініціалізаційного скрипта" :confirmWithPassword=false step2ButtonText="Видалити безповоротно" />
    </div>
    <x-forms.textarea id="content" label="Вміст" />
</form>