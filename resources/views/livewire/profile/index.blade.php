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
    <h2 class="py-4">Двофакторна автентифікація</h2>
    @if (session('status') == 'two-factor-authentication-enabled')
        <div class="mb-4 font-medium">
            Будь ласка, завершіть налаштування двофакторної автентифікації нижче. Зчитайте QR-код або введіть секретний ключ
            вручну.
        </div>
        <div class="flex flex-col gap-4">
            <form action="/user/confirmed-two-factor-authentication" method="POST" class="flex items-end gap-2">
                @csrf
                <x-forms.input type="text" inputmode="numeric" pattern="[0-9]*" id="code"
                    label="Одноразовий (OTP) код" required />
                <x-forms.button type="submit">Підтвердити 2FA</x-forms.button>
            </form>
            <div class="flex flex-col items-start">
                <div
                    class="flex items-center justify-center w-80 h-80 bg-white p-4 border-4 border-gray-300 rounded-lg shadow-lg">
                    {!! request()->user()->twoFactorQrCodeSvg() !!}
                </div>
                <div x-data="{
                    showCode: false,
                }" class="py-4 w-full">
                    <div class="flex flex-col gap-2 pb-2" x-show="showCode">
                        <x-forms.copy-button text="{{ decrypt(request()->user()->two_factor_secret) }}" />
                        <x-forms.copy-button text="{{ request()->user()->twoFactorQrCodeUrl() }}" />
                    </div>
                    <x-forms.button x-on:click="showCode = !showCode" class="mt-2">
                        <span x-text="showCode ? 'Приховати секретний ключ та URL OTP' : 'Показати секретний ключ та URL OTP'"></span>
                    </x-forms.button>
                </div>
            </div>
        </div>
    @elseif(session('status') == 'two-factor-authentication-confirmed')
        <div class="mb-4 ">
            Двофакторну автентифікацію успішно підтверджено та увімкнено.
        </div>
        <div>
            <div class="pb-6 ">Ось коди відновлення для вашого облікового запису. Будь ласка, зберігайте їх у безпечному
                місці.
            </div>
            <div class="dark:text-white">
                @foreach (request()->user()->recoveryCodes() as $code)
                    <div>{{ $code }}</div>
                @endforeach
            </div>
        </div>
    @else
        @if (request()->user()->two_factor_confirmed_at)
            <div class="pb-4 "> Двофакторна автентифікація <span class="text-helper">увімкнена</span>.</div>
            <div class="flex gap-2">
                <form action="/user/two-factor-authentication" method="POST">
                    @csrf
                    @method ('DELETE')
                    <x-forms.button type="submit">Вимкнути</x-forms.button>
                </form>
                <form action="/user/two-factor-recovery-codes" method="POST">
                    @csrf
                    <x-forms.button type="submit">Відновити коди відновлення</x-forms.button>
                </form>
            </div>
            @if (session('status') == 'recovery-codes-generated')
                <div>
                    <div class="py-6 ">Ось коди відновлення для вашого облікового запису. Будь ласка, зберігайте їх у
                        безпечному
                        місці.
                    </div>
                    <div class="dark:text-white">
                        @foreach (request()->user()->recoveryCodes() as $code)
                            <div>{{ $code }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            <form action="/user/two-factor-authentication" method="POST">
                @csrf
                <x-forms.button type="submit">Налаштувати</x-forms.button>
            </form>
        @endif
    @endif
    @if (session()->has('errors'))
        <div class="text-error">
            Щось пішло не так. Будь ласка, спробуйте ще раз.
        </div>
    @endif
</div>