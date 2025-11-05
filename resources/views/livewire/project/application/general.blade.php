<div x-data="{
    initLoadingCompose: $wire.entangle('initLoadingCompose'),
    canUpdate: @js(auth()->user()->can('update', $application)),
    shouldDisable() {
        return this.initLoadingCompose || !this.canUpdate;
    }
}">
    <form wire:submit='submit' class="flex flex-col pb-32">
        <div class="flex items-center gap-2">
            <h2>Загальні налаштування</h2>
            @if (isDev())
                <div>{{ $application->compose_parsing_version }}</div>
            @endif
            <x-forms.button canGate="update" :canResource="$application" type="submit">Зберегти</x-forms.button>
        </div>
        <div>Загальна конфігурація для вашої програми.</div>
        <div class="flex flex-col gap-2 py-4">
            <div class="flex flex-col items-end gap-2 xl:flex-row">
                <x-forms.input x-bind:disabled="shouldDisable()" id="name" label="Назва" required />
                <x-forms.input x-bind:disabled="shouldDisable()" id="description" label="Опис" />
            </div>

            @if (!$application->dockerfile && $application->build_pack !== 'dockerimage')
                <div class="flex flex-col gap-2">
                    <div class="flex gap-2">
                        <x-forms.select x-bind:disabled="shouldDisable()" wire:model.live="build_pack"
                            label="Пакет збірки" required>
                            <option value="nixpacks">Nixpacks</option>
                            <option value="static">Static</option>
                            <option value="dockerfile">Dockerfile</option>
                            <option value="dockercompose">Docker Compose</option>
                        </x-forms.select>
                        @if ($application->settings->is_static || $application->build_pack === 'static')
                            <x-forms.select x-bind:disabled="!canUpdate" id="static_image"
                                label="Статичний образ" required>
                                <option value="nginx:alpine">nginx:alpine</option>
                                <option disabled value="apache:alpine">apache:alpine</option>
                            </x-forms.select>
                        @endif
                    </div>

                    @if ($application->build_pack === 'dockercompose')
                        @if (
                            !is_null($parsedServices) &&
                                count($parsedServices) > 0 &&
                                !$application->settings->is_raw_compose_deployment_enabled)
                            <h3 class="pt-6">Домени</h3>
                            @foreach (data_get($parsedServices, 'services') as $serviceName => $service)
                                @if (!isDatabaseImage(data_get($service, 'image')))
                                    <div class="flex items-end gap-2">
                                        <x-forms.input
                                            helper="Ви можете вказати один домен зі шляхом або кілька через кому. Ви можете вказати порт, до якого буде прив'язано домен.<br><br><span class='text-helper'>Приклад</span><br>- http://app.AutoDeploy.io,https://cloud.AutoDeploy.io/dashboard<br>- http://app.AutoDeploy.io/api/v3<br>- http://app.AutoDeploy.io:3000 -> app.AutoDeploy.io буде вказувати на порт 3000 всередині контейнера. "
                                            label="Домени для {{ $serviceName }}"
                                            id="parsedServiceDomains.{{ str($serviceName)->replace('-', '_')->replace('.', '_') }}.domain"
                                            x-bind:disabled="shouldDisable()"></x-forms.input>
                                        @can('update', $application)
                                            <x-forms.button wire:click="generateDomain('{{ $serviceName }}')">Згенерувати домен
                                            </x-forms.button>
                                        @endcan
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    @endif

                </div>
            @endif
            @if ($application->settings->is_static || $application->build_pack === 'static')
                <x-forms.textarea id="custom_nginx_configuration"
                    placeholder="Порожнє значення означає використання конфігурації за замовчуванням." label="Власна конфігурація Nginx"
                    helper="Тут ви можете додати власну конфігурацію Nginx." x-bind:disabled="!canUpdate" />
                @can('update', $application)
                    <x-forms.button wire:click="generateNginxConfiguration">
                        Згенерувати конфігурацію Nginx за замовчуванням
                    </x-forms.button>
                @endcan
            @endif
            <div class="w-96 pb-6">
                @if ($application->could_set_build_commands())
                    <x-forms.checkbox instantSave id="is_static" label="Це статичний сайт?"
                        helper="Якщо ваша програма є статичним сайтом або кінцеві активи збірки мають подаватися як статичний сайт, увімкніть це."
                        x-bind:disabled="!canUpdate" />
                @endif
                @if ($application->settings->is_static && $application->build_pack !== 'static')
                    <x-forms.checkbox label="Це SPA (Single Page Application)?"
                        helper="Якщо ваша програма є SPA, увімкніть це." id="is_spa" instantSave
                        x-bind:disabled="!canUpdate"></x-forms.checkbox>
                @endif
            </div>
            @if ($application->build_pack !== 'dockercompose')
                <div class="flex items-end gap-2">
                    @if ($application->settings->is_container_label_readonly_enabled == false)
                        <x-forms.input placeholder="https://AutoDeploy.io" wire:model="fqdn"
                            label="Домени" readonly
                            helper="Мітки тільки для читання вимкнено. Ви можете встановити домени в розділі міток."
                            x-bind:disabled="!canUpdate" />
                    @else
                        <x-forms.input placeholder="https://AutoDeploy.io" wire:model="fqdn"
                            label="Домени"
                            helper="Ви можете вказати один домен зі шляхом або кілька через кому. Ви можете вказати порт, до якого буде прив'язано домен.<br><br><span class='text-helper'>Приклад</span><br>- http://app.AutoDeploy.io,https://cloud.AutoDeploy.io/dashboard<br>- http://app.AutoDeploy.io/api/v3<br>- http://app.AutoDeploy.io:3000 -> app.AutoDeploy.io буде вказувати на порт 3000 всередині контейнера. "
                            x-bind:disabled="!canUpdate" />
                        @can('update', $application)
                            <x-forms.button wire:click="getWildcardDomain">Згенерувати домен
                            </x-forms.button>
                        @endcan
                    @endif
                </div>
                <div class="flex items-end gap-2">
                    @if ($application->settings->is_container_label_readonly_enabled == false)
                        @if ($application->redirect === 'both')
                            <x-forms.input label="Напрямок" value="Дозволити www та без-www." readonly
                                helper="Мітки тільки для читання вимкнено. Ви можете встановити напрямок у розділі міток."
                                x-bind:disabled="!canUpdate" />
                        @elseif ($application->redirect === 'www')
                            <x-forms.input label="Напрямок" value="Перенаправляти на www." readonly
                                helper="Мітки тільки для читання вимкнено. Ви можете встановити напрямок у розділі міток."
                                x-bind:disabled="!canUpdate" />
                        @elseif ($application->redirect === 'non-www')
                            <x-forms.input label="Напрямок" value="Перенаправляти на без-www." readonly
                                helper="Мітки тільки для читання вимкнено. Ви можете встановити напрямок у розділі міток."
                                x-bind:disabled="!canUpdate" />
                        @endif
                    @else
                        <x-forms.select label="Напрямок" id="redirect" required
                            helper="Вам необхідно додати www та без-www як записи A DNS. Переконайтеся, що домен www додано в розділі 'Домени'."
                            x-bind:disabled="!canUpdate">
                            <option value="both">Дозволити www та без-www.</option>
                            <option value="www">Перенаправляти на www.</option>
                            <option value="non-www">Перенаправляти на без-www.</option>
                        </x-forms.select>
                        @if ($application->settings->is_container_label_readonly_enabled)
                            @can('update', $application)
                                <x-modal-confirmation title="Підтвердити налаштування перенаправлення?" buttonTitle="Встановити напрямок"
                                    submitAction="setRedirect" :actions="['Весь трафік буде перенаправлено до обраного напрямку.']"
                                    confirmationText="{{ $application->fqdn . '/' }}"
                                    confirmationLabel="Будь ласка, підтвердьте виконання дії, ввівши URL програми нижче"
                                    shortConfirmationLabel="URL програми" :confirmWithPassword="false"
                                    step2ButtonText="Встановити напрямок">
                                    <x-slot:customButton>
                                        <div class="w-[7.2rem]">Встановити напрямок</div>
                                    </x-slot:customButton>
                                </x-modal-confirmation>
                            @endcan
                        @endif
                    @endif
                </div>
            @endif

            @if ($application->build_pack !== 'dockercompose')
                <div class="flex items-center gap-2 pt-8">
                    <h3>Реєстр Docker</h3>
                    @if ($application->build_pack !== 'dockerimage' && !$application->destination->server->isSwarm())
                        <x-helper
                            helper="Відправити зібраний образ до реєстру Docker. Додаткова інформація <a class='underline' href='https://AutoDeploy.io/docs/knowledge-base/docker/registry' target='_blank'>тут</a>." />
                    @endif
                </div>
                @if ($application->destination->server->isSwarm())
                    @if ($application->build_pack !== 'dockerimage')
                        <div>Docker Swarm вимагає, щоб образ був доступний у реєстрі. Додаткова інформація <a
                                class="underline" href="https://AutoDeploy.io/docs/knowledge-base/docker/registry"
                                target="_blank">тут</a>.</div>
                    @endif
                @endif
                <div class="flex flex-col gap-2 xl:flex-row">
                    @if ($application->build_pack === 'dockerimage')
                        @if ($application->destination->server->isSwarm())
                            <x-forms.input required id="docker_registry_image_name" label="Образ Docker"
                                x-bind:disabled="!canUpdate" />
                            <x-forms.input id="docker_registry_image_tag" label="Тег або хеш образу Docker"
                                helper="Введіть тег (наприклад, 'latest', 'v1.2.3') або хеш SHA256 (наприклад, 'sha256-59e02939b1bf39f16c93138a28727aec520bb916da021180ae502c61626b3cf0')"
                                x-bind:disabled="!canUpdate" />
                        @else
                            <x-forms.input id="docker_registry_image_name" label="Образ Docker"
                                x-bind:disabled="!canUpdate" />
                            <x-forms.input id="docker_registry_image_tag" label="Тег або хеш образу Docker"
                                helper="Введіть тег (наприклад, 'latest', 'v1.2.3') або хеш SHA256 (наприклад, 'sha256-59e02939b1bf39f16c93138a28727aec520bb916da021180ae502c61626b3cf0')"
                                x-bind:disabled="!canUpdate" />
                        @endif
                    @else
                        @if (
                            $application->destination->server->isSwarm() ||
                                $application->additional_servers->count() > 0 ||
                                $application->settings->is_build_server_enabled)
                            <x-forms.input id="docker_registry_image_name" required label="Образ Docker"
                                placeholder="Обов'язково!" x-bind:disabled="!canUpdate" />
                            <x-forms.input id="docker_registry_image_tag"
                                helper="Якщо встановлено, він також позначить зібраний образ цим тегом. <br><br>Приклад: Якщо ви встановите 'latest', образ буде відправлено з тегом коміту sha + з тегом latest."
                                placeholder="Порожнє значення означає використання 'latest'." label="Тег образу Docker"
                                x-bind:disabled="!canUpdate" />
                        @else
                            <x-forms.input id="docker_registry_image_name"
                                helper="Порожнє значення означає, що образ не буде відправлено до реєстру Docker. Попередньо позначте образ URL-адресою вашого реєстру, якщо ви хочете відправити його до приватного реєстру (за замовчуванням: Dockerhub). <br><br>Приклад: ghcr.io/myimage"
                                placeholder="Порожнє значення означає, що образ не буде відправлено до реєстру Docker."
                                label="Образ Docker" x-bind:disabled="!canUpdate" />
                            <x-forms.input id="docker_registry_image_tag"
                                placeholder="Порожнє значення означає відправку лише тегу sha коміту."
                                helper="Якщо встановлено, він також позначить зібраний образ цим тегом. <br><br>Приклад: Якщо ви встановите 'latest', образ буде відправлено з тегом коміту sha + з тегом latest."
                                label="Тег образу Docker" x-bind:disabled="!canUpdate" />
                        @endif
                    @endif
                </div>
            @endif
            <div>
                <h3>Збірка</h3>
                @if ($application->build_pack === 'dockerimage')
                    <x-forms.input
                        helper="Ви можете додати власні опції запуску Docker, які будуть використані при запуску вашого контейнера.<br>Примітка: Не всі опції підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити неприємності для користувачів.<br><br>Перегляньте <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/docker/custom-commands'>документацію.</a>"
                        placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k --hostname=myapp"
                        id="custom_docker_run_options" label="Власні опції Docker"
                        x-bind:disabled="!canUpdate" />
                @else
                    @if ($application->could_set_build_commands())
                        @if ($application->build_pack === 'nixpacks')
                            <div class="flex flex-col gap-2 xl:flex-row">
                                <x-forms.input helper="Якщо ви це зміните, вам, ймовірно, знадобиться файл nixpacks.toml"
                                    id="install_command" label="Команда встановлення"
                                    x-bind:disabled="!canUpdate" />
                                <x-forms.input helper="Якщо ви це зміните, вам, ймовірно, знадобиться файл nixpacks.toml"
                                    id="build_command" label="Команда збірки"
                                    x-bind:disabled="!canUpdate" />
                                <x-forms.input helper="Якщо ви це зміните, вам, ймовірно, знадобиться файл nixpacks.toml"
                                    id="start_command" label="Команда запуску"
                                    x-bind:disabled="!canUpdate" />
                            </div>
                            <div class="pt-1 text-xs">Nixpacks автоматично виявить необхідну конфігурацію.
                                <a class="underline" href="https://AutoDeploy.io/docs/applications/">Документація по фреймворках</a>
                            </div>
                        @endif

                    @endif
                    <div class="flex flex-col gap-2 pt-6 pb-0">
                        @if ($application->build_pack === 'dockercompose')
                            @can('update', $application)
                                <div class="flex flex-col gap-2" x-init="$wire.dispatch('loadCompose', true)">
                                @else
                                    <div class="flex flex-col gap-2">
                                    @endcan
                                    <div class="flex gap-2">
                                        <x-forms.input x-bind:disabled="shouldDisable()" placeholder="/"
                                            id="base_directory" label="Базовий каталог"
                                            helper="Каталог, який використовуватиметься як кореневий. Корисно для монорепозиторіїв." />
                                        <x-forms.input x-bind:disabled="shouldDisable()"
                                            placeholder="/docker-compose.yaml"
                                            id="docker_compose_location" label="Розташування Docker Compose"
                                            helper="Обчислюється разом з базовим каталогом:<br><span class='dark:text-warning'>{{ Str::start($application->base_directory . $application->docker_compose_location, '/') }}</span>" />
                                    </div>
                                    <div class="w-96">
                                        <x-forms.checkbox instantSave
                                            id="is_preserve_repository_enabled"
                                            label="Зберігати репозиторій під час розгортання"
                                            helper="Репозиторій Git (на основі налаштувань базового каталогу) буде скопійовано до каталогу розгортання."
                                            x-bind:disabled="shouldDisable()" />
                                    </div>
                                    <div class="pt-4">Наступні команди призначені для просунутих випадків використання.
                                        Змінюйте їх, лише якщо ви
                                        знаєте, що
                                        робите.</div>
                                    <div class="flex gap-2">
                                        <x-forms.input x-bind:disabled="shouldDisable()"
                                            placeholder="docker compose build"
                                            id="docker_compose_custom_build_command"
                                            helper="Якщо ви використовуєте це, вам потрібно вказати шляхи відносно та використовувати той самий файл compose у власній команді, інакше автоматично налаштовані мітки тощо не працюватимуть.<br><br>У вашому випадку використовуйте: <span class='dark:text-warning'>docker compose -f .{{ Str::start($application->base_directory . $application->docker_compose_location, '/') }} build</span>"
                                            label="Власна команда збірки" />
                                        <x-forms.input x-bind:disabled="shouldDisable()"
                                            placeholder="docker compose up -d"
                                            id="docker_compose_custom_start_command"
                                            helper="Якщо ви використовуєте це, вам потрібно вказати шляхи відносно та використовувати той самий файл compose у власній команді, інакше автоматично налаштовані мітки тощо не працюватимуть.<br><br>У вашому випадку використовуйте: <span class='dark:text-warning'>docker compose -f .{{ Str::start($application->base_directory . $application->docker_compose_location, '/') }} up -d</span>"
                                            label="Власна команда запуску" />
                                    </div>
                                    @if ($this->application->is_github_based() && !$this->application->is_public_repository())
                                        <div class="pt-4">
                                            <x-forms.textarea
                                                helper="Пошук за шаблоном на основі порядку для фільтрації розгортань Git webhook. Підтримує символи-замінники (*, **, ?) та заперечення (!). Перемагає останній відповідний шаблон."
                                                placeholder="services/api/**" id="watch_paths"
                                                label="Шляхи для спостереження" x-bind:disabled="shouldDisable()" />
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="flex flex-col gap-2 xl:flex-row">
                                    <x-forms.input placeholder="/" id="base_directory"
                                        label="Базовий каталог"
                                        helper="Каталог, який використовуватиметься як кореневий. Корисно для монорепозиторіїв."
                                        x-bind:disabled="!canUpdate" />
                                    @if ($application->build_pack === 'dockerfile' && !$application->dockerfile)
                                        <x-forms.input placeholder="/Dockerfile" id="dockerfile_location"
                                            label="Розташування Dockerfile"
                                            helper="Обчислюється разом з базовим каталогом:<br><span class='dark:text-warning'>{{ Str::start($application->base_directory . $application->dockerfile_location, '/') }}</span>"
                                            x-bind:disabled="!canUpdate" />
                                    @endif

                                    @if ($application->build_pack === 'dockerfile')
                                        <x-forms.input id="dockerfile_target_build"
                                            label="Цільова стадія збірки Docker"
                                            helper="Корисно, якщо у вас багатостадійний Dockerfile."
                                            x-bind:disabled="!canUpdate" />
                                    @endif
                                    @if ($application->could_set_build_commands())
                                        @if ($application->settings->is_static)
                                            <x-forms.input placeholder="/dist" id="publish_directory"
                                                label="Каталог публікації" required x-bind:disabled="!canUpdate" />
                                        @else
                                            <x-forms.input placeholder="/" id="publish_directory"
                                                label="Каталог публікації" x-bind:disabled="!canUpdate" />
                                        @endif
                                    @endif

                                </div>
                                @if ($this->application->is_github_based() && !$this->application->is_public_repository())
                                    <div class="pb-4">
                                        <x-forms.textarea
                                            helper="Пошук за шаблоном на основі порядку для фільтрації розгортань Git webhook. Підтримує символи-замінники (*, **, ?) та заперечення (!). Перемагає останній відповідний шаблон."
                                            placeholder="src/pages/**" id="watch_paths"
                                            label="Шляхи для спостереження" x-bind:disabled="!canUpdate" />
                                    </div>
                                @endif
                                <x-forms.input
                                    helper="Ви можете додати власні опції запуску Docker, які будуть використані при запуску вашого контейнера.<br>Примітка: Не всі опції підтримуються, оскільки вони можуть порушити автоматизацію AutoDeploy та спричинити неприємності для користувачів.<br><br>Перегляньте <a class='underline dark:text-white' href='https://AutoDeploy.io/docs/knowledge-base/docker/custom-commands'>документацію.</a>"
                                    placeholder="--cap-add SYS_ADMIN --device=/dev/fuse --security-opt apparmor:unconfined --ulimit nofile=1024:1024 --tmpfs /run:rw,noexec,nosuid,size=65536k --hostname=myapp"
                                    id="custom_docker_run_options" label="Власні опції Docker"
                                    x-bind:disabled="!canUpdate" />

                                @if ($application->build_pack !== 'dockercompose')
                                    <div class="pt-2 w-96">
                                        <x-forms.checkbox
                                            helper="Використовуйте сервер збірки для створення вашої програми. Ви можете налаштувати сервер збірки в налаштуваннях сервера. Для отримання додаткової інформації перегляньте <a href='https://AutoDeploy.io/docs/knowledge-base/server/build-server' class='underline' target='_blank'>документацію</a>."
                                            instantSave id="is_build_server_enabled"
                                            label="Використовувати сервер збірки?" x-bind:disabled="!canUpdate" />
                                    </div>
                                @endif
                        @endif
                    </div>
                @endif
            </div>
            @if ($application->build_pack === 'dockercompose')
                <div class="flex items-center gap-2 pb-4">
                    <h3>Docker Compose</h3>
                    @can('update', $application)
                        <x-forms.button wire:target='initLoadingCompose'
                            x-on:click="$wire.dispatch('loadCompose', false)">Перезавантажити файл Compose</x-forms.button>
                    @endcan
                </div>
                @if ($application->settings->is_raw_compose_deployment_enabled)
                    <x-forms.textarea rows="10" readonly id="docker_compose_raw"
                        label="Вміст Docker Compose (applicationId: {{ $application->id }})"
                        helper="Вам потрібно змінити файл docker compose у репозиторії Git."
                        monacoEditorLanguage="yaml" useMonacoEditor />
                @else
                    @if ((int) $application->compose_parsing_version >= 3)
                        <x-forms.textarea rows="10" readonly id="docker_compose_raw"
                            label="Вміст Docker Compose (сирий)"
                            helper="Вам потрібно змінити файл docker compose у репозиторії Git."
                            monacoEditorLanguage="yaml" useMonacoEditor />
                    @endif
                    <x-forms.textarea rows="10" readonly id="docker_compose"
                        label="Вміст Docker Compose"
                        helper="Вам потрібно змінити файл docker compose у репозиторії Git."
                        monacoEditorLanguage="yaml" useMonacoEditor />
                @endif
                <div class="w-96">
                    <x-forms.checkbox label="Екранувати спеціальні символи в мітках?"
                        helper="За замовчуванням, $ (та інші символи) екрануються. Тому, якщо ви напишете $ у мітках, воно буде збережено як $$.<br><br>Якщо ви хочете використовувати змінні середовища всередині міток, вимкніть цю опцію."
                        id="is_container_label_escape_enabled" instantSave
                        x-bind:disabled="!canUpdate"></x-forms.checkbox>
                    {{-- <x-forms.checkbox label="Readonly labels"
                        helper="Labels are readonly by default. Readonly means that edits you do to the labels could be lost and AutoDeploy will autogenerate the labels for you. If you want to edit the labels directly, disable this option. <br><br>Be careful, it could break the proxy configuration after you restart the container as AutoDeploy will now NOT autogenerate the labels for you (ofc you can always reset the labels to the AutoDeploy defaults manually)."
                        id="is_container_label_readonly_enabled" instantSave></x-forms.checkbox> --}}
                </div>
            @endif
            @if ($application->dockerfile)
                <x-forms.textarea label="Dockerfile" id="dockerfile" monacoEditorLanguage="dockerfile"
                    useMonacoEditor rows="6" x-bind:disabled="!canUpdate"> </x-forms.textarea>
            @endif
            @if ($application->build_pack !== 'dockercompose')
                <h3 class="pt-8">Мережа</h3>
                <div class="flex flex-col gap-2 xl:flex-row">
                    @if ($application->settings->is_static || $application->build_pack === 'static')
                        <x-forms.input id="ports_exposes" label="Відкриті порти" readonly
                            x-bind:disabled="!canUpdate" />
                    @else
                        @if ($application->settings->is_container_label_readonly_enabled === false)
                            <x-forms.input placeholder="3000,3001" id="ports_exposes"
                                label="Відкриті порти" readonly
                                helper="Мітки тільки для читання вимкнено. Ви можете встановити порти вручну в розділі міток."
                                x-bind:disabled="!canUpdate" />
                        @else
                            <x-forms.input placeholder="3000,3001" id="ports_exposes"
                                label="Відкриті порти" required
                                helper="Список портів, розділених комою, які використовує ваша програма. Перший порт буде використано як порт для перевірки стану за замовчуванням, якщо нічого не визначено в меню перевірки стану. Обов'язково встановіть це правильно."
                                x-bind:disabled="!canUpdate" />
                        @endif
                    @endif
                    @if (!$application->destination->server->isSwarm())
                        <x-forms.input placeholder="3000:3000" id="ports_mappings" label="Мапування портів"
                            helper="Список портів, розділених комою, які ви хочете мапувати до хост-системи. Корисно, коли ви не хочете використовувати домени.<br><br><span class='inline-block font-bold dark:text-warning'>Приклад:</span><br>3000:3000,3002:3002<br><br>Прокатне оновлення не підтримується, якщо у вас є порт, мапований до хоста."
                            x-bind:disabled="!canUpdate" />
                    @endif
                    @if (!$application->destination->server->isSwarm())
                        <x-forms.input id="custom_network_aliases" label="Мережеві псевдоніми"
                            helper="Список власних мережевих псевдонімів, розділених комою, які ви хочете додати для контейнера в мережі Docker.<br><br><span class='inline-block font-bold dark:text-warning'>Приклад:</span><br>api.internal,api.local"
                            wire:model="custom_network_aliases" x-bind:disabled="!canUpdate" />
                    @endif
                </div>

            @endif

        </div>
    </form>

    <x-domain-conflict-modal :conflicts="$domainConflicts" :showModal="$showDomainConflictModal" confirmAction="confirmDomainUsage" />

    @script
        <script>
            $wire.$on('loadCompose', (isInit = true) => {
                // Only load compose file if user has permission (this event should only be dispatched when authorized)
                $wire.initLoadingCompose = true;
                $wire.loadComposeFile(isInit);
            });
        </script>
    @endscript
</div>