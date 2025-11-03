<div>
    <dialog id="newInitScript" class="modal">
        <form method="dialog" class="flex flex-col gap-2 rounded-sm modal-box" wire:submit='save_new_init_script'>
            <h3 class="text-lg font-bold">Додати сценарій ініціалізації</h3>
            <x-forms.input placeholder="create_test_db.sql" id="new_filename" label="Ім'я файлу" required />
            <x-forms.textarea placeholder="CREATE DATABASE test;" id="new_content" label="Вміст" required />
            <x-forms.button onclick="newInitScript.close()" type="submit">
                Зберегти
            </x-forms.button>
        </form>
        <form method="dialog" class="modal-backdrop">
            <button>Закрити</button>
        </form>
    </dialog>

    <form wire:submit="submit" class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            <h2>Загальні</h2>
            <x-forms.button type="submit" canGate="update" :canResource="$database">
                Зберегти
            </x-forms.button>
        </div>
        <div class="flex flex-wrap gap-2 sm:flex-nowrap">
            <x-forms.input label="Назва" id="name" canGate="update" :canResource="$database" />
            <x-forms.input label="Опис" id="description" canGate="update" :canResource="$database" />
            <x-forms.input label="Образ" id="image" required canGate="update" :canResource="$database"
                helper="Щоб переглянути всі доступні образи, перевірте тут:<br><br><a target='_blank' href='https://hub.docker.com/_/postgres'>https://hub.docker.com/_/postgres</a>" />
        </div>
        <div class="pt-2 dark:text-warning">Якщо ви змінюєте значення в базі даних, синхронізуйте їх тут, інакше автоматизація (наприклад, резервне копіювання) не працюватиме.
        </div>
        @if ($database->started_at)
            <div class="flex xl:flex-row flex-col gap-2">
                <x-forms.input label="Ім'я користувача" id="postgresUser" placeholder="Якщо порожньо: postgres"
                    canGate="update" :canResource="$database"
                    helper="Якщо ви змінюєте це в базі даних, синхронізуйте це тут, інакше автоматизація (наприклад, резервне копіювання) не працюватиме." />
                <x-forms.input label="Пароль" id="postgresPassword" type="password" required
                    canGate="update" :canResource="$database"
                    helper="Якщо ви змінюєте це в базі даних, синхронізуйте це тут, інакше автоматизація (наприклад, резервне копіювання) не працюватиме." />
                <x-forms.input label="Початкова база даних" id="postgresDb"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я користувача." readonly
                    helper="Ви можете змінити це лише в базі даних." />
            </div>
        @else
            <div class="flex xl:flex-row flex-col gap-2 pb-2">
                <x-forms.input label="Ім'я користувача" id="postgresUser" placeholder="Якщо порожньо: postgres"
                    canGate="update" :canResource="$database" />
                <x-forms.input label="Пароль" id="postgresPassword" type="password" required
                    canGate="update" :canResource="$database" />
                <x-forms.input label="Початкова база даних" id="postgresDb"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я користувача." canGate="update" :canResource="$database" />
            </div>
        @endif
        <div class="flex gap-2">
            <x-forms.input label="Аргументи початкової бази даних" canGate="update" :canResource="$database"
                id="postgresInitdbArgs" placeholder="Якщо порожньо, використовувати за замовчуванням. Дивіться в документації Docker." />
            <x-forms.input label="Метод аутентифікації хоста" canGate="update" :canResource="$database"
                id="postgresHostAuthMethod" placeholder="Якщо порожньо, використовувати за замовчуванням. Дивіться в документації Docker." />
        </div>
        <x-forms.input
            helper="Ви можете додати власні параметри виконання Docker, які будуть використані під час запуску вашого контейнера.<br>Примітка: Не всі параметри підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та викликати негативний досвід для користувачів.<br><br>Перегляньте <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/docker/custom-commands'>документацію.</a>"
            placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
            id="customDockerRunOptions" label="Власні параметри Docker" canGate="update" :canResource="$database" />
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Мапування портів"
                    helper="Список портів, розділених комою, які ви хочете зіставити з хост-системою.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433"
                    canGate="update" :canResource="$database" />
            </div>

            <x-forms.input label="Postgres URL (внутрішній)"
                helper="Якщо ви зміните ім'я користувача/пароль/порт, це може відрізнятися. Це зі значеннями за замовчуванням."
                type="password" readonly wire:model="db_url" />
            @if ($db_url_public)
                <x-forms.input label="Postgres URL (публічний)"
                    helper="Якщо ви зміните ім'я користувача/пароль/порт, це може відрізнятися. Це зі значеннями за замовчуванням."
                    type="password" readonly wire:model="db_url_public" />
            @endif
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 py-2">
                <h3>Конфігурація SSL</h3>
                @if ($enableSsl && $certificateValidUntil)
                    <x-modal-confirmation title="Перегенерувати сертифікати SSL" buttonTitle="Перегенерувати сертифікати SSL"
                        :actions="[
                            'SSL-сертифікат цієї бази даних буде перегенеровано.',
                            'Ви повинні перезапустити базу даних після перегенерації сертифіката, щоб почати використовувати новий сертифікат.',
                        ]" submitAction="regenerateSslCertificate" :confirmWithText="false"
                        :confirmWithPassword="false" />
                @endif
            </div>
            @if ($enableSsl && $certificateValidUntil)
                <span class="text-sm">Дійсний до:
                    @if (now()->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Закінчився термін дії</span>
                    @elseif(now()->addDays(30)->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Термін дії скоро закінчиться</span>
                    @else
                        <span>{{ $certificateValidUntil->format('d.m.Y H:i:s') }}</span>
                    @endif
                </span>
            @endif
        </div>
        <div class="flex flex-col gap-2">
            <div class="w-64" wire:key='enable_ssl'>
                    @if ($database->isExited())
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" canGate="update"
                            :canResource="$database" />
                    @else
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" disabled
                            helper="Базу даних потрібно зупинити, щоб змінити ці налаштування." />
                    @endif
                </div>
                @if ($enableSsl)
                    <div class="mx-2">
                        @if ($database->isExited())
                            <x-forms.select id="sslMode" label="Режим SSL"
                                wire:model.live="sslMode" instantSave="instantSaveSSL"
                                helper="Виберіть режим перевірки SSL для підключень PostgreSQL" canGate="update"
                                :canResource="$database">
                                <option value="allow" title="Дозволити незахищені з'єднання">дозволити (незахищено)</option>
                                <option value="prefer" title="Віддати перевагу захищеним з'єднанням">віддати перевагу (захищено)</option>
                                <option value="require" title="Вимагати захищені з'єднання">вимагати (захищено)</option>
                                <option value="verify-ca" title="Перевірити сертифікат CA">перевірити CA (захищено)</option>
                                <option value="verify-full" title="Перевірити повний сертифікат">перевірити повністю (захищено)
                                </option>
                            </x-forms.select>
                        @else
                            <x-forms.select id="sslMode" label="Режим SSL" instantSave="instantSaveSSL"
                                disabled helper="Базу даних потрібно зупинити, щоб змінити ці налаштування.">
                                <option value="allow" title="Дозволити незахищені з'єднання">дозволити (незахищено)</option>
                                <option value="prefer" title="Віддати перевагу захищеним з'єднанням">віддати перевагу (захищено)</option>
                                <option value="require" title="Вимагати захищені з'єднання">вимагати (захищено)</option>
                                <option value="verify-ca" title="Перевірити сертифікат CA">перевірити CA (захищено)</option>
                                <option value="verify-full" title="Перевірити повний сертифікат">перевірити повністю (захищено)
                                </option>
                            </x-forms.select>
                        @endif
                    </div>
                @endif

                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2 py-2">
                        <h3>Проксі</h3>
                        <x-loading wire:loading wire:target="instantSave" />
                        @if (data_get($database, 'is_public'))
                            <x-slide-over fullScreen>
                                <x-slot:title>Логи проксі</x-slot:title>
                                <x-slot:content>
                                    <livewire:project.shared.get-logs :server="$server" :resource="$database"
                                        container="{{ data_get($database, 'uuid') }}-proxy" lazy />
                                </x-slot:content>
                                <x-forms.button disabled="{{ !data_get($database, 'is_public') }}"
                                    @click="slideOverOpen=true">Логи</x-forms.button>
                            </x-slide-over>
                        @endif
                    </div>
                    <div class="flex flex-col gap-2 w-64">
                        <x-forms.checkbox instantSave id="isPublic" label="Зробити загальнодоступним"
                            canGate="update" :canResource="$database" />
                    </div>
                    <x-forms.input placeholder="5432" disabled="{{ $isPublic }}"
                        id="publicPort" label="Публічний порт" canGate="update" :canResource="$database" />
                </div>

                <div class="flex flex-col gap-2">
                    <x-forms.textarea label="Власна конфігурація PostgreSQL" rows="10"
                        id="postgresConf" canGate="update" :canResource="$database" />
                </div>
    </form>

    <div class="flex flex-col gap-4 pt-4">
        <h3>Додатково</h3>
        <div class="flex flex-col">
            <x-forms.checkbox helper="Зливати логи до налаштованої кінцевої точки зливу логів у налаштуваннях вашого сервера."
                instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Зливати логи"
                canGate="update" :canResource="$database" />
        </div>

        <div class="pb-16">
            <div class="flex items-center gap-2 pb-2">

                <h3>Сценарії ініціалізації</h3>
                @can('update', $database)
                    <x-modal-input buttonTitle="+ Додати" title="Новий сценарій ініціалізації">
                        <form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='save_new_init_script'>
                            <x-forms.input placeholder="create_test_db.sql" id="new_filename" label="Ім'я файлу"
                                required />
                            <x-forms.textarea rows="20" placeholder="CREATE DATABASE test;" id="new_content"
                                label="Вміст" required />
                            <x-forms.button type="submit">
                                Зберегти
                            </x-forms.button>
                        </form>
                    </x-modal-input>
                @endcan
            </div>
            <div class="flex flex-col gap-2">
                @forelse($initScripts ?? [] as $script)
                    <livewire:project.database.init-script :script="$script" :wire:key="$script['index']" />
                @empty
                    <div>Сценарії ініціалізації не знайдено.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>