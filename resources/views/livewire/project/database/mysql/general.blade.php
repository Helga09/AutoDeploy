<div>
    <form wire:submit="submit" class="flex flex-col gap-2">
        <div class="flex items-center gap-2">
            <h2>Загальне</h2>
            <x-forms.button type="submit">
                Зберегти
            </x-forms.button>
        </div>
        <div class="flex gap-2">
            <x-forms.input label="Назва" id="name" canGate="update" :canResource="$database" />
            <x-forms.input label="Опис" id="description" canGate="update" :canResource="$database" />
            <x-forms.input label="Образ" id="image" required
                helper="Щоб переглянути всі доступні образи, перевірте тут:<br><br><a target='_blank' href='https://hub.docker.com/_/mysql'>https://hub.docker.com/_/mysql</a>" canGate="update" :canResource="$database" />
        </div>
        <div class="pt-2 dark:text-warning">Якщо ви зміните значення в базі даних, будь ласка, синхронізуйте їх тут, інакше
            автоматизації (наприклад, резервні копії) не працюватимуть.
        </div>
        @if ($database->started_at)
            <div class="flex xl:flex-row flex-col gap-2">
                <x-forms.input label="Пароль Root" id="mysqlRootPassword" type="password" required
                    helper="Якщо ви зміните це в базі даних, будь ласка, синхронізуйте це тут, інакше автоматизації (наприклад, резервні копії) не працюватимуть." canGate="update" :canResource="$database" />
                <x-forms.input label="Звичайний Користувач" id="mysqlUser" required
                    helper="Якщо ви зміните це в базі даних, будь ласка, синхронізуйте це тут, інакше автоматизації (наприклад, резервні копії) не працюватимуть." canGate="update" :canResource="$database" />
                <x-forms.input label="Пароль Звичайного Користувача" id="mysqlPassword" type="password" required
                    helper="Якщо ви зміните це в базі даних, будь ласка, синхронізуйте це тут, інакше автоматизації (наприклад, резервні копії) не працюватимуть." canGate="update" :canResource="$database" />
            </div>
            <div class="flex flex-col gap-2">
                <x-forms.input label="Початкова База Даних" id="mysqlDatabase"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я Користувача." readonly
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
        @else
            <div class="flex xl:flex-row flex-col gap-4 pb-2">
                <x-forms.input label="Пароль Root" id="mysqlRootPassword" type="password"
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
                <x-forms.input label="Звичайний Користувач" id="mysqlUser" required
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
                <x-forms.input label="Пароль Звичайного Користувача" id="mysqlPassword" type="password" required
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
            <div class="flex flex-col gap-2">
                <x-forms.input label="Початкова База Даних" id="mysqlDatabase"
                    placeholder="Якщо порожньо, буде таким же, як Ім'я Користувача."
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
        @endif
        <div class="pt-2">
            <x-forms.input
                helper="Ви можете додати власні параметри запуску Docker, які будуть використовуватися при старті вашого контейнера.<br>Примітка: Не всі параметри підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити поганий досвід для користувачів.<br><br>Перегляньте <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/docker/custom-commands'>документацію.</a>"
                placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
                id="customDockerRunOptions" label="Власні Опції Docker" canGate="update" :canResource="$database" />
        </div>
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Мапування Портів"
                    helper="Список портів, розділених комами, які ви хочете зіставити з хост-системою.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433" canGate="update" :canResource="$database" />
            </div>
            <x-forms.input label="MySQL URL (внутрішній)"
                helper="Якщо ви зміните користувача/пароль/порт, це може бути іншим. Це зі значеннями за замовчуванням."
                type="password" readonly wire:model="db_url" />
            @if ($db_url_public)
                <x-forms.input label="MySQL URL (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може бути іншим. Це зі значеннями за замовчуванням."
                    type="password" readonly wire:model="db_url_public" />
            @endif
        </div>

        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center justify-between w-full">
                    <h3>Конфігурація SSL</h3>
                    @if ($enableSsl && $certificateValidUntil)
                        <x-modal-confirmation title="Відновити SSL-сертифікати"
                            buttonTitle="Відновити SSL-сертифікати" :actions="[
                                'SSL-сертифікат цієї бази даних буде відновлено.',
                                'Ви повинні перезапустити базу даних після відновлення сертифіката, щоб почати використовувати новий сертифікат.',
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
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" canGate="update" :canResource="$database" />
                    @else
                        <x-forms.checkbox id="enableSsl" label="Увімкнути SSL"
                            wire:model.live="enableSsl" instantSave="instantSaveSSL" disabled
                            helper="База даних повинна бути зупинена, щоб змінити ці налаштування." />
                    @endif
                </div>
                @if ($enableSsl)
                    <div class="mx-2">
                        @if (str($database->status)->contains('exited'))
                            <x-forms.select id="sslMode" label="Режим SSL" wire:model.live="sslMode"
                                instantSave="instantSaveSSL"
                                helper="Оберіть режим перевірки SSL для з'єднань MySQL" canGate="update" :canResource="$database">
                                <option value="PREFERRED" title="Бажано безпечні з'єднання">Бажано (безпечно)</option>
                                <option value="REQUIRED" title="Вимагати безпечні з'єднання">Вимагати (безпечно)</option>
                                <option value="VERIFY_CA" title="Перевірити CA-сертифікат">Перевірити CA (безпечно)</option>
                                <option value="VERIFY_IDENTITY" title="Перевірити повний сертифікат">Перевірити Повний (безпечно)
                                </option>
                            </x-forms.select>
                        @else
                            <x-forms.select id="sslMode" label="Режим SSL" instantSave="instantSaveSSL"
                                disabled helper="База даних повинна бути зупинена, щоб змінити ці налаштування.">
                                <option value="PREFERRED" title="Бажано безпечні з'єднання">Бажано (безпечно)</option>
                                <option value="REQUIRED" title="Вимагати безпечні з'єднання">Вимагати (безпечно)</option>
                                <option value="VERIFY_CA" title="Перевірити CA-сертифікат">Перевірити CA (безпечно)</option>
                                <option value="VERIFY_IDENTITY" title="Перевірити повний сертифікат">Перевірити Повний (безпечно)
                                </option>
                            </x-forms.select>
                        @endif
                    </div>
                @endif
            </div>
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
                            <x-slot:title>Журнали Проксі</x-slot:title>
                            <x-slot:content>
                                <livewire:project.shared.get-logs :server="$server" :resource="$database"
                                    container="{{ data_get($database, 'uuid') }}-proxy" lazy />
                            </x-slot:content>
                            <x-forms.button disabled="{{ !data_get($database, 'is_public') }}"
                                @click="slideOverOpen=true">Журнали</x-forms.button>
                        </x-slide-over>
                    @endif
                </div>
                <x-forms.checkbox instantSave id="isPublic" label="Зробити публічно доступним" canGate="update" :canResource="$database" />
            </div>
            <x-forms.input placeholder="5432" disabled="{{ $isPublic }}"
                id="publicPort" label="Публічний Порт" canGate="update" :canResource="$database" />
        </div>
        <x-forms.textarea label="Власна Конфігурація MySQL" rows="10" id="mysqlConf" canGate="update" :canResource="$database" />
        <h3 class="pt-4">Додатково</h3>
        <div class="flex flex-col">
            <x-forms.checkbox helper="Відправляти журнали на налаштовану кінцеву точку для зливу журналів у ваших налаштуваннях сервера."
                instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Відправляти Журнали" canGate="update" :canResource="$database" />
        </div>
    </form>
</div>