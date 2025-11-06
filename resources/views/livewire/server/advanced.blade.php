<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Додатково | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="advanced" />
        <form wire:submit='submit' class="w-full">
            <div>
                <div class="flex items-center gap-2">
                    <h2>Розширені налаштування</h2>
                    <x-forms.button canGate="update" :canResource="$server" type="submit">Зберегти</x-forms.button>
                </div>
                <div class="mb-4">Розширені налаштування для вашого сервера.</div>
            </div>

            <h3>Використання диска</h3>
            <div class="flex flex-col gap-6">
                <div class="flex flex-col">
                    <div class="flex flex-wrap gap-2 sm:flex-nowrap pt-4">
                        <x-forms.input canGate="update" :canResource="$server" placeholder="0 23 * * *"
                            id="serverDiskUsageCheckFrequency" label="Частота перевірки використання диска" required
                            helper="Cron-вираз для частоти перевірки використання диска.<br>Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly.<br><br>За замовчуванням: щоночі о 23:00." />
                        <x-forms.input canGate="update" :canResource="$server" id="serverDiskUsageNotificationThreshold"
                            label="Поріг сповіщення про використання диска сервера (%)" required
                            helper="Якщо використання диска сервера перевищить цей поріг, AutoDeploy надішле сповіщення." />
                    </div>
                </div>

                <div class="flex flex-col">
                    <h3>Збірки</h3>
                    <div class="flex flex-wrap gap-2 sm:flex-nowrap pt-4">
                        <x-forms.input canGate="update" :canResource="$server" id="concurrentBuilds"
                            label="Кількість одночасних збірок" required
                            helper="Ви можете вказати кількість одночасних процесів збірки/розгортання, які повинні виконуватися паралельно." />
                        <x-forms.input canGate="update" :canResource="$server" id="dynamicTimeout"
                            label="Таймаут розгортання (секунди)" required
                            helper="Ви можете визначити максимальну тривалість виконання розгортання до його тайм-ауту." />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>