<form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='submit'>
    <x-forms.input placeholder="Ваш крутий проєкт" id="name" label="Назва" required />
    <x-forms.input placeholder="Це мій крутий проєкт, про який усі знають" id="description" label="Опис" />
    <div class="subtitle">Новий проєкт матиме типове <span class="dark:text-warning font-bold">виробниче</span>
        середовище.</div>
    <x-forms.button type="submit">
        Продовжити
    </x-forms.button>
</form>