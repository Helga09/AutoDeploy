<div>
    <x-slot:title>
        Сповіщення | AutoDeploy
    </x-slot>
    <x-notification.navbar />
    <form wire:submit='submit' class="flex flex-col gap-4 pb-4">
        <div class="flex items-center gap-2">
            <h2>Pushover</h2>
            <x-forms.button canGate="update" :canResource="$settings" type="submit">
                Зберегти
            </x-forms.button>
            @if ($pushoverEnabled)
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
            <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="instantSavePushoverEnabled" id="pushoverEnabled" label="Увімкнено" />
        </div>
        <div class="flex  gap-2">
            <x-forms.input canGate="update" :canResource="$settings" type="password"
                helper="Отримайте ваш ключ користувача в Pushover. Ви повинні бути авторизовані в Pushover, щоб побачити свій ключ користувача у верхньому правому куті. <br><a class='inline-block underline dark:text-white' href='https://pushover.net/' target='_blank'>Панель керування Pushover</a>"
                required id="pushoverUserKey" label="Ключ користувача" />
            <x-forms.input canGate="update" :canResource="$settings" type="password"
                helper="Згенеруйте API токен/ключ у Pushover, створивши нову програму. <br><a class='inline-block underline dark:text-white' href='https://pushover.net/apps/build' target='_blank'>Створити програму Pushover</a>"
                required id="pushoverApiToken" label="API токен" />
        </div>
    </form>
    <h2 class="mt-4">Налаштування сповіщень</h2>
    <p class="mb-4">
        Виберіть події, для яких ви бажаєте отримувати сповіщення Pushover.
    </p>
    <div class="flex flex-col gap-4 max-w-2xl">
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Розгортання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentSuccessPushoverNotifications"
                    label="Успішне розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="deploymentFailurePushoverNotifications"
                    label="Помилка розгортання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel"
                    helper="Надіслати сповіщення при зміні статусу контейнера. Воно сповіщатиме про події зупинки та перезапуску контейнера."
                    id="statusChangePushoverNotifications" label="Зміни статусу контейнера" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Резервні копії</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupSuccessPushoverNotifications"
                    label="Успішне резервне копіювання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="backupFailurePushoverNotifications"
                    label="Помилка резервного копіювання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Заплановані завдання</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskSuccessPushoverNotifications"
                    label="Успішне заплановане завдання" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="scheduledTaskFailurePushoverNotifications"
                    label="Помилка запланованого завдання" />
            </div>
        </div>
        <div class="border dark:border-coolgray-300 border-neutral-200 p-4 rounded-lg">
            <h3 class="font-medium mb-3">Сервер</h3>
            <div class="flex flex-col gap-1.5 pl-1">
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupSuccessPushoverNotifications"
                    label="Успішне очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="dockerCleanupFailurePushoverNotifications"
                    label="Помилка очищення Docker" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverDiskUsagePushoverNotifications"
                    label="Використання диска сервера" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverReachablePushoverNotifications"
                    label="Сервер доступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverUnreachablePushoverNotifications"
                    label="Сервер недоступний" />
                <x-forms.checkbox canGate="update" :canResource="$settings" instantSave="saveModel" id="serverPatchPushoverNotifications"
                    label="Оновлення сервера" />
            </div>
        </div>
    </div>
</div>