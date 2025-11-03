<div>
    <x-slot:title>
        Сповіщення | Coolify
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Telegram</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if ($telegramEnabled)
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
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSaveTelegramEnabled" id="telegramEnabled" label="Увімкнено" />
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$settings" type="password" autocomplete="new-password"
                helper="Отримайте його від <a class='inline-block underline dark:text-white' href='https://t.me/botfather' target='_blank'>BotFather Bot</a> у Telegram."
                required id="telegramToken" label="Токен Bot API" />
            <x-forms.input canGate="update" :canResource="$settings" type="password" autocomplete="new-password"
                helper="Додайте свого бота до групового чату та вкажіть його ID чату тут." required id="telegramChatId"
                label="ID чату" />
        </div>
    </form>
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення Telegram.
    </p>
    <div class="flex flex-col gap-4 ">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="text-lg font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentSuccessTelegramNotifications"
                            label="Успішне розгортання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsDeploymentSuccessThreadId" />
                </div>
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentFailureTelegramNotifications"
                            label="Невдале розгортання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsDeploymentFailureThreadId" />
                </div>
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="statusChangeTelegramNotifications"
                            label="Зміни статусу контейнера"
                            helper="Надсилати сповіщення при зміні статусу контейнера. Воно надішле сповіщення про зупинку та перезапуск контейнера." />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" id="telegramNotificationsStatusChangeThreadId"
                        placeholder="Користувацький ID потоку Telegram" />
                </div>
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="text-lg font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupSuccessTelegramNotifications"
                            label="Успішне резервне копіювання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsBackupSuccessThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupFailureTelegramNotifications"
                            label="Невдале резервне копіювання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsBackupFailureThreadId" />
                </div>
            </div>
        </div>

        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="text-lg font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskSuccessTelegramNotifications"
                            label="Успішне заплановане завдання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsScheduledTaskSuccessThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskFailureTelegramNotifications"
                            label="Невдале заплановане завдання" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsScheduledTaskFailureThreadId" />
                </div>
            </div>
        </div>

        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="text-lg font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupSuccessTelegramNotifications"
                            label="Успішне очищення Docker" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsDockerCleanupSuccessThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupFailureTelegramNotifications"
                            label="Невдале очищення Docker" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsDockerCleanupFailureThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverDiskUsageTelegramNotifications"
                            label="Використання диска сервера" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsServerDiskUsageThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverReachableTelegramNotifications"
                            label="Сервер доступний" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsServerReachableThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverUnreachableTelegramNotifications"
                            label="Сервер недоступний" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsServerUnreachableThreadId" />
                </div>

                <div class="pl-1 flex gap-2">
                    <div class="w-96">
                        <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverPatchTelegramNotifications"
                            label="Оновлення сервера" />
                    </div>
                    <x-forms.input canGate="update" :canResource="$settings" type="password" placeholder="Користувацький ID потоку Telegram"
                        id="telegramNotificationsServerPatchThreadId" />
                </div>
            </div>
        </div>
    </div>
</div>