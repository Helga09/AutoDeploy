@php use App\Enums\ProxyTypes; @endphp
<x-slot:title>
    Налаштування | Coolify
    </x-slot>
    <section class="w-full">
        <div class="flex flex-col items-center w-full space-y-8">
            @if ($currentState === 'welcome')
                <div class="w-full max-w-2xl text-center space-y-8">
                    <div class="space-y-4">
                        <h1 class="text-4xl font-bold lg:text-6xl">Ласкаво просимо до Coolify</h1>
                        <p class="text-lg lg:text-xl dark:text-neutral-400">
                            Підключіть свій перший сервер та розпочніть розгортання за лічені хвилини
                        </p>
                    </div>

                    <div class="text-left space-y-4 p-8 rounded-lg border border-neutral-200 dark:border-coolgray-400">
                        <h2 class="text-sm font-bold uppercase tracking-wide dark:text-neutral-400">
                            Що ви налаштуєте
                        </h2>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Підключення до сервера</div>
                                    <div class="text-sm dark:text-neutral-400">Підключіться через SSH для розгортання ваших ресурсів
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Середовище Docker</div>
                                    <div class="text-sm dark:text-neutral-400">Автоматична установка та конфігурація
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Структура проєкту</div>
                                    <div class="text-sm dark:text-neutral-400">Організуйте ваші застосунки та ресурси
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-3 pt-4">
                        <x-forms.button class="justify-center px-12 py-4 text-lg font-bold box-boarding"
                            wire:click="explanation">
                            Почнімо!
                        </x-forms.button>
                        <button wire:click="skipBoarding"
                            class="text-sm dark:text-neutral-400 hover:text-coollabs dark:hover:text-warning hover:underline transition-colors">
                            Пропустити налаштування
                        </button>
                    </div>
                </div>
            @elseif ($currentState === 'explanation')
                <x-boarding-progress :currentStep="0" />
                <x-boarding-step title="Огляд платформи">
                    <x-slot:question>
                        Coolify автоматизує розгортання та керування інфраструктурою на ваших власних серверах. Розгортайте застосунки з Git, керуйте базами даних та моніторте все – без прив'язки до постачальника.
                    </x-slot:question>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Автоматизація:" /> Coolify автоматично керує конфігурацією сервера, управлінням Docker та розгортанням.
                        </p>
                        <p>
                            <x-highlighted text="Самостійне розміщення:" /> Усі дані та конфігурації зберігаються у вашій інфраструктурі. Працює офлайн, за винятком зовнішніх інтеграцій.
                        </p>
                        <p>
                            <x-highlighted text="Моніторинг та сповіщення:" /> Отримуйте сповіщення в реальному часі через Discord, Telegram, Email та інші платформи.
                        </p>
                    </x-slot:explanation>
                    <x-slot:actions>
                        <x-forms.button class="justify-center w-full lg:w-auto px-8 py-3 box-boarding"
                            wire:click="explanation">
                            Продовжити
                        </x-forms.button>
                    </x-slot:actions>
                </x-boarding-step>
            @elseif ($currentState === 'select-server-type')
                <x-boarding-progress :currentStep="1" />
                <x-boarding-step title="Оберіть тип сервера">
                    <x-slot:question>
                        Виберіть, де розгортати ваші застосунки та бази даних. Ви можете додати більше серверів пізніше.
                    </x-slot:question>
                    <x-slot:actions>
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 w-full">
                            <button
                                class="group relative box-without-bg cursor-pointer hover:border-coollabs transition-all duration-200 p-6"
                                wire:target="setServerType('localhost')" wire:click="setServerType('localhost')">
                                <div class="flex flex-col gap-4 text-left">
                                    <div class="flex items-center justify-between">
                                        <svg class="size-10" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M5.25 14.25h13.5m-13.5 0a3 3 0 01-3-3m3 3a3 3 0 100 6h13.5a3 3 0 100-6m-16.5-3a3 3 0 013-3h13.5a3 3 0 013 3m-19.5 0a4.5 4.5 0 01.9-2.7L5.737 5.1a3.375 3.375 0 012.7-1.35h7.126c1.062 0 2.062.5 2.7 1.35l2.587 3.45a4.5 4.5 0 01.9 2.7m0 0a3 3 0 01-3 3m0 3h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008zm-3 6h.008v.008h-.008v-.008zm0-6h.008v.008h-.008v-.008z" />
                                        </svg>
                                        <span
                                            class="px-2 py-1 text-xs font-bold uppercase tracking-wide bg-neutral-100 dark:bg-coolgray-300 dark:text-neutral-400 rounded">
                                            Швидкий старт
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold mb-2">Ця машина</h3>
                                        <p class="text-sm dark:text-neutral-400">
                                            Розгорнути на сервері, що запускає Coolify. Найкраще для тестування та налаштування одного сервера.
                                        </p>
                                    </div>
                                </div>
                            </button>



                            <button
                                class="group relative box-without-bg cursor-pointer hover:border-coollabs transition-all duration-200 p-6"
                                wire:target="setServerType('remote')" wire:click="setServerType('remote')">
                                <div class="flex flex-col gap-4 text-left">
                                    <div class="flex items-center justify-between">
                                        <svg class="size-10 " xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 15a4.5 4.5 0 004.5 4.5H18a3.75 3.75 0 001.332-7.257 3 3 0 00-3.758-3.848 5.25 5.25 0 00-10.233 2.33A4.502 4.502 0 002.25 15z" />
                                        </svg>
                                        <span
                                            class="px-2 py-1 text-xs font-bold uppercase tracking-wide bg-coollabs/10 dark:bg-warning/20 text-coollabs dark:text-warning rounded">
                                            Рекомендовано
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold mb-2">Віддалений сервер</h3>
                                        <p class="text-sm dark:text-neutral-400">
                                            Підключіться через SSH до будь-якого сервера — хмарного VPS, bare metal або домашньої інфраструктури.
                                        </p>
                                    </div>
                                </div>
                            </button>
                            @can('viewAny', App\Models\CloudProviderToken::class)
                                @if ($currentState === 'select-server-type')
                                    <x-modal-input title="Підключити сервер Hetzner" isFullWidth>
                                        <x-slot:content>
                                            <div
                                                class="group relative box-without-bg cursor-pointer hover:border-coollabs transition-all duration-200 p-6 h-full min-h-[210px]">
                                                <div class="flex flex-col gap-4 text-left">
                                                    <div class="flex items-center justify-between">
                                                        <svg class="size-10" viewBox="0 0 200 200"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <rect width="200" height="200" fill="#D50C2D" rx="8" />
                                                            <path d="M40 40 H60 V90 H140 V40 H160 V160 H140 V110 H60 V160 H40 Z"
                                                                fill="white" />
                                                        </svg>
                                                        <span
                                                            class="px-2 py-1 text-xs font-bold uppercase tracking-wide bg-coollabs/10 dark:bg-warning/20 text-coollabs dark:text-warning rounded">
                                                            Рекомендовано
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-xl font-bold mb-2">Hetzner Cloud</h3>
                                                        <p class="text-sm dark:text-neutral-400">
                                                            Розгортайте сервери безпосередньо з вашого облікового запису Hetzner Cloud.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </x-slot:content>
                                        <livewire:server.new.by-hetzner :limit_reached="false" :from_onboarding="true" />
                                    </x-modal-input>
                                @endif
                            @endcan
                        </div>

                        @if (!$serverReachable)
                            <div class="mt-6 p-4 border border-error rounded-lg text-gray-800 dark:text-gray-200">
                                <h2 class="text-lg font-bold mb-2">Сервер недоступний</h2>
                                <p class="mb-4">Будь ласка, перевірте дані підключення нижче та виправте їх, якщо вони невірні.</p>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <x-forms.input placeholder="За замовчуванням 22" label="Порт" id="remoteServerPort"
                                        wire:model="remoteServerPort" :value="$remoteServerPort" />
                                    <div>
                                        <x-forms.input placeholder="За замовчуванням root" label="Користувач" id="remoteServerUser"
                                            wire:model="remoteServerUser" :value="$remoteServerUser" />
                                        <p class="text-xs mt-1">
                                            Не-root користувач є експериментальним:
                                            <a class="font-bold underline" target="_blank"
                                                href="https://coolify.io/docs/knowledge-base/server/non-root-user">документація</a>
                                        </p>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <p class="mb-2">Якщо дані підключення правильні, будь ласка, переконайтеся, що:</p>
                                    <ul class="list-disc list-inside">
                                        <li>Правильний публічний ключ знаходиться у вашому файлі <code
                                                class="bg-red-200 dark:bg-red-900 px-1 rounded-sm">~/.ssh/authorized_keys</code>
                                            для зазначеного користувача</li>
                                        <li>Або пропустіть процес налаштування та вручну додайте новий приватний ключ до Coolify та сервера</li>
                                    </ul>
                                </div>

                                <p class="mb-4">
                                    Для отримання додаткової допомоги перегляньте цю <a target="_blank" class="underline font-semibold"
                                        href="https://coolify.io/docs/knowledge-base/server/openssh">документацію</a>.
                                </p>

                                <x-forms.input readonly id="serverPublicKey" class="mb-4"
                                    label="Поточний публічний ключ"></x-forms.input>

                                <x-forms.button class="w-full box-boarding" wire:click="saveAndValidateServer">
                                    Перевірити ще раз
                                </x-forms.button>
                            </div>
                        @endif
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Сервери" /> розміщують ваші застосунки, бази даних та сервіси (що разом називаються ресурсами). Усі операції, що вимагають великих обчислювальних ресурсів, виконуються на цільовому сервері.
                        </p>
                        <p>
                            <x-highlighted text="Локальний хост:" /> Машина, на якій працює Coolify. Не рекомендується для виробничих навантажень через конкуренцію за ресурси.
                        </p>
                        <p>
                            <x-highlighted text="Віддалений сервер:" /> Будь-який SSH-доступний сервер — хмарні провайдери (AWS, Hetzner, DigitalOcean), bare metal або самостійно розміщена інфраструктура.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'private-key')
                <x-boarding-progress :currentStep="2" />
                <x-boarding-step title="SSH автентифікація">
                    <x-slot:question>
                        Налаштуйте SSH-автентифікацію на основі ключів для безпечного доступу до сервера.
                    </x-slot:question>
                    <x-slot:actions>
                        @if ($privateKeys && $privateKeys->count() > 0)
                            <div class="w-full space-y-4">
                                <div class="p-4 rounded-lg border border-neutral-200 dark:border-coolgray-400">
                                    <form wire:submit='selectExistingPrivateKey' class="flex flex-col gap-4">
                                        <x-forms.select label="Існуючі SSH ключі" id='selectedExistingPrivateKey'>
                                            @foreach ($privateKeys as $privateKey)
                                                <option wire:key="{{ $loop->index }}" value="{{ $privateKey->id }}">
                                                    {{ $privateKey->name }}
                                                </option>
                                            @endforeach
                                        </x-forms.select>
                                        <x-forms.button type="submit" class="w-full lg:w-auto">Використати обраний ключ</x-forms.button>
                                    </form>
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-neutral-300 dark:border-coolgray-400"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <div
                                            class="px-2 py-1 bg-white dark:bg-coolgray-100 border border-neutral-300 dark:border-coolgray-300 rounded text-xs font-bold text-neutral-500 dark:text-neutral-400">
                                            АБО
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 w-full">
                            <x-forms.button
                                class="justify-center h-auto py-6 box-without-bg hover:border-coollabs transition-all duration-200"
                                wire:target="setPrivateKey('own')" wire:click="setPrivateKey('own')">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 0 1121.75 8.25z" />
                                    </svg>
                                    <div class="text-center">
                                        <h3 class="text-xl font-bold mb-2">Використати існуючий ключ</h3>
                                        <p class="text-sm dark:text-neutral-400">Я маю власний SSH ключ</p>
                                    </div>
                                </div>
                            </x-forms.button>
                            <x-forms.button
                                class="justify-center h-auto py-6 box-without-bg hover:border-coollabs transition-all duration-200"
                                wire:target="setPrivateKey('create')" wire:click="setPrivateKey('create')">
                                <div class="flex flex-col items-center gap-2">
                                    <svg class="size-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                                    </svg>
                                    <div class="text-center">
                                        <h3 class="text-xl font-bold mb-2">Згенерувати новий ключ</h3>
                                        <p class="text-sm dark:text-neutral-400">Створити пару ключів ED25519</p>
                                    </div>
                                </div>
                            </x-forms.button>
                        </div>
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="SSH автентифікація за ключами:" /> Використовує криптографію з відкритим ключем для безпечного, безпарольного доступу до сервера.
                        </p>
                        <p>
                            <x-highlighted text="Розгортання публічного ключа:" /> Додайте публічний ключ до файлу <code
                                class="text-xs bg-coolgray-300 dark:bg-coolgray-400 px-1 py-0.5 rounded">~/.ssh/authorized_keys</code> на вашому сервері.
                        </p>
                        <p>
                            <x-highlighted text="Генерація ключів:" /> Coolify генерує ключі ED25519 за замовчуванням для оптимальної безпеки та продуктивності.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'create-private-key')
                <x-boarding-progress :currentStep="2" />
                <x-boarding-step title="Конфігурація SSH ключа">
                    <x-slot:question>
                        Налаштуйте ваш SSH ключ для автентифікації на сервері.
                    </x-slot:question>
                    <x-slot:actions>
                        <form wire:submit='savePrivateKey' class="flex flex-col w-full gap-4">
                            <x-forms.input required placeholder="наприклад, production-server-key" label="Ім'я ключа"
                                id="privateKeyName" />
                            <x-forms.input placeholder="Необов'язково: Примітка, для чого використовується цей ключ" label="Опис"
                                id="privateKeyDescription" />
                            @if ($privateKeyType === 'create')
                                <x-forms.textarea required readonly label="Приватний ключ" id="privateKey" rows="8" />
                                <x-forms.textarea rows="7" readonly label="Публічний ключ" id="publicKey" />
                            @else
                                <x-forms.textarea required placeholder="-----BEGIN OPENSSH PRIVATE KEY-----" label="Приватний ключ"
                                    id="privateKey" rows="8" />
                            @endif
                            @if ($privateKeyType === 'create')
                                <div class="p-4 bg-warning/10 border border-warning rounded-lg">
                                    <div class="flex gap-3">
                                        <svg class="size-5 text-warning flex-shrink-0 mt-0.5" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <div>
                                            <p class="font-bold text-warning mb-1">Потрібна дія</p>
                                            <p class="text-sm dark:text-white text-black">
                                                Скопіюйте публічний ключ вище та додайте його до файлу <code
                                                    class="text-xs bg-coolgray-300 dark:bg-coolgray-400 px-1 py-0.5 rounded">~/.ssh/authorized_keys</code> на вашому сервері.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <x-forms.button type="submit" class="w-full lg:w-auto">Зберегти SSH ключ</x-forms.button>
                        </form>
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Зберігання ключів:" /> Приватні ключі зашифровані в базі даних Coolify.
                        </p>
                        <p>
                            <x-highlighted text="Розповсюдження публічного ключа:" /> Розгорніть публічний ключ до <code
                                class="text-xs bg-coolgray-300 dark:bg-coolgray-400 px-1 py-0.5 rounded">~/.ssh/authorized_keys</code> на цільовому сервері для вказаного користувача.
                        </p>
                        <p>
                            <x-highlighted text="Формат ключа:" /> Підтримує типи ключів RSA, ED25519, ECDSA та DSA у форматі OpenSSH.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'create-server')
                <x-boarding-progress :currentStep="2" />
                <x-boarding-step title="Конфігурація сервера">
                    <x-slot:question>
                        Надайте дані для підключення до вашого віддаленого сервера.
                    </x-slot:question>
                    <x-slot:actions>
                        <form wire:submit='saveServer' class="flex flex-col w-full gap-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                                <x-forms.input required placeholder="наприклад, production-app-server" label="Ім'я сервера"
                                    id="remoteServerName" wire:model="remoteServerName" />
                                <x-forms.input required placeholder="IP-адреса або ім'я хоста" label="IP-адреса/Ім'я хоста"
                                    id="remoteServerHost" wire:model="remoteServerHost" />
                            </div>
                            <x-forms.input placeholder="Необов'язково: Примітка, що розміщує цей сервер" label="Опис"
                                id="remoteServerDescription" wire:model="remoteServerDescription" />

                            <div x-data="{ showAdvanced: false }" class="flex flex-col gap-4">
                                <button @click="showAdvanced = !showAdvanced" type="button"
                                    class="flex items-center gap-2 text-left text-sm font-medium  hover:underline">
                                    <svg x-show="!showAdvanced" class="size-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <svg x-show="showAdvanced" class="size-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Додаткові параметри підключення
                                </button>
                                <div x-show="showAdvanced" x-cloak
                                    class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4 rounded-lg border border-neutral-200 dark:border-coolgray-400">
                                    <x-forms.input placeholder="За замовчуванням: 22" label="SSH порт" type="number"
                                        id="remoteServerPort" wire:model="remoteServerPort" />
                                    <div>
                                        <x-forms.input placeholder="За замовчуванням: root" label="Користувач SSH" id="remoteServerUser"
                                            wire:model="remoteServerUser" />
                                        <p class="mt-1 text-xs dark:text-white text-black">
                                            Підтримка користувачів без root є експериментальною.
                                            <a class="font-bold underline hover:text-coollabs" target="_blank"
                                                href="https://coolify.io/docs/knowledge-base/server/non-root-user">Дізнатися більше</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <x-forms.button type="submit" class="w-full lg:w-auto">Перевірити підключення</x-forms.button>
                        </form>
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Вимоги до підключення:" /> Сервер повинен бути доступним через SSH на вказаному порту (за замовчуванням 22).
                        </p>
                        <p>
                            <x-highlighted text="Розпізнавання імені хоста:" /> Використовуйте IP-адреси для прямих підключень або переконайтеся, що налаштовано розпізнавання DNS.
                        </p>
                        <p>
                            <x-highlighted text="Дозволи користувача:" /> Для повних можливостей керування Docker рекомендуються користувачі root або з правами sudo.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'validate-server')
                <x-boarding-progress :currentStep="2" />
                <x-boarding-step title="Перевірка сервера">
                    <x-slot:question>
                        Coolify автоматично встановить Docker {{ $minDockerVersion }}+, якщо його немає.
                    </x-slot:question>
                    <x-slot:actions>
                        <div class="w-full space-y-6">
                            <div
                                class="p-6 bg-neutral-50 dark:bg-coolgray-200 rounded-lg border border-neutral-200 dark:border-coolgray-400">
                                <h3 class="font-bold text-black dark:text-white mb-4">Етапи перевірки</h3>
                                <div class="space-y-3">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base dark:text-white">Тест SSH підключення</div>
                                            <div class="text-sm dark:text-neutral-400">Перевірити автентифікацію на основі ключів</div>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base dark:text-white">Перевірити сумісність ОС
                                            </div>
                                            <div class="text-sm dark:text-neutral-400">Перевірити підтримуваний дистрибутив Linux
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base dark:text-white">Встановити Docker Engine</div>
                                            <div class="text-sm dark:text-neutral-400">Автоматична установка, якщо версія
                                                {{ $minDockerVersion }}+ не знайдена
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 mt-0.5">
                                            <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-semibold text-base dark:text-white">Налаштувати мережу</div>
                                            <div class="text-sm dark:text-neutral-400">Налаштувати мережі Docker та проксі
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <x-slide-over closeWithX fullScreen>
                                <x-slot:title>Перевірка сервера</x-slot:title>
                                <x-slot:content>
                                    <livewire:server.validate-and-install :server="$this->createdServer" />
                                </x-slot:content>
                                <x-forms.button @click="slideOverOpen=true" class="w-full font-bold py-4 box-boarding"
                                    wire:click.prevent='installServer' isHighlighted>
                                    Розпочати перевірку
                                </x-forms.button>
                            </x-slide-over>
                        </div>
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Автоматичне налаштування:" /> Coolify автоматично встановлює Docker Engine, Docker Compose та налаштовує системні вимоги.
                        </p>
                        <p>
                            <x-highlighted text="Вимоги до версії:" /> Потрібна мінімальна версія Docker Engine {{ $minDockerVersion }}.x.
                            <a target="_blank" class="underline hover:text-coollabs"
                                href="https://docs.docker.com/engine/install/#server">Посібник з ручної установки</a>
                        </p>
                        <p>
                            <x-highlighted text="Конфігурація системи:" /> Налаштовує мережі Docker, конфігурацію проксі та моніторинг ресурсів.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'create-project')
                <x-boarding-progress :currentStep="3" />
                <x-boarding-step title="Налаштування проєкту">
                    <x-slot:question>
                        @if ($projects && $projects->count() > 0)
                            У вас є існуючі проєкти. Виберіть один або створіть новий проєкт для організації ваших ресурсів.
                        @else
                            Створіть свій перший проєкт для організації застосунків, баз даних та сервісів.
                        @endif
                    </x-slot:question>
                    <x-slot:actions>
                        <div class="w-full space-y-4">
                            <x-forms.button class="justify-center w-full py-4 font-bold box-boarding"
                                wire:click="createNewProject" isHighlighted>
                                Створити "Мій перший проєкт"
                            </x-forms.button>

                            @if ($projects && $projects->count() > 0)
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center">
                                        <div class="w-full border-t border-neutral-300 dark:border-coolgray-400"></div>
                                    </div>
                                    <div class="relative flex justify-center text-sm">
                                        <span class="px-2 text-neutral-500 dark:text-neutral-400">Або використати існуючий</span>
                                    </div>
                                </div>
                                <form wire:submit='selectExistingProject' class="flex flex-col gap-4">
                                    <x-forms.select label="Існуючі проєкти" id='selectedProject'>
                                        @foreach ($projects as $project)
                                            <option wire:key="{{ $loop->index }}" value="{{ $project->id }}">
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </x-forms.select>
                                    <x-forms.button type="submit" class="w-full lg:w-auto">Використати обраний проєкт</x-forms.button>
                                </form>
                            @endif
                        </div>
                    </x-slot:actions>
                    <x-slot:explanation>
                        <p>
                            <x-highlighted text="Організація проєктів:" /> Групуйте пов'язані ресурси (застосунки, бази даних, сервіси) у логічні проєкти.
                        </p>
                        <p>
                            <x-highlighted text="Середовища:" /> Кожен проєкт за замовчуванням включає виробниче середовище. Додайте стейджинг, розробку або власні середовища за потреби.
                        </p>
                        <p>
                            <x-highlighted text="Доступ для команди:" /> Проєкти успадковують дозволи команди і можуть керуватися спільно.
                        </p>
                    </x-slot:explanation>
                </x-boarding-step>
            @elseif ($currentState === 'create-resource')
                <x-boarding-progress :currentStep="3" />
                <div class="w-full max-w-2xl text-center space-y-8">
                    <div class="space-y-4">
                        <div class="flex justify-center">
                            <svg class="size-16 text-success" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h1 class="text-4xl font-bold lg:text-5xl">Налаштування завершено!</h1>
                        <p class="text-lg dark:text-neutral-400">
                            Ваш сервер підключено та готово. Почніть розгортання свого першого ресурсу.
                        </p>
                    </div>

                    <div class="text-left space-y-4 p-8 rounded-lg border border-neutral-200 dark:border-coolgray-400">
                        <h2 class="text-sm font-bold uppercase tracking-wide dark:text-neutral-400">
                            Що налаштовано
                        </h2>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Сервер: {{ $createdServer->name }}
                                    </div>
                                    <div class="text-sm dark:text-neutral-400">{{ $createdServer->ip }}</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Проєкт:
                                        {{ $createdProject->name }}
                                    </div>
                                    <div class="text-sm dark:text-neutral-400">Виробниче середовище готове</div>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="size-5 text-success" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="font-semibold text-base dark:text-white">Docker Engine</div>
                                    <div class="text-sm dark:text-neutral-400">Встановлено та запущено</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <x-forms.button class="justify-center w-full py-4 text-lg font-bold box-boarding"
                            wire:click="showNewResource" isHighlighted>
                            Розгорнути перший ресурс
                        </x-forms.button>
                        <button wire:click="skipBoarding"
                            class="text-sm dark:text-neutral-400 hover:text-coollabs dark:hover:text-warning hover:underline transition-colors">
                            Перейти до Панелі керування
                        </button>
                    </div>
                </div>
            @endif
        </div>

        @if ($currentState !== 'welcome' && $currentState !== 'create-resource')
            <div class="flex flex-col items-center gap-4 pt-8 mt-8 border-t border-neutral-200 dark:border-coolgray-400">
                <div class="flex justify-center gap-6 text-sm">
                    <button wire:click='skipBoarding'
                        class="dark:text-neutral-400 hover:text-coollabs dark:hover:text-warning hover:underline transition-colors">
                        Пропустити налаштування
                    </button>
                    <button wire:click='restartBoarding'
                        class="dark:text-neutral-400 hover:text-coollabs dark:hover:text-warning hover:underline transition-colors">
                        Перезапустити
                    </button>
                </div>
                <x-modal-input title="Потрібна допомога?">
                    <x-slot:content>
                        <button
                            class="text-sm dark:text-neutral-400 hover:text-coollabs dark:hover:text-warning hover:underline transition-colors">
                            Зв'язатися з підтримкою
                        </button>
                    </x-slot:content>
                    <livewire:help />
                </x-modal-input>
            </div>
        @endif
    </section>