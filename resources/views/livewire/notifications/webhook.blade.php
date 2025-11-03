<div>
    <x-slot:title>
        Сповіщення | AutoDeploy
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Вебхук</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if ($webhookEnabled)
                <x-forms.button canGate="sendTest" :canResource="$settings"
                    class="normal-case dark:text-white btn btn-xs no-animation btn-primary"
                    wire:click="sendTestNotification">
                    Надіслати тестове сповіщення
                </x-forms.button>
            @else
                <x-forms.button canGate="sendTest" :canResource="$settings" disabled
                    class="normal-case dark:text-white btn btn-xs no-animation btn-primary">
                    Надіслати тестове сповіщення
                </x-forms.button>
            @endif
        </div>
        <div class="w-48">
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSaveWebhookEnabled"
                id="webhookEnabled" label="Увімкнено" />
        </div>
        <div class="flex items-end gap-2">

            <x-forms.input canGate="update" :canResource="$settings" type="password"
                helper="Введіть дійсний URL-адресу HTTP або HTTPS. AutoDeploy надсилатиме POST-запити на цю кінцеву точку при виникненні подій."
                required id="webhookUrl" label="URL вебхука (POST)" />
        </div>
    </form>
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення вебхука.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="deploymentSuccessWebhookNotifications" label="Успішне розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="deploymentFailureWebhookNotifications" label="Невдале розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    helper="Надсилати сповіщення при зміні статусу контейнера. Сповіщатиме про події зупинки та перезапуску контейнера."
                    id="statusChangeWebhookNotifications" label="Зміни статусу контейнера" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="backupSuccessWebhookNotifications" label="Успішне резервне копіювання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="backupFailureWebhookNotifications" label="Невдале резервне копіювання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="scheduledTaskSuccessWebhookNotifications" label="Успішне заплановане завдання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="scheduledTaskFailureWebhookNotifications" label="Невдале заплановане завдання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="dockerCleanupSuccessWebhookNotifications" label="Успішне очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="dockerCleanupFailureWebhookNotifications" label="Невдале очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="serverDiskUsageWebhookNotifications" label="Використання диска сервера" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="serverReachableWebhookNotifications" label="Сервер доступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="serverUnreachableWebhookNotifications" label="Сервер недоступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    id="serverPatchWebhookNotifications" label="Патчинг сервера" />
            </div>
        </div>
    </div>
</div>