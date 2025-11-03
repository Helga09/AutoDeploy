<div>
    <x-slot:title>
        Профіль | AutoDeploy
    </x-slot>
    <h1>Профіль</h1>
    <div class="subtitle -mt-2">Налаштування вашого профілю користувача.</div>
    <form wire:submit='submit' class="flex flex-col">
        <div class="flex items-center gap-2">
            <h2>Загальні</h2>
            <x-forms.button type="submit" label="Зберегти">Зберегти</x-forms.button>
        </div>
        <div class="flex flex-col gap-2 lg:flex-row items-end">
            <x-forms.input id="name" label="Ім'я" required />
            <x-forms.input id="email" label="Електронна пошта" readonly />
            @if (!$show_email_change && !$show_verification)
                <x-forms.button wire:click="showEmailChangeForm" type="button">Змінити електронну пошту</x-forms.button>
            @else
                <x-forms.button wire:click="showEmailChangeForm" type="button" disabled>Змінити електронну пошту</x-forms.button>
            @endif
        </div>
    </form>

    <div class="flex flex-col pt-4">
        @if ($show_email_change)
            <form wire:submit='requestEmailChange'>
                <div class="flex gap-2 items-end">
                    <x-forms.input id="new_email" label="Нова електронна адреса" required type="email" />
                    <x-forms.button type="submit">Надіслати код підтвердження</x-forms.button>
                    <x-forms.button wire:click="$set('show_email_change', false)" type="button"
                        isError>Скасувати</x-forms.button>
                </div>
                <div class="text-xs font-bold dark:text-warning pt-2">Код підтвердження буде надіслано на вашу
                    нову електронну
                    адресу.</div>
            </form>
        @endif

        @if ($show_verification)
            <form wire:submit='verifyEmailChange'>
                <div class="flex gap-2 items-end">
                    <x-forms.input id="email_verification_code" label="Код підтвердження (6 цифр)" required
                        maxlength="6" />
                    <x-forms.button type="submit">Підтвердити та оновити електронну пошту</x-forms.button>
                    <x-forms.button wire:click="resendVerificationCode" type="button" isWarning>Надіслати код повторно
                        </x-forms.button>
                    <x-forms.button wire:click="cancelEmailChange" type="button" isError>Скасувати</x-forms.button>
                </div>
                <div class="text-xs font-bold dark:text-warning pt-2">
                    Код підтвердження надіслано на {{ $new_email ?? auth()->user()->pending_email }}.
                    Код дійсний протягом {{ config('constants.email_change.verification_code_expiry_minutes', 10) }}
                    хвилин.
                </div>


            </form>
        @endif
    </div>
    <form wire:submit='resetPassword' class="flex flex-col pt-4">
        <div class="flex items-center gap-2 pb-2">
            <h2>Змінити пароль</h2>
            <x-forms.button type="submit" label="Зберегти">Зберегти</x-forms.button>
        </div>
        <div class="text-xs font-bold dark:text-warning pb-2">Скидання пароля призведе до виходу з усіх сесій.</div>
        <div class="flex flex-col gap-2">
            <x-forms.input id="current_password" label="Поточний пароль" required type="password" />
            <div class="flex gap-2">
                <x-forms.input id="new_password" label="Новий пароль" required type="password" />
                <x-forms.input id="new_password_confirmation" label="Новий пароль ще раз" required type="password" />
            </div>
        </div>
    </form>
</div>