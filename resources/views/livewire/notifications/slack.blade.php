<div>
    <x-slot:title>
        Сповіщення | AutoDeploy
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Slack</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if ($slackEnabled)
                <x-forms.button canGate="sendTest" :canResource="$settings" class="normal-case dark:text-white btn btn-xs no-animation btn-primary"
                    wire:click="sendTestNotification">
                    Надіслати тестове сповіщення
                </x-forms.button>
            @else
                <x-forms.button canGate="sendTest" :canResource="$settings" disabled class="normal-case dark:text-white btn btn-xs no-animation btn-primary">
                    Надіслати тестове сповіщення
                </x-forms.button>
            @endif
        </div>
        <div class="w-32">
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSaveSlackEnabled" id="slackEnabled" label="Увімкнено" />
        </div>
        <x-forms.input canGate="update" :canResource="$settings" type="password"
            helper="Створіть застосунок Slack та згенеруйте URL вхідного вебхука. <br><a class='inline-block underline dark:text-white' href='https://api.slack.com/apps' target='_blank'>Створити застосунок Slack</a>"
            required id="slackWebhookUrl" label="Вебхук" />
    </form>
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення Slack.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentSuccessSlackNotifications"
                    label="Успішне розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentFailureSlackNotifications"
                    label="Невдале розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    helper="Надсилати сповіщення, коли змінюється статус контейнера. Це сповіщатиме про події зупинки та перезапуску контейнера."
                    id="statusChangeSlackNotifications" label="Зміни статусу контейнера" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupSuccessSlackNotifications" label="Успішне резервне копіювання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupFailureSlackNotifications" label="Невдале резервне копіювання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskSuccessSlackNotifications"
                    label="Успішне заплановане завдання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskFailureSlackNotifications"
                    label="Невдале заплановане завдання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupSuccessSlackNotifications"
                    label="Успішне очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupFailureSlackNotifications"
                    label="Невдале очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverDiskUsageSlackNotifications"
                    label="Використання диска сервера" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverReachableSlackNotifications"
                    label="Сервер доступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverUnreachableSlackNotifications"
                    label="Сервер недоступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverPatchSlackNotifications" label="Патчі сервера" />
            </div>
        </div>
    </div>
</div>