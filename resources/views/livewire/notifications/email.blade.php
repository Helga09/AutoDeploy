<div>
    <x-slot:title>
        Сповіщення | AutoDeploy
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Електронна пошта</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if (auth()->user()->isAdminFromSession())
                @can('sendTest', $settings)
                    @if ($team->isNotificationEnabled('email'))
                        <x-modal-input buttonTitle="Надіслати тестовий лист" title="Надіслати тестовий лист">
                            <form wire:submit.prevent="sendTestEmail" class="flex flex-col w-full gap-2">
                                <x-forms.input wire:model="testEmailAddress" placeholder="test@example.com"
                                    id="testEmailAddress" label="Отримувач" required />
                                <x-forms.button type="submit" @click="modalOpen=false">
                                    Надіслати лист
                                </x-forms.button>
                            </form>
                        </x-modal-input>
                    @else
                        <x-forms.button disabled class="normal-case dark:text-white btn btn-xs no-animation btn-primary">
                            Надіслати тестовий лист
                        </x-forms.button>
                    @endif
                @endcan
            @endif
        </div>
        @if (!isCloud())
            <div class="w-96">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSave()" id="useInstanceEmailSettings"
                    label="Використовувати загальносистемні (транзакційні) налаштування електронної пошти" />
            </div>
        @endif
        @if (!$useInstanceEmailSettings)
            <div class="flex gap-2">
                <x-forms.input canGate="update" :canResource="$settings" required id="smtpFromName" helper="Ім'я, що використовується в листах." label="Ім'я відправника" />
                <x-forms.input canGate="update" :canResource="$settings" required id="smtpFromAddress" helper="Адреса електронної пошти, що використовується в листах."
                    label="Адреса відправника" />
            </div>
            @if (isInstanceAdmin() && !$useInstanceEmailSettings)
                <x-forms.button canGate="update" :canResource="$settings" wire:click='copyFromInstanceSettings'>
                    Копіювати з налаштувань екземпляра
                </x-forms.button>
            @endif
        @endif
    </form>
    @if (isCloud())
        <div class="w-64 py-4">
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSave()" id="useInstanceEmailSettings"
                label="Використовувати розміщений сервіс електронної пошти" />
        </div>
    @endif
    @if (!$useInstanceEmailSettings)
        <div class="flex flex-col gap-4">
            <form wire:submit='submitSmtp'
                class="p-4 border dark:border-coolgray-300 border-neutral-200 rounded-lg flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <h3>SMTP-сервер</h3>
                    <x-forms.button canGate="update" :canResource="$settings" type="submit">
                        Зберегти
                    </x-forms.button>
                </div>
                <div class="w-32">
                    <x-forms.checkbox canGate="update" :canResource="$settings" wire:model="smtpEnabled" instantSave="instantSave('SMTP')" id="smtpEnabled"
                        label="Увімкнено" />
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input canGate="update" :canResource="$settings" required id="smtpHost" placeholder="smtp.mailgun.org" label="Хост" />
                            <x-forms.input canGate="update" :canResource="$settings" required id="smtpPort" placeholder="587" label="Порт" />
                            <x-forms.select canGate="update" :canResource="$settings" required id="smtpEncryption" label="Шифрування">
                                <option value="starttls">StartTLS</option>
                                <option value="tls">TLS/SSL</option>
                                <option value="none">Без шифрування</option>
                            </x-forms.select>
                        </div>
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input canGate="update" :canResource="$settings" id="smtpUsername" label="Ім'я користувача SMTP" />
                            <x-forms.input canGate="update" :canResource="$settings" id="smtpPassword" type="password" label="Пароль SMTP" />
                            <x-forms.input canGate="update" :canResource="$settings" id="smtpTimeout" helper="Значення тайм-ауту для відправки листів."
                                label="Тайм-аут" />
                        </div>
                    </div>
                </div>
            </form>
            <form wire:submit='submitResend'
                class="p-4 border dark:border-coolgray-300 border-neutral-200 rounded-lg flex flex-col gap-2">
                <div class="flex items-center gap-2">
                    <h3>Resend</h3>
                    <x-forms.button canGate="update" :canResource="$settings" type="submit">
                        Зберегти
                    </x-forms.button>
                </div>
                <div class="w-32">
                    <x-forms.checkbox canGate="update" :canResource="$settings" wire:model="resendEnabled" instantSave="instantSave('Resend')" id="resendEnabled"
                        label="Увімкнено" />
                </div>
                <div class="flex flex-col">
                    <div class="flex flex-col gap-4">
                        <div class="flex flex-col w-full gap-2 xl:flex-row">
                            <x-forms.input canGate="update" :canResource="$settings" required type="password" id="resendApiKey" placeholder="API key"
                                label="API-ключ" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення електронною поштою.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentSuccessEmailNotifications"
                    label="Успішне розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentFailureEmailNotifications"
                    label="Невдале розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    helper="Надсилати лист при зміні статусу контейнера. Сповіщення будуть надсилатися для подій Зупинено та Перезапущено."
                    id="statusChangeEmailNotifications" label="Зміни статусу контейнера" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupSuccessEmailNotifications"
                    label="Успішне резервне копіювання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupFailureEmailNotifications"
                    label="Невдале резервне копіювання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskSuccessEmailNotifications"
                    label="Успішне заплановане завдання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskFailureEmailNotifications"
                    label="Невдале заплановане завдання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupSuccessEmailNotifications"
                    label="Успішне очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupFailureEmailNotifications"
                    label="Невдале очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverDiskUsageEmailNotifications"
                    label="Використання диска сервера" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverReachableEmailNotifications"
                    label="Сервер доступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverUnreachableEmailNotifications"
                    label="Сервер недоступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverPatchEmailNotifications"
                    label="Оновлення сервера" />
            </div>
        </div>
    </div>
</div>