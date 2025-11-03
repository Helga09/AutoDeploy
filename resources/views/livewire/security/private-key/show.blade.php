<div x-init="$wire.loadPublicKey()">
    <x-slot:title>
        Приватний ключ | Coolify
    </x-slot>
    <x-security.navbar />
    <div x-data="{ showPrivateKey: false }">
        <form class="flex flex-col" wire:submit='changePrivateKey'>
            <div class="flex items-start gap-2">
                <h2 class="pb-4">Приватний ключ</h2>
                <x-forms.button canGate="update" :canResource="$private_key" type="submit">
                    Зберегти
                </x-forms.button>
                @if (data_get($private_key, 'id') > 0)
                    @can('delete', $private_key)
                        <x-modal-confirmation title="Підтвердити видалення приватного ключа?" isErrorButton buttonTitle="Видалити"
                            submitAction="delete({{ $private_key->id }})" :actions="[
                                'Цей приватний ключ буде видалено назавжди.',
                                'Усі сервери, підключені до цього приватного ключа, перестануть працювати.',
                                'Будь-яка Git-програма, що використовує цей приватний ключ, перестане працювати.',
                            ]"
                            confirmationText="{{ $private_key->name }}"
                            confirmationLabel="Будь ласка, підтвердіть виконання дій, ввівши назву приватного ключа нижче"
                            shortConfirmationLabel="Назва приватного ключа" :confirmWithPassword="false"
                            step2ButtonText="Видалити приватний ключ" />
                    @endcan
                @endif
            </div>
            <div class="flex flex-col gap-2">
                <div class="flex gap-2">
                    <x-forms.input canGate="update" :canResource="$private_key" id="name" label="Назва" required />
                    <x-forms.input canGate="update" :canResource="$private_key" id="description" label="Опис" />
                </div>
                <div>
                    <div class="flex items-end gap-2 py-2 ">
                        <div class="pl-1">Публічний ключ</div>
                    </div>
                    <x-forms.input canGate="update" :canResource="$private_key" readonly id="public_key" />
                    <div class="flex items-end gap-2 py-2 ">
                        <div class="pl-1">Приватний ключ <span class='text-helper'>*</span></div>
                        <div class="text-xs underline cursor-pointer dark:text-white" x-cloak x-show="!showPrivateKey"
                            x-on:click="showPrivateKey = true">
                            Редагувати
                        </div>
                        <div class="text-xs underline cursor-pointer dark:text-white" x-cloak x-show="showPrivateKey"
                            x-on:click="showPrivateKey = false">
                            Приховати
                        </div>
                    </div>
                    @if ($isGitRelated)
                        <div class="w-48">
                            <x-forms.checkbox id="isGitRelated" disabled label="Використовується Git-додатком?" />
                        </div>
                    @endif
                    <div x-cloak x-show="!showPrivateKey">
                        <x-forms.input canGate="update" :canResource="$private_key" allowToPeak="false" type="password" rows="10" id="privateKeyValue"
                            required disabled />
                    </div>
                    <div x-cloak x-show="showPrivateKey">
                        <x-forms.textarea canGate="update" :canResource="$private_key" rows="10" id="privateKeyValue" required />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>