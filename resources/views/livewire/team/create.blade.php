<form class="flex flex-col w-full gap-2" wire:submit='submit'>
    <x-forms.input id="name" label="Ім'я" required />
    <x-forms.input id="description" label="Опис" />
    <x-forms.button type="submit">
        Продовжити
    </x-forms.button>
</form>