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
                helper="Щоб переглянути всі доступні образи, перевірте тут:<br><br><a target='_blank' href=https://hub.docker.com/r/eqalpha/keydb'>https://hub.docker.com/r/eqalpha/keydb</a>" />
        </div>

        @if ($database->started_at)
            <div class="flex gap-2">
                <x-forms.input label="Початковий пароль" id="keydbPassword" type="password" required readonly
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
        @else
            <div class=" dark:text-warning">Будь ласка, перевірте ці значення. Ви можете змінити їх лише до початкового
                запуску. Після цього вам потрібно буде змінити їх у базі даних.
            </div>
            <div class="flex gap-2">
                <x-forms.input label="Пароль" id="keydbPassword" type="password" required canGate="update"
                    :canResource="$database" />
            </div>
        @endif
        <x-forms.input
            helper="Ви можете додати власні параметри запуску Docker, які будуть використовуватися при запуску вашого контейнера.<br>Примітка: Не всі параметри підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити поганий досвід для користувачів."
            placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
            id="customDockerRunOptions" label="Користувацькі налаштування Docker" canGate="update" :canResource="$database" />
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Мапування портів"
                    helper="Список портів, розділених комою, які ви бажаєте зіставити з хост-системою.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433"
                    canGate="update" :canResource="$database" />
            </div>
            <x-forms.input label="URL KeyDB (внутрішній)"
                helper="Якщо ви зміните користувача/пароль/порт, це може бути іншим. Це зі значеннями за замовчуванням."
                type="password" readonly wire:model="dbUrl" canGate="update" :canResource="$database" />
            @if ($dbUrlPublic)
                <x-forms.input label="URL KeyDB (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може бути іншим. Це зі значеннями за замовчуванням."
                    type="password" readonly wire:model="dbUrlPublic" canGate="update" :canResource="$database" />
            @else
                <x-forms.input label="URL KeyDB (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може бути іншим. Це зі значеннями за замовчуванням."
                    readonly value="Запуск бази даних згенерує це." canGate="update" :canResource="$database" />
            @endif
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center justify-between w-full">
                    <h3>Конфігурація SSL</h3>
                    @if ($database->enable_ssl && $certificateValidUntil)
                        <x-modal-confirmation title="Відновити SSL-сертифікати"
                            buttonTitle="Відновити SSL-сертифікати" :actions="[
                                'SSL-сертифікат цієї бази даних буде перегенерований.',
                                'Ви повинні перезапустити базу даних після перегенерації сертифіката, щоб почати використовувати новий сертифікат.',
                            ]"
                            submitAction="regenerateSslCertificate" :confirmWithText="false" :confirmWithPassword="false" />
                    @endif
                </div>
            </div>
            @if ($database->enable_ssl && $certificateValidUntil)
                <span class="text-sm">Термін дії до:
                    @if (now()->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Закінчився</span>
                    @elseif(now()->addDays(30)->gt($certificateValidUntil))
                        <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} - Незабаром закінчується
                            soon</span>
                    @else
                        <span>{{ $certificateValidUntil->format('d.m.Y H:i:s') }}</span>
                    @endif
                </span>
            @endif
            <div class="flex flex-col gap-2">
                <div class="w-64">
                    @if (str($database->status)->contains('exited'))
                        <x-forms.checkbox id="enable_ssl" label="Увімкнути SSL" wire:model.live="enable_ssl"
                            instantSave="instantSaveSSL" canGate="update" :canResource="$database" />
                    @else
                        <x-forms.checkbox id="enable_ssl" label="Увімкнути SSL" wire:model.live="enable_ssl"
                            instantSave="instantSaveSSL" disabled
                            helper="База даних має бути зупинена, щоб змінити ці налаштування." canGate="update"
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
                <x-forms.checkbox instantSave id="isPublic" label="Зробити загальнодоступним" canGate="update"
                    :canResource="$database" />
            </div>
            <x-forms.input placeholder="5432" disabled="{{ $isPublic }}" id="publicPort" label="Публічний порт"
                canGate="update" :canResource="$database" />
        </div>
        <x-forms.textarea
            helper="<a target='_blank' class='underline dark:text-white' href='https://raw.githubusercontent.com/Snapchat/KeyDB/unstable/keydb.conf'>Конфігурація KeyDB за замовчуванням</a>"
            label="Користувацька конфігурація KeyDB" rows="10" id="keydbConf" canGate="update" :canResource="$database" />
    </form>
    <h3 class="pt-4">Додатково</h3>
    <div class="w-64">
        <x-forms.checkbox helper="Зливайте журнали до налаштованої кінцевої точки зливу журналів у налаштуваннях вашого сервера."
            instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Злив журналів" canGate="update"
            :canResource="$database" />
    </div>
</div>