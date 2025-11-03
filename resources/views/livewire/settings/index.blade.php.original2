<div>
    <x-slot:title>
        Налаштування | Coolify
    </x-slot>
    <x-settings.navbar />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex flex-col h-full gap-8 sm:flex-row">
        <x-settings.sidebar activeMenu="general" />
        <form wire:submit='submit' class="flex flex-col">
            <div class="flex items-center gap-2">
                <h2>Загальні</h2>
                <x-forms.button type="submit">
                    Зберегти
                </x-forms.button>
            </div>
            <div class="pb-4">Загальна конфігурація для вашого екземпляра Coolify.</div>

            <div class="flex flex-col gap-2">
                <div class="flex flex-wrap items-end gap-2">
                    <div class="flex gap-2 md:flex-row flex-col w-full">
                        <x-forms.input id="fqdn" label="Домен"
                            helper="Введіть повне доменне ім'я (FQDN) екземпляра, включаючи 'https://', якщо ви хочете захистити панель керування за допомогою HTTPS. Це дозволить отримати доступ до панелі керування через цей домен, захищений HTTPS, замість просто IP-адреси."
                            placeholder="https://coolify.yourdomain.com" />
                        <x-forms.input id="instance_name" label="Ім'я" placeholder="Coolify"
                            helper="Власна назва для вашого екземпляра Coolify, відображається в URL." />
                        <div class="w-full" x-data="{
                            open: false,
                            search: '{{ $settings->instance_timezone ?: '' }}',
                            timezones: @js($this->timezones),
                            placeholder: '{{ $settings->instance_timezone ? 'Пошук часового поясу...' : 'Вибрати часовий пояс сервера' }}',
                            init() {
                                this.$watch('search', value => {
                                    if (value === '') {
                                        this.open = true;
                                    }
                                })
                            }
                        }">
                            <div class="flex items-center mb-1">
                                <label for="instance_timezone">Часовий пояс екземпляра</label>
                                <x-helper class="ml-2"
                                    helper="Часовий пояс для екземпляра Coolify. Використовується для перевірки оновлень та частоти автоматичних оновлень." />
                            </div>
                            <div class="relative">
                                <div class="inline-flex relative items-center w-full">
                                    <input autocomplete="off"
                                        wire:dirty.class.remove='dark:focus:ring-coolgray-300 dark:ring-coolgray-300'
                                        wire:dirty.class="dark:focus:ring-warning dark:ring-warning" x-model="search"
                                        @focus="open = true" @click.away="open = false" @input="open = true"
                                        class="w-full input" :placeholder="placeholder" wire:model="instance_timezone">
                                    <svg class="absolute right-0 mr-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                        @click="open = true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                    </svg>
                                </div>
                                <div x-show="open"
                                    class="overflow-auto overflow-x-hidden absolute z-50 mt-1 w-full max-h-60 bg-white rounded-md border shadow-lg dark:bg-coolgray-100 dark:border-coolgray-200 scrollbar">
                                    <template
                                        x-for="timezone in timezones.filter(tz => tz.toLowerCase().includes(search.toLowerCase()))"
                                        :key="timezone">
                                        <div @click="search = timezone; open = false; $wire.set('instance_timezone', timezone); $wire.submit()"
                                            class="px-4 py-2 text-gray-800 cursor-pointer hover:bg-gray-100 dark:hover:bg-coolgray-300 dark:text-gray-200"
                                            x-text="timezone"></div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 md:flex-row flex-col w-full">
                        <x-forms.input id="public_ipv4" type="password" label="Публічний IPv4 екземпляра"
                            helper="Введіть IPv4-адресу екземпляра.<br><br>Це корисно, якщо у вас є кілька IPv4-адрес і Coolify не зміг визначити правильну."
                            placeholder="1.2.3.4" autocomplete="new-password" />
                        <x-forms.input id="public_ipv6" type="password" label="Публічний IPv6 екземпляра"
                            helper="Введіть IPv6-адресу екземпляра.<br><br>Це корисно, якщо у вас є кілька IPv6-адрес і Coolify не зміг визначити правильну."
                            placeholder="2001:db8::1" autocomplete="new-password" />
                    </div>
                </div>
            </div>
        </form>
        
        <x-domain-conflict-modal 
            :conflicts="$domainConflicts" 
            :showModal="$showDomainConflictModal" 
            confirmAction="confirmDomainUsage">
            <x-slot:consequences>
                <ul class="mt-2 ml-4 list-disc">
                    <li>Домен екземпляра Coolify конфліктуватиме з наявними ресурсами</li>
                    <li>Сертифікати SSL можуть працювати некоректно</li>
                    <li>Поведінка маршрутизації буде непередбачуваною</li>
                    <li>Ви можете не отримати доступ до панелі керування Coolify належним чином</li>
                </ul>
            </x-slot:consequences>
        </x-domain-conflict-modal>
    </div>
</div>