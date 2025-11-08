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
                helper="Для всіх доступних образів перегляньте тут:<br><br><a target='_blank' href='https://hub.docker.com/r/clickhouse/clickhouse-server/'>https://hub.docker.com/r/clickhouse/clickhouse-server/</a>" />
        </div>

        @if ($database->started_at)
            <div class="flex gap-2">
                <x-forms.input label="Початкове ім'я користувача" id="clickhouseAdminUser" placeholder="Якщо порожньо: clickhouse"
                    readonly helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
                <x-forms.input label="Початковий пароль" id="clickhouseAdminPassword" type="password" required readonly
                    helper="Ви можете змінити це лише в базі даних." canGate="update" :canResource="$database" />
            </div>
        @else
            <div class=" dark:text-warning">Будь ласка, перевірте ці значення. Ви можете змінити їх лише до початкового
                запуску. Після цього вам потрібно буде змінити їх у базі даних.
            </div>
            <div class="flex gap-2">
                <x-forms.input label="Ім'я користувача" id="clickhouseAdminUser" required canGate="update" :canResource="$database" />
                <x-forms.input label="Пароль" id="clickhouseAdminPassword" type="password" required canGate="update"
                    :canResource="$database" />
            </div>
        @endif
        <x-forms.input
            helper="Ви можете додати власні опції запуску Docker, які будуть використані при старті вашого контейнера.<br>Примітка: Не всі опції підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити негативний досвід для користувачів."
            placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k"
            id="customDockerRunOptions" label="Власні опції Docker" canGate="update" :canResource="$database" />
        <div class="flex flex-col gap-2">
            <h3 class="py-2">Мережа</h3>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="3000:5432" id="portsMappings" label="Відображення портів"
                    helper="Список портів, розділений комами, які ви хочете відобразити на хост-системі.<br><span class='inline-block font-bold dark:text-warning'>Приклад</span>3000:5432,3002:5433"
                    canGate="update" :canResource="$database" />
            </div>
            <x-forms.input label="URL Clickhouse (внутрішній)"
                helper="Якщо ви зміните користувача/пароль/порт, це може відрізнятися. Це зі значеннями за замовчуванням."
                type="password" readonly wire:model="dbUrl" canGate="update" :canResource="$database" />
            @if ($dbUrlPublic)
                <x-forms.input label="URL Clickhouse (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може відрізнятися. Це зі значеннями за замовчуванням."
                    type="password" readonly wire:model="dbUrlPublic" canGate="update" :canResource="$database" />
            @else
                <x-forms.input label="URL Clickhouse (публічний)"
                    helper="Якщо ви зміните користувача/пароль/порт, це може відрізнятися. Це зі значеннями за замовчуванням."
                    readonly value="Запуск бази даних згенерує це." canGate="update" :canResource="$database" />
            @endif
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
                <x-forms.checkbox instantSave id="isPublic" label="Зробити публічно доступним" canGate="update"
                    :canResource="$database" />
            </div>
            <x-forms.input placeholder="5432" disabled="{{ $isPublic }}" id="publicPort" label="Публічний порт"
                canGate="update" :canResource="$database" />
        </div>
    </form>
    <h3 class="pt-4">Додатково</h3>
    <div class="w-64">
        <x-forms.checkbox helper="Надсилати журнали до налаштованої кінцевої точки для зливу журналів у налаштуваннях вашого сервера."
            instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Злив журналів" canGate="update"
            :canResource="$database" />
    </div>
</div>