<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Cloudflare Tunnel | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="cloudflare-tunnel" />
        <div class="w-full">
            <div class="flex flex-col">
                <div class="flex gap-2 items-center">
                    <h2>Cloudflare Tunnel</h2>
                    <x-helper class="inline-flex"
                        helper="Якщо ви використовуєте Cloudflare Tunnel, увімкніть його. Він буде проксіювати всі SSH-запити до вашого сервера через Cloudflare.<br> Потім ви можете закрити SSH-порт вашого сервера у брандмауері вашого хостинг-провайдера.<br><span class='dark:text-warning'>Якщо ви вибираєте ручну конфігурацію, Coolify не встановлює та не налаштовує Cloudflare (cloudflared) на вашому сервері.</span>" />
                    @if ($isCloudflareTunnelsEnabled)
                        <span
                            class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded dark:text-green-100 dark:bg-green-800">
                            Увімкнено
                        </span>
                    @endif
                </div>
                <div>Захистіть свої сервери за допомогою Cloudflare Tunnel.</div>
            </div>
            <div class="flex flex-col gap-2 pt-6">
                @if ($isCloudflareTunnelsEnabled)
                    <div class="flex flex-col gap-4">
                        <x-callout type="warning" title="Попередження!">
                            Якщо ви вимкнете Cloudflare Tunnel, вам потрібно буде оновити IP-адресу сервера на його справжню IP-адресу в налаштуваннях сервера "Загальні". Сервер може стати недоступним, якщо IP-адреса не буде оновлена ​​правильно.
                        </x-callout>
                        <div class="w-64">
                            @if ($server->ip_previous)
                                <x-modal-confirmation title="Вимкнути Cloudflare Tunnel?"
                                    buttonTitle="Вимкнути Cloudflare Tunnel" isErrorButton
                                    submitAction="toggleCloudflareTunnels" :actions="[
                                        'Cloudflare Tunnel буде вимкнено для цього сервера.',
                                        'IP-адресу сервера буде оновлено до його попередньої IP-адреси.',
                                    ]"
                                    confirmationText="ВИМКНУТИ CLOUDFLARE TUNNEL"
                                    confirmationLabel="Будь ласка, введіть текст підтвердження, щоб вимкнути Cloudflare Tunnel."
                                    shortConfirmationLabel="Текст підтвердження" />
                            @else
                                <x-modal-confirmation title="Вимкнути Cloudflare Tunnel?"
                                    buttonTitle="Вимкнути Cloudflare Tunnel" isErrorButton
                                    submitAction="toggleCloudflareTunnels" :actions="[
                                        'Cloudflare Tunnel буде вимкнено для цього сервера.',
                                        'Вам потрібно буде оновити IP-адресу сервера до його справжньої IP-адреси.',
                                        'Сервер може стати недоступним, якщо IP-адреса не буде оновлена ​​правильно.',
                                        'Доступ SSH повернеться до стандартної конфігурації порту.',
                                    ]"
                                    confirmationText="ВИМКНУТИ CLOUDFLARE TUNNEL"
                                    confirmationLabel="Будь ласка, введіть текст підтвердження, щоб вимкнути Cloudflare Tunnel."
                                    shortConfirmationLabel="Текст підтвердження" />
                            @endif

                        </div>
                    </div>
                @elseif (!$server->isFunctional())
                    <x-callout type="info" title="Параметри конфігурації" class="mb-4">
                        Щоб <span class="font-semibold">автоматично</span> налаштувати Cloudflare Tunnel, спочатку перевірте свій сервер. Потім вам знадобиться токен Cloudflare та налаштований домен SSH.<br />Щоб <span class="font-semibold">вручну</span> налаштувати Cloudflare Tunnel, будь ласка, натисніть <span wire:click="manualCloudflareConfig" class="underline cursor-pointer">тут</span>, а потім ви повинні перевірити сервер.<br /><br />Для отримання додаткової інформації, будь ласка, прочитайте нашу <a
                            href="https://coolify.io/docs/knowledge-base/cloudflare/tunnels/server-ssh" target="_blank"
                            class="underline">документацію</a>.
                    </x-callout>
                @endif
                @if (!$isCloudflareTunnelsEnabled && $server->isFunctional())
                    <div class="flex  flex-col pb-2">
                        <h3>Автоматично </h3>
                        <a href="https://coolify.io/docs/knowledge-base/cloudflare/tunnels/server-ssh" target="_blank"
                            class="text-xs underline hover:text-yellow-600 dark:hover:text-yellow-200">Документація<x-external-link /></a>
                    </div>
                    <div class="flex gap-2">
                        <x-slide-over @automated.window="slideOverOpen = true" fullScreen>
                            <x-slot:title>Конфігурація Cloudflare Tunnel</x-slot:title>
                            <x-slot:content>
                                <livewire:activity-monitor header="Журнали" fullHeight />
                            </x-slot:content>
                        </x-slide-over>
                        @can('update', $server)
                            <form @submit.prevent="$wire.dispatch('automatedCloudflareConfig')"
                                class="flex flex-col gap-2 w-full">
                                <x-forms.input id="cloudflare_token" required label="Токен Cloudflare" type="password" />
                                <x-forms.input id="ssh_domain" label="Налаштований SSH домен" required
                                    helper="Домен SSH, який ви налаштували в Cloudflare. Переконайтеся, що немає протоколу на кшталт http(s)://, тому ви надаєте FQDN, а не URL. <a class='underline dark:text-white' href='https://coolify.io/docs/knowledge-base/cloudflare/tunnels/server-ssh' target='_blank'>Документація</a>" />
                                <x-forms.button type="submit" isHighlighted>Продовжити</x-forms.button>
                            </form>
                        @else
                            <x-callout type="warning" title="Потрібен дозвіл" class="mb-4">
                                У вас немає дозволу на налаштування Cloudflare Tunnel для цього сервера.
                            </x-callout>
                        @endcan
                    </div>
                    @script
                        <script>
                            $wire.$on('automatedCloudflareConfig', () => {
                                try {
                                    window.dispatchEvent(new CustomEvent('automated'));
                                    $wire.$call('automatedCloudflareConfig');
                                } catch (error) {
                                    console.error(error);
                                }
                            });
                        </script>
                    @endscript
            </div>
            <h3 class="pt-6 pb-2">Вручну</h3>
            <div class="pl-2">
                @can('update', $server)
                    <x-modal-confirmation buttonFullWidth title="Я налаштував Cloudflare Tunnel вручну?"
                        buttonTitle="Я налаштував Cloudflare Tunnel вручну" submitAction="manualCloudflareConfig"
                        :actions="[
                            'Ви налаштували все вручну, включаючи в Cloudflare та на сервері (cloudflared працює).',
                            'Якщо ви щось пропустили, з\'єднання не працюватиме.',
                        ]" confirmationText="Я налаштував Cloudflare Tunnel вручну"
                        confirmationLabel="Будь ласка, введіть текст підтвердження, щоб підтвердити, що ви налаштували Cloudflare Tunnel вручну."
                        shortConfirmationLabel="Текст підтвердження" />
                @else
                    <x-callout type="warning" title="Потрібен дозвіл" class="mb-4">
                        У вас немає дозволу на налаштування Cloudflare Tunnel для цього сервера.
                    </x-callout>
                @endcan
            </div>
            @endif
        </div>
    </div>
</div>