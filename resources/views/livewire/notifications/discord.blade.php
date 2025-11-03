<div>
    <x-slot:title>
        Сповіщення | Coolify
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Discord</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if ($discordEnabled)
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
        <div class="w-48">
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSaveDiscordEnabled" id="discordEnabled" label="Увімкнено" />
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSaveDiscordPingEnabled" id="discordPingEnabled"
                helper="Якщо увімкнено, пінг (@here) буде надіслано до сповіщення, коли станеться критична подія."
                label="Пінг увімкнено" />
        </div>
        <x-forms.input canGate="update" :canResource="$settings" type="password"
            helper="Створіть Discord-сервер та згенеруйте URL вебхука. <br><a class='inline-block underline dark:text-white' href='https://support.discord.com/hc/en-us/articles/228383668-Intro-to-Webhooks' target='_blank'>Документація по вебхуках</a>"
            required id="discordWebhookUrl" label="Вебхук" />
    </form>
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення Discord.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentSuccessDiscordNotifications"
                    label="Успішне розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentFailureDiscordNotifications"
                    label="Невдале розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    helper="Надсилати сповіщення, коли змінюється статус контейнера. Буде сповіщати про зупинені та перезапущені події контейнера."
                    id="statusChangeDiscordNotifications" label="Зміни статусу контейнера" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupSuccessDiscordNotifications"
                    label="Успішне резервне копіювання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupFailureDiscordNotifications"
                    label="Невдале резервне копіювання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskSuccessDiscordNotifications"
                    label="Успішне заплановане завдання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskFailureDiscordNotifications"
                    label="Невдале заплановане завдання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupSuccessDiscordNotifications"
                    label="Успішне очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupFailureDiscordNotifications"
                    label="Невдале очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverDiskUsageDiscordNotifications"
                    label="Використання диска сервера" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverReachableDiscordNotifications"
                    label="Сервер доступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverUnreachableDiscordNotifications"
                    label="Сервер недоступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverPatchDiscordNotifications"
                    label="Оновлення сервера" />
            </div>
        </div>
    </div>
</div>