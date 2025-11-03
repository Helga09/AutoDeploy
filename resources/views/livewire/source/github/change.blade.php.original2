<div>
    @if (data_get($github_app, 'app_id'))
        <form wire:submit='submit'>
            <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                <h1>Застосунок GitHub</h1>
                <div class="flex gap-2">
                    @if (data_get($github_app, 'installation_id'))
                        <x-forms.button canGate="update" :canResource="$github_app" type="submit">Зберегти</x-forms.button>
                    @endif
                    @can('delete', $github_app)
                        @if ($applications->count() > 0)
                            <x-modal-confirmation title="Підтвердити видалення Застосунку GitHub?" isErrorButton buttonTitle="Видалити"
                                submitAction="delete" :actions="['Вибраний Застосунок GitHub буде остаточно видалено.']" confirmationText="{{ data_get($github_app, 'name') }}"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву Застосунку GitHub нижче"
                                shortConfirmationLabel="Назва Застосунку GitHub" :confirmWithPassword="false"
                                step2ButtonText="Видалити остаточно" />
                        @else
                            <x-modal-confirmation title="Підтвердити видалення Застосунку GitHub?" isErrorButton buttonTitle="Видалити"
                                submitAction="delete" :actions="['Вибраний Застосунок GitHub буде остаточно видалено.']"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву Застосунку GitHub нижче"
                                shortConfirmationLabel="Назва Застосунку GitHub"
                                confirmationText="{{ data_get($github_app, 'name') }}" :confirmWithPassword="false"
                                step2ButtonText="Видалити остаточно" />
                        @endif
                    @endcan
                </div>
            </div>
            <div class="subtitle">Ваш приватний Застосунок GitHub для приватних репозиторіїв.</div>
            @if (!data_get($github_app, 'installation_id'))
                <div class="mb-10 rounded-sm alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Ви повинні виконати цей крок, перш ніж зможете використовувати це джерело!</span>
                </div>
                <a class="items-center justify-center box" href="{{ getInstallationPath($github_app) }}">
                    Встановити репозиторії на GitHub
                </a>
            @else
                <div class="flex flex-col gap-2">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="flex flex-col sm:flex-row items-start sm:items-end gap-2 w-full">
                            <x-forms.input canGate="update" :canResource="$github_app" id="name" label="Назва застосунку" />
                            <x-forms.button canGate="update" :canResource="$github_app" wire:click.prevent="updateGithubAppName">
                                Синхронізувати назву
                            </x-forms.button>
                            @can('update', $github_app)
                                <a href="{{ $this->getGithubAppNameUpdatePath() }}">
                                    <x-forms.button
                                        class="bg-transparent border-transparent hover:bg-transparent hover:border-transparent hover:underline">
                                        Перейменувати
                                        <x-external-link />
                                    </x-forms.button>
                                </a>
                                <a href="{{ getInstallationPath($github_app) }}" class="w-fit">
                                    <x-forms.button
                                        class="bg-transparent border-transparent hover:bg-transparent hover:border-transparent hover:underline whitespace-nowrap">
                                        Оновити репозиторії
                                        <x-external-link />
                                    </x-forms.button>
                                </a>
                            @endcan
                        </div>
                    </div>
                    <x-forms.input canGate="update" :canResource="$github_app" id="organization" label="Організація"
                        placeholder="Якщо поле порожнє, буде використано особистого користувача" />
                    @if (!isCloud())
                        <div class="w-48">
                            <x-forms.checkbox canGate="update" :canResource="$github_app" label="Загальносистемний?"
                                helper="Якщо позначено, цей Застосунок GitHub буде доступний для всіх у цьому екземплярі Coolify."
                                instantSave id="isSystemWide" />
                        </div>
                        @if ($isSystemWide)
                            <x-callout type="warning" title="Не рекомендовано">
                                Загальносистемні Застосунки GitHub є спільними для всіх команд у цьому екземплярі Coolify. Це означає, що будь-яка команда може використовувати цей Застосунок GitHub для розгортання застосунків з ваших репозиторіїв. Для кращої безпеки та ізоляції рекомендується створювати Застосунки GitHub для конкретних команд.
                            </x-callout>
                        @endif
                    @endif
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-forms.input canGate="update" :canResource="$github_app" id="htmlUrl" label="URL HTML" />
                        <x-forms.input canGate="update" :canResource="$github_app" id="apiUrl" label="URL API" />
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-forms.input canGate="update" :canResource="$github_app" id="customUser" label="Користувач"
                            required />
                        <x-forms.input canGate="update" :canResource="$github_app" type="number" id="customPort"
                            label="Порт" required />
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-forms.input canGate="update" :canResource="$github_app" type="number" id="appId"
                            label="ID Застосунку" required />
                        <x-forms.input canGate="update" :canResource="$github_app" type="number"
                            id="installationId" label="ID Інсталяції" required />
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-forms.input canGate="update" :canResource="$github_app" id="clientId" label="ID Клієнта"
                            type="password" required />
                        <x-forms.input canGate="update" :canResource="$github_app" id="clientSecret"
                            label="Секрет Клієнта" type="password" required />
                        <x-forms.input canGate="update" :canResource="$github_app" id="webhookSecret"
                            label="Секрет Вебхука" type="password" required />
                    </div>
                    <div class="flex gap-2">
                        <x-forms.select canGate="update" :canResource="$github_app" id="privateKeyId"
                            label="Приватний ключ" required>
                            @if (blank($github_app->private_key_id))
                                <option value="0" selected>Виберіть приватний ключ</option>
                            @endif
                            @foreach ($privateKeys as $privateKey)
                                <option value="{{ $privateKey->id }}">{{ $privateKey->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div class="flex flex-col sm:flex-row items-start sm:items-end gap-2">
                        <h2 class="pt-4">Дозволи</h2>
                        @can('view', $github_app)
                            <x-forms.button wire:click.prevent="checkPermissions">Оновити</x-forms.button>
                            <a href="{{ getPermissionsPath($github_app) }}">
                                <x-forms.button>
                                    Оновити
                                    <x-external-link />
                                </x-forms.button>
                            </a>
                        @endcan
                    </div>
                    <div class="flex flex-col sm:flex-row gap-2">
                        <x-forms.input id="contents" helper="читання - обов'язково." label="Вміст" readonly
                            placeholder="N/A" />
                        <x-forms.input id="metadata" helper="читання - обов'язково." label="Метадані" readonly
                            placeholder="N/A" />
                        {{-- <x-forms.input id="administration"
                            helper="read:write access needed to setup servers as GitHub Runner." label="Administration"
                            readonly placeholder="N/A" /> --}}
                        <x-forms.input id="pullRequests"
                            helper="потрібен доступ на запис для оновлення статусу розгортання в попередніх переглядах."
                            label="Запит на злиття" readonly placeholder="N/A" />
                    </div>
                </div>
            @endif
        </form>
        @if (data_get($github_app, 'installation_id'))
            <div class="w-full pt-10">
                <div class="h-full">
                    <div class="flex flex-col">
                        <div class="flex gap-2">
                            <h2>Ресурси</h2>
                        </div>
                        <div class="pb-4 title">Тут ви можете знайти всі ресурси, що використовують це джерело.</div>
                    </div>
                    @if ($applications->isEmpty())
                        <div class="py-4 text-sm opacity-70">
                            Наразі жодні ресурси не використовують цей Застосунок GitHub.
                        </div>
                    @else
                        <div class="flex flex-col">
                            <div class="flex flex-col">
                                <div class="overflow-x-auto">
                                    <div class="inline-block min-w-full">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full">
                                                <thead>
                                                    <tr>
                                                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                            Проєкт
                                                        </th>
                                                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">
                                                            Середовище</th>
                                                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Назва
                                                        </th>
                                                        <th class="px-5 py-3 text-xs font-medium text-left uppercase">Тип
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y">
                                                    @foreach ($applications->sortBy('name',SORT_NATURAL) as $resource)
                                                        <tr>
                                                            <td class="px-5 py-4 text-sm whitespace-nowrap">
                                                                {{ data_get($resource->project(), 'name') }}
                                                            </td>
                                                            <td class="px-5 py-4 text-sm whitespace-nowrap">
                                                                {{ data_get($resource, 'environment.name') }}
                                                            </td>
                                                            <td class="px-5 py-4 text-sm whitespace-nowrap"><a
                                                                    class=""
                                                                    href="{{ $resource->link() }}">{{ $resource->name }}
                                                                    <x-internal-link /></a>
                                                            </td>
                                                            <td class="px-5 py-4 text-sm whitespace-nowrap">
                                                                {{ str($resource->type())->headline() }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    @else
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 pb-4">
            <h1>Застосунок GitHub</h1>
            <div class="flex gap-2">
                @can('delete', $github_app)
                    <x-modal-confirmation title="Підтвердити видалення Застосунку GitHub?" isErrorButton buttonTitle="Видалити"
                        submitAction="delete" :actions="['Вибраний Застосунок GitHub буде остаточно видалено.']" confirmationText="{{ data_get($github_app, 'name') }}"
                        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву Застосунку GitHub нижче"
                        shortConfirmationLabel="Назва Застосунку GitHub" :confirmWithPassword="false"
                        step2ButtonText="Видалити остаточно" />
                @endcan
            </div>
        </div>
        <div class="flex flex-col gap-2">
            @can('create', $github_app)
                <h3>Ручна інсталяція</h3>
                <div class="flex gap-2 items-center">
                    Якщо ви хочете заповнити форму вручну, ви можете продовжити нижче. Лише для досвідчених користувачів.
                    <x-forms.button wire:click.prevent="createGithubAppManually">
                        Продовжити
                    </x-forms.button>
                </div>
                <h3>Автоматична інсталяція</h3>
                <div class=" pb-5 rounded-sm alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Ви повинні виконати цей крок, перш ніж зможете використовувати це джерело!</span>
                </div>
            @endcan
            <div class="flex flex-col">
                <div class="pb-10">
                    @can('create', $github_app)
                        @if (!isCloud() || isDev())
                            <div class="flex flex-col sm:flex-row items-start sm:items-end gap-2">
                                <x-forms.select wire:model.live='webhook_endpoint' label="Кінцева точка вебхука"
                                    helper="Усі вебхуки Git будуть надсилатися на цю кінцеву точку. <br><br>Якщо ви бажаєте використовувати домен замість IP-адреси, встановіть FQDN вашого екземпляра Coolify у меню Налаштувань.">
                                    @if ($ipv4)
                                        <option value="{{ $ipv4 }}">Використовувати {{ $ipv4 }}</option>
                                    @endif
                                    @if ($ipv6)
                                        <option value="{{ $ipv6 }}">Використовувати {{ $ipv6 }}</option>
                                    @endif
                                    @if ($fqdn)
                                        <option value="{{ $fqdn }}">Використовувати {{ $fqdn }}</option>
                                    @endif
                                    @if (config('app.url'))
                                        <option value="{{ config('app.url') }}">Використовувати {{ config('app.url') }}</option>
                                    @endif
                                </x-forms.select>
                                <x-forms.button isHighlighted
                                    x-on:click.prevent="createGithubApp('{{ $webhook_endpoint }}','{{ $preview_deployment_permissions }}',{{ $administration }})">
                                    Зареєструвати зараз
                                </x-forms.button>
                            </div>
                        @else
                            <div class="flex flex-col sm:flex-row gap-2">
                                <h2>Зареєструвати Застосунок GitHub</h2>
                                <x-forms.button isHighlighted
                                    x-on:click.prevent="createGithubApp('{{ $webhook_endpoint }}','{{ $preview_deployment_permissions }}',{{ $administration }})">
                                    Зареєструвати зараз
                                </x-forms.button>
                            </div>
                            <div>Вам потрібно зареєструвати Застосунок GitHub перед використанням цього джерела.</div>
                        @endif

                        <div class="flex flex-col gap-2 pt-4 w-96">
                            <x-forms.checkbox disabled id="default_permissions" label="Обов'язково"
                                helper="Вміст: читання<br>Метадані: читання<br>Електронна пошта: читання" />
                            <x-forms.checkbox id="preview_deployment_permissions" label="Попередні розгортання "
                                helper="Необхідно для оновлення запитів на злиття з корисними коментарями (статус розгортання, посилання тощо).<br><br>Запит на злиття: читання та запис" />
                            {{-- <x-forms.checkbox id="administration" label="Administration (for Github Runners)"
                            helper="Necessary for adding Github Runners to repositories.<br><br>Administration: read & write" /> --}}
                        </div>
                    @else
                        <x-callout type="danger" title="Недостатньо дозволів">
                            Ви не маєте дозволу на створення нових Застосунків GitHub. Будь ласка, зв'яжіться з адміністратором вашої команди.
                        </x-callout>
                    @endcan
                </div>
            </div>
            <script>
                function createGithubApp(webhook_endpoint, preview_deployment_permissions, administration) {
                    const {
                        organization,
                        uuid,
                        html_url
                    } = @json($github_app);
                    if (!webhook_endpoint) {
                        alert('Please select a webhook endpoint.');
                        return;
                    }
                    let baseUrl = webhook_endpoint;
                    const name = @js($name);
                    const isDev = @js(config('app.env')) ===
                        'local';
                    const devWebhook = @js(config('constants.webhooks.dev_webhook'));
                    if (isDev && devWebhook) {
                        baseUrl = devWebhook;
                    }
                    const webhookBaseUrl = `${baseUrl}/webhooks`;
                    const path = organization ? `organizations/${organization}/settings/apps/new` : 'settings/apps/new';
                    const default_permissions = {
                        contents: 'read',
                        metadata: 'read',
                        emails: 'read',
                        administration: 'read'
                    };
                    const default_events = ['push'];
                    if (preview_deployment_permissions) {
                        default_permissions.pull_requests = 'write';
                        default_events.push('pull_request');
                    }
                    if (administration) {
                        default_permissions.administration = 'write';
                    }

                    const data = {
                        name,
                        url: baseUrl,
                        hook_attributes: {
                            url: `${webhookBaseUrl}/source/github/events`,
                            active: true,
                        },
                        redirect_url: `${webhookBaseUrl}/source/github/redirect`,
                        callback_urls: [`${baseUrl}/login/github/app`],
                        public: false,
                        request_oauth_on_install: false,
                        setup_url: `${webhookBaseUrl}/source/github/install?source=${uuid}`,
                        setup_on_update: true,
                        default_permissions,
                        default_events
                    };
                    const form = document.createElement('form');
                    form.setAttribute('method', 'post');
                    form.setAttribute('action', `${html_url}/${path}?state=${uuid}`);
                    const input = document.createElement('input');
                    input.setAttribute('id', 'manifest');
                    input.setAttribute('name', 'manifest');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('value', JSON.stringify(data));
                    form.appendChild(input);
                    document.getElementsByTagName('body')[0].appendChild(form);
                    form.submit();
                }
            </script>
    @endif
</div>