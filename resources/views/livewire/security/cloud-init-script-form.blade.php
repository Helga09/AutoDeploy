<form wire:submit='save' class="flex flex-col gap-4 w-full">
    <x-forms.input id="name" label="Назва скрипта" helper="Описова назва для цього cloud-init скрипта." required />

    <x-forms.textarea id="script" label="Вміст скрипта" rows="12"
        helper="Введіть ваш cloud-init скрипт. Підтримує формат YAML cloud-config." required />

    <div class="flex justify-end gap-2">
        @if ($modal_mode)
            <x-forms.button type="button" @click="$dispatch('closeModal')">
                Скасувати
            </x-forms.button>
        @endif
        <x-forms.button type="submit" isHighlighted>
            {{ $scriptId ? 'Оновити скрипт' : 'Створити скрипт' }}
        </x-forms.button>
    </div>
</form>