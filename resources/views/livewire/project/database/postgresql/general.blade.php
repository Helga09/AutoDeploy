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
    </form>

    <div class="flex flex-col gap-4 pt-4">

    </div>
</div>