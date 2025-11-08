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
                helper="Щоб переглянути всі доступні образи, перевірте тут:<br><br><a target='_blank' href='https://hub.docker.com/_/mongo'>https://hub.docker.com/_/mongo</a>" />
        </div>
        <div class="pt-2 dark:text-warning">Якщо ви змінюєте значення в базі даних, будь ласка, синхронізуйте їх тут, інакше
            автоматизація (наприклад, резервне копіювання) не працюватиме.
        </div>
        @if ($database->started_at)
            <div class="flex xl:flex-row flex-col gap-2">
                <x-forms.input label="Початкове ім'я користувача" id="mongoInitdbRootUsername"
                    placeholder="Якщо порожньо: postgres"
                    helper="Якщо ви зміните це в базі даних, будь ласка, синхронізуйте це тут, інакше автоматизація (наприклад, резервне копіювання) не працюватиме."
                    canGate="update" :canResource="$database" />
                <x-forms.input label="Початковий пароль" id="mongoInitdbRootPassword" type="password"
                    required
                    helper="Якщо ви зміните це в базі даних, будь ласка, синхронізуйте це тут, інакше автоматизація (наприклад, резервне копіювання) не працюватиме."
                    canGate="update" :canResource="$database" />
                <x-forms.input label="Початкова база даних" id="mongoInitdbDatabase"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я користувача." readonly
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
        @else
            <div class="flex xl:flex-row flex-col gap-2 pb-2">
                <x-forms.input required label="Ім'я користувача" id="mongoInitdbRootUsername"
                    placeholder="Якщо порожньо: postgres" canGate="update" :canResource="$database" />
                <x-forms.input label="Пароль" id="mongoInitdbRootPassword" type="password" required
                    canGate="update" :canResource="$database" />
                <x-forms.input required label="База даних" id="mongoInitdbDatabase"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я користувача." canGate="update" :canResource="$database" />
            </div>
        @endif
        <x-forms.input
            helper="Ви можете додати власні параметри запуску Docker, які будуть використані при запуску вашого контейнера.<br>Примітка: Не всі параметри підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити поганий досвід для користувачів."
            placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
            id="customDockerRunOptions" label="Власні параметри Docker" canGate="update" :canResource="$database" />
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Мапування портів"
                    helper="Список портів, розділений комами, які ви бажаєте відобразити до хост-системи.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433"
                    canGate="update" :canResource="$database" />
            </div>
            <x-forms.input label="URL MongoDB (внутрішній)"
                helper="Якщо ви зміните користувача/пароль/порт, це може відрізнятися. Це значення за замовчуванням."
                type="password" readonly wire:model="db_url" canGate="update" :canResource="$database" />
            @if ($db_url_public)
                <x-forms.input label="URL MongoDB (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може відрізнятися. Це значення за замовчуванням."
                    type="password" readonly wire:model="db_url_public" canGate="update" :canResource="$database" />
            @endif
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center justify-between w-full">
                    <h3>Конфігурація SSL</h3>
                    @if ($enableSsl)
                        <x-modal-confirmation title="Повторно згенерувати SSL-сертифікати"
                            buttonTitle="Повторно згенерувати SSL-сертифікати" :actions="[
                                'SSL-сертифікат цієї бази даних буде повторно згенеровано.',
                                'Ви повинні перезапустити базу даних після повторної генерації сертифіката, щоб почати використовувати новий сертифікат.',
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
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex flex-col gap-2">
                <div class="w-64">
                    @if (str($database->status)->contains('exited'))
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" canGate="update"
                            :canResource="$database" />
                    @else
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" disabled
                            helper="База даних має бути зупинена, щоб змінити ці налаштування." canGate="update"
                            :canResource="$database" />
                    @endif
                </div>
                @if ($enableSsl)
                    <div class="mx-2">
                        @if (str($database->status)->contains('exited'))
                            <x-forms.select id="sslMode" label="Режим SSL" wire:model.live="sslMode"
                                instantSave="instantSaveSSL"
                                helper="Виберіть режим перевірки SSL для підключень MongoDB" canGate="update"
                                :canResource="$database">
                                <option value="allow" title="Дозволити незахищені з'єднання">allow (незахищений)</option>
                                <option value="prefer" title="Віддавати перевагу захищеним з'єднанням">prefer (захищений)</option>
                                <option value="require" title="Вимагати захищених з'єднань">require (захищений)</option>
                                <option value="verify-full" title="Перевірити повний сертифікат">verify-full (захищений)
                                </option>
                            </x-forms.select>
                        @else
                            <x-forms.select id="sslMode" label="Режим SSL" instantSave="instantSaveSSL"
                                disabled helper="База даних має бути зупинена, щоб змінити ці налаштування." canGate="update"
                                :canResource="$database">
                                <option value="allow" title="Дозволити незахищені з'єднання">allow (незахищений)</option>
                                <option value="prefer" title="Віддавати перевагу захищеним з'єднанням">prefer (захищений)</option>
                                <option value="require" title="Вимагати захищених з'єднань">require (захищений)</option>
                                <option value="verify-full" title="Перевірити повний сертифікат">verify-full (захищений)
                                </option>
                            </x-forms.select>
                        @endif
                    </div>
                @endif
            </div>

            <div>
                <div class="flex flex-col py-2 w-64">
                    <div class="flex items-center gap-2 pb-2">
                        <div class="flex items-center">
                            <h3>Проксі</h3>
                            <x-loading wire:loading wire:target="instantSave" />
                        </div>
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
                    <x-forms.checkbox instantSave id="isPublic" label="Зробити загальнодоступним"
                        canGate="update" :canResource="$database" />
                </div>
                <x-forms.input placeholder="5432" disabled="{{ $isPublic }}"
                    id="publicPort" label="Публічний порт" canGate="update" :canResource="$database" />
            </div>
            <x-forms.textarea label="Власна конфігурація MongoDB" rows="10" id="mongoConf"
                canGate="update" :canResource="$database" />
            <h3 class="pt-4">Додатково</h3>
            <div class="flex flex-col">
                <x-forms.checkbox helper="Відправляти логи до налаштованої кінцевої точки зливу логів у налаштуваннях вашого сервера."
                    instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Злив логів"
                    canGate="update" :canResource="$database" />
            </div>
        </div>
    </form>
</div>