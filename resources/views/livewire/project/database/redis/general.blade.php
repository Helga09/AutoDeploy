<div>
    <form wire:submit="submit" class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            <h2>Загальні</h2>
            <x-forms.button type="submit" canGate="update" :canResource="$database">
                Зберегти
            </x-forms.button>
        </div>
        <div class="flex gap-2">
            <x-forms.input label="Назва" id="name" canGate="update" :canResource="$database" />
            <x-forms.input label="Опис" id="description" canGate="update" :canResource="$database" />
            <x-forms.input label="Зображення" id="image" required canGate="update" :canResource="$database"
                helper="Доступні зображення дивіться тут:<br><br><a target='_blank' href='https://hub.docker.com/_/redis'>https://hub.docker.com/_/redis</a>" />
        </div>
        <div class="flex flex-col gap-2">
            @if ($database->started_at)
                <div class="pt-2 dark:text-warning">Якщо ви зміните значення в базі даних, будь ласка, синхронізуйте їх тут,
                    інакше
                    автоматизації не працюватимуть. <br>Зміна значень тут не змінить їх у базі даних.
                </div>
                <div class="flex gap-2">
                    @if (version_compare($redisVersion, '6.0', '>='))
                        <x-forms.input label="Ім'я користувача" id="redisUsername"
                            helper="Це можна змінити лише в базі даних." canGate="update" :canResource="$database" />
                    @endif
                    <x-forms.input label="Пароль" id="redisPassword" type="password"
                        helper="Це можна змінити лише в базі даних." canGate="update" :canResource="$database" />
                </div>
            @else
                <div class="pt-2 dark:text-warning">Ви можете змінити ім'я користувача та пароль у базі даних лише після початкового запуску.</div>
                <div class="flex gap-2">
                    @if (version_compare($redisVersion, '6.0', '>='))
                        <x-forms.input label="Ім'я користувача" id="redisUsername" required
                            helper="Ви можете змінити ім'я користувача Redis у полі нижче або відредагувавши значення змінної середовища REDIS_USERNAME.
                    <br><br>
                    Якщо ви зміните ім'я користувача Redis у базі даних, будь ласка, синхронізуйте його тут, інакше автоматизації (наприклад, резервне копіювання) не працюватимуть.
                    <br><br>
                    Примітка: Якщо змінна середовища REDIS_USERNAME встановлена як спільна змінна (для середовища, проекту або команди), це поле вводу стане доступним лише для читання."
                            :disabled="$this->isSharedVariable('REDIS_USERNAME')" canGate="update" :canResource="$database" />
                    @endif
                    <x-forms.input label="Пароль" id="redisPassword" type="password" required
                        helper="Ви можете змінити пароль Redis у полі нижче або відредагувавши значення змінної середовища REDIS_PASSWORD.
                <br><br>
                Якщо ви зміните пароль Redis у базі даних, будь ласка, синхронізуйте його тут, інакше автоматизації (наприклад, резервне копіювання) не працюватимуть.
                <br><br>
                Примітка: Якщо змінна середовища REDIS_PASSWORD встановлена як спільна змінна (для середовища, проекту або команди), це поле вводу стане доступним лише для читання."
                        :disabled="$this->isSharedVariable('REDIS_PASSWORD')" canGate="update" :canResource="$database" />
                </div>
            @endif
        </div>
        <x-forms.input
            helper="Ви можете додати власні параметри запуску Docker, які будуть використані під час старту вашого контейнера.<br>Примітка: Не всі параметри підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та викликати негативний досвід для користувачів.<br><br>Перегляньте <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/docker/custom-commands'>документацію.</a>"
            placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
            id="customDockerRunOptions" label="Власні параметри Docker" canGate="update" :canResource="$database" />
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Мапування портів"
                    helper="Список портів, розділених комою, які ви хочете мапувати до хост-системи.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433"
                    canGate="update" :canResource="$database" />
            </div>
            <x-forms.input label="URL-адреса Redis (внутрішня)"
                helper="Якщо ви зміните ім'я користувача/пароль/порт, це значення може відрізнятися. Це значення за замовчуванням."
                type="password" readonly wire:model="dbUrl" canGate="update" :canResource="$database" />
            @if ($dbUrlPublic)
                <x-forms.input label="URL-адреса Redis (публічна)"
                    helper="Якщо ви зміните ім'я користувача/пароль/порт, це значення може відрізнятися. Це значення за замовчуванням."
                    type="password" readonly wire:model="dbUrlPublic" canGate="update" :canResource="$database" />
            @endif
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center justify-between w-full">
                    <h3>Конфігурація SSL</h3>
                    @if ($enableSsl && $certificateValidUntil)
                        <x-modal-confirmation title="Перегенерувати SSL-сертифікати"
                            buttonTitle="Перегенерувати SSL-сертифікати" :actions="[
                                'SSL-сертифікат цієї бази даних буде перегенеровано.',
                                'Ви повинні перезапустити базу даних після перегенерації сертифіката, щоб почати використовувати новий сертифікат.',
                            ]"
                            submitAction="regenerateSslCertificate" :confirmWithText="false" :confirmWithPassword="false" />
                    @endif
                </div>
            </div>
            @if ($enableSsl && $certificateValidUntil)
                <span class="text-sm">Дійсний до:
                    @if (now()->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Термін дії закінчився</span>
                    @elseif(now()->addDays(30)->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Термін дії скоро закінчується</span>
                    @else
                        <span>{{ $certificateValidUntil->format('d.m.Y H:i:s') }}</span>
                    @endif
                </span>
            @endif
            <div class="flex flex-col gap-2">
                <div class="w-64" wire:key='enable_ssl'>
                    @if (str($database->status)->contains('exited'))
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" canGate="update"
                            :canResource="$database" />
                    @else
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" disabled
                            helper="Для зміни цих налаштувань база даних повинна бути зупинена." canGate="update"
                            :canResource="$database" />
                    @endif
                </div>
            </div>
        </div>
        <div>
            <div class="flex flex-col py-2 w-64">
                <div class="flex items-center gap-2 pb-2">
                    <div class="flex items-center">
                        <h3>Проксі</h3>
                        <x-loading wire:loading wire:target="instantSave" />
                    </div>
                    @if ($isPublic)
                        <x-slide-over fullScreen>
                            <x-slot:title>Журнали проксі</x-slot:title>
                            <x-slot:content>
                                <livewire:project.shared.get-logs :server="$server" :resource="$database"
                                    container="{{ data_get($database, 'uuid') }}-proxy" lazy />
                            </x-slot:content>
                            <x-forms.button disabled="{{ !$isPublic }}"
                                @click="slideOverOpen=true">Журнали</x-forms.button>
                        </x-slide-over>
                    @endif
                </div>
                <x-forms.checkbox instantSave id="isPublic" label="Зробити загальнодоступним"
                    canGate="update" :canResource="$database" />
            </div>
            <x-forms.input placeholder="5432" disabled="{{ $isPublic }}"
                id="publicPort" label="Публічний порт" canGate="update" :canResource="$database" />
        </div>
        <x-forms.textarea placeholder="# maxmemory 256mb
# maxmemory-policy allkeys-lru
# timeout 300"
            helper="Вам потрібно надати лише ті директиви Redis, які ви хочете перевизначити — для всього іншого Redis використовуватиме значення за замовчуванням. <br/><br/>
⚠️ <strong>Важливо:</strong> AutoDeploy автоматично застосовує директиву requirepass, використовуючи пароль, вказаний у полі &quot;Пароль&quot; вище. Якщо ви перевизначите requirepass у своїй власній конфігурації, переконайтеся, що він відповідає полю пароля, щоб уникнути проблем з автентифікацією. <br/><br/>
🔗 <strong>Порада:</strong> <a target='_blank' class='underline dark:text-white' href='https://raw.githubusercontent.com/redis/redis/7.2/redis.conf'>Перегляньте повну конфігурацію Redis за замовчуванням</a>, щоб побачити доступні параметри."
            label="Власна конфігурація Redis" rows="10" id="redisConf" canGate="update"
            :canResource="$database" />



        <h3 class="pt-4">Розширені</h3>
        <div class="flex flex-col">
            <x-forms.checkbox helper="Передавати журнали до налаштованої кінцевої точки зливу журналів у налаштуваннях вашого сервера."
                instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Злив журналів"
                canGate="update" :canResource="$database" />
        </div>

    </form>
</div>