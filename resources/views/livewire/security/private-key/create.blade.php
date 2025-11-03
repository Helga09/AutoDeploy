<div>
    <div class="pb-2 subtitle">
        <div>Приватні ключі використовуються для підключення до ваших серверів без паролів.</div>
        <div class="font-bold">Вам не слід використовувати ключі, захищені кодовою фразою.</div>
    </div>
    <div class="flex gap-2 mb-4 w-full">
        <x-forms.button wire:click="generateNewEDKey" isHighlighted class="w-full">Згенерувати новий SSH
            ключ ED25519</x-forms.button>
        <x-forms.button wire:click="generateNewRSAKey">Згенерувати новий SSH ключ RSA</x-forms.button>
    </div>
    <form class="flex flex-col gap-2" wire:submit='createPrivateKey'>
        <div class="flex gap-2">
            <x-forms.input id="name" label="Назва" required />
            <x-forms.input id="description" label="Опис" />
        </div>
        <x-forms.textarea realtimeValidation id="value" rows="10"
            placeholder="-----BEGIN OPENSSH PRIVATE KEY-----" label="Приватний ключ" required />
        <x-forms.input id="publicKey" readonly label="Публічний ключ" />
        <span class="pt-2 pb-4 font-bold dark:text-warning">ПОТРІБНА ДІЯ: Скопіюйте 'Публічний ключ' до файлу
            ~/.ssh/authorized_keys на вашому сервері</span>
        <x-forms.button type="submit">
            Продовжити
        </x-forms.button>
    </form>
</div>