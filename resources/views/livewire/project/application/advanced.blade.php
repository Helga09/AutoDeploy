<div>
    <div class="flex flex-col md:w-96">
        <div class="flex items-center gap-2">
            <h2>Додатково</h2>
        </div>
        <div>Розширена конфігурація для вашої програми.</div>
        <div class="flex flex-col gap-1 pt-4">
            <h3>Загальні</h3>
            @if ($application->git_based())
                <x-forms.checkbox
                    helper="Дозволити автоматичне розгортання попередніх версій для всіх відкритих PR.<br><br>Закриття PR видалить попередні розгортання."
                    instantSave id="isPreviewDeploymentsEnabled" label="Попередні розгортання" canGate="update"
                    :canResource="$application" />
                @if ($isPreviewDeploymentsEnabled)
                    <x-forms.checkbox
                        helper="Якщо увімкнено, будь-хто може ініціювати розгортання PR. Якщо вимкнено, лише учасники репозиторію, співавтори та контриб'ютори можуть ініціювати розгортання PR."
                        instantSave id="isPrDeploymentsPublicEnabled" label="Дозволити публічні розгортання PR" canGate="update"
                        :canResource="$application" />
                @endif
            @endif
            <x-forms.checkbox helper="Вимкнути кеш збірки Docker при кожному розгортанні." instantSave
                id="disableBuildCache" label="Вимкнути кеш збірки" canGate="update" :canResource="$application" />

            @if ($application->settings->is_container_label_readonly_enabled)
                <x-forms.checkbox
                    helper="Ваша програма буде доступна лише за протоколом https, якщо ваш домен починається з https://..."
                    instantSave id="isForceHttpsEnabled" label="Примусовий Https" canGate="update" :canResource="$application" />
                <x-forms.checkbox helper="Strip Prefix використовується для видалення префіксів зі шляхів. Наприклад, /api/ до /api."
                    instantSave id="isStripprefixEnabled" label="Видалити префікси" canGate="update" :canResource="$application" />
            @else
                <x-forms.checkbox disabled
                    helper="Мітки лише для читання вимкнено. Вам потрібно встановити мітки в розділі міток." instantSave
                    id="isForceHttpsEnabled" label="Примусовий Https" canGate="update" :canResource="$application" />
                <x-forms.checkbox label="Увімкнути Gzip стиснення" disabled
                    helper="Мітки лише для читання вимкнено. Вам потрібно встановити мітки в розділі міток." instantSave
                    id="isGzipEnabled" canGate="update" :canResource="$application" />
                <x-forms.checkbox
                    helper="Мітки лише для читання вимкнено. Вам потрібно встановити мітки в розділі міток." disabled
                    instantSave id="isStripprefixEnabled" label="Видалити префікси" canGate="update" :canResource="$application" />
            @endif
            @if ($application->build_pack === 'dockercompose')
                <h3>Docker Compose</h3>
                <x-forms.checkbox instantSave id="isRawComposeDeploymentEnabled" label="Розгортання Raw Compose"
                    helper="УВАГА: Лише для просунутих випадків використання. Ваш файл docker-compose буде розгорнуто як є. AutoDeploy нічого не змінює."
                    canGate="update" :canResource="$application" />
            @endif
            <h3 class="pt-4">Імена контейнерів</h3>
            <x-forms.checkbox
                helper="Розгорнутий контейнер матиме те саме ім'я ({{ $application->uuid }}). <span class='font-bold dark:text-warning'>Ви втратите функцію безперервного оновлення!</span>"
                instantSave id="isConsistentContainerNameEnabled" label="Послідовні імена контейнерів" canGate="update"
                :canResource="$application" />
            @if ($isConsistentContainerNameEnabled === false)
                <form class="flex items-end gap-2 " wire:submit.prevent='saveCustomName'>
                    <x-forms.input
                        helper="Ви можете додати власне ім'я для вашого контейнера.<br><br>Ім'я буде перетворено у формат slug під час збереження. <span class='font-bold dark:text-warning'>Ви втратите функцію безперервного оновлення!</span>"
                        instantSave id="customInternalName" label="Власне ім'я контейнера" canGate="update"
                        :canResource="$application" />
                    <x-forms.button canGate="update" :canResource="$application" type="submit">Зберегти</x-forms.button>
                </form>
            @endif
            @if ($application->build_pack === 'dockercompose')
                <h3 class="pt-4">Мережа</h3>
                <x-forms.checkbox instantSave id="isConnectToDockerNetworkEnabled" label="Підключити до визначеної мережі"
                    helper="За замовчуванням, ви не матимете доступу до мереж, визначених AutoDeploy.<br>Запуск ресурсу на основі docker-compose матиме внутрішню мережу. <br>Якщо ви підключаєтеся до мережі, визначеної AutoDeploy, можливо, вам знадобиться використовувати різні внутрішні DNS-імена для підключення до ресурсу."
                    canGate="update" :canResource="$application" />
            @endif

        </div>

    </div>
</div>