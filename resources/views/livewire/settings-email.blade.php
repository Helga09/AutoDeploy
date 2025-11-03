<div>
    <x-slot:title>
        Транзакційні листи | AutoDeploy
    </x-slot>
    <x-settings.navbar />
    <form wire:submit='submit' class="flex flex-col gap-2 pb-4">
        <div class="flex items-center gap-2">
            <h2>Транзакційні листи</h2>
            <x-forms.button type="submit">
                Зберегти
            </x-forms.button>
            @if (is_transactional_emails_enabled() && auth()->user()->isAdminFromSession())
                <x-modal-input buttonTitle="Надіслати тестовий лист" title="Надіслати тестовий лист">
                    <form wire:submit.prevent="sendTestEmail" class="flex flex-col w-full gap-2">
                        <x-forms.input wire:model="testEmailAddress" placeholder="test@example.com" id="testEmailAddress"
                            label="Отримувач" required />
                        <x-forms.button type="submit" @click="modalOpen=false">
                            Надіслати лист
                        </x-forms.button>
                    </form>
                </x-modal-input>
            @endif
        </div>
        <div class="pb-4">Налаштування електронної пошти для всього екземпляра для скидання паролів, запрошень тощо.</div>
        <div class="flex gap-2">
            <x-forms.input required id="smtpFromName" helper="Ім'я, що використовується в листах." label="Ім'я відправника" />
            <x-forms.input required id="smtpFromAddress" helper="Адреса електронної пошти, що використовується в листах." label="Адреса відправника" />
        </div>
    </form>
    <div class="flex flex-col gap-4">
        <div class="p-4 border dark:border-coolgray-300 border-neutral-200">
            <form wire:submit.prevent="submitSmtp" class="flex flex-col">
                <div class="flex gap-2">
                    <h3>SMTP сервер</h3>
                    <x-forms.button type="submit">
                        Зберегти
                    </x-forms.button>
                </div>
                <div class="w-32">
                    <x-forms.checkbox instantSave='instantSave("SMTP")' id="smtpEnabled" label="Увімкнено" />
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col w-full gap-2 xl:flex-row">
                        <x-forms.input required id="smtpHost" placeholder="smtp.mailgun.org" label="Хост" />
                        <x-forms.input required id="smtpPort" placeholder="587" label="Порт" />
                        <x-forms.select required id="smtpEncryption" label="Шифрування">
                            <option value="starttls">StartTLS</option>
                            <option value="tls">TLS/SSL</option>
                            <option value="none">Немає</option>
                        </x-forms.select>
                    </div>
                    <div class="flex flex-col w-full gap-2 xl:flex-row">
                        <x-forms.input id="smtpUsername" label="Ім'я користувача SMTP" />
                        <x-forms.input id="smtpPassword" type="password" label="Пароль SMTP"
                            autocomplete="new-password" />
                        <x-forms.input id="smtpTimeout" helper="Значення тайм-ауту для надсилання листів." label="Тайм-аут" />
                    </div>
                </div>
            </form>
        </div>
        <div class="p-4 border dark:border-coolgray-300 border-neutral-200">
            <form wire:submit.prevent="submitResend" class="flex flex-col">
                <div class="flex gap-2">
                    <h3>Resend</h3>
                    <x-forms.button type="submit">
                        Зберегти
                    </x-forms.button>
                </div>
                <div class="w-32">
                    <x-forms.checkbox instantSave='instantSave("Resend")' id="resendEnabled" label="Увімкнено" />
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col w-full gap-2 xl:flex-row">
                        <x-forms.input type="password" id="resendApiKey" placeholder="Ключ API" required label="Ключ API"
                            autocomplete="new-password" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>