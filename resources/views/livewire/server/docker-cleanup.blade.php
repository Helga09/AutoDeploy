<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Очищення Docker | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="docker-cleanup" />
        <div class="w-full">
            <form wire:submit='submit'>
                <div>
                    <div class="flex items-center gap-2">
                        <h2>Очищення Docker</h2>
                        <x-forms.button type="submit" canGate="update" :canResource="$server">Зберегти</x-forms.button>
                        @can('update', $server)
                            <x-modal-confirmation title="Підтвердити очищення Docker?" buttonTitle="Запустити ручне очищення"
                                isHighlightedButton submitAction="manualCleanup" :actions="[
                                    'Назавжди видаляє всі зупинені контейнери, керовані AutoDeploy (оскільки контейнери є непостійними, дані не будуть втрачені)',
                                    'Назавжди видаляє всі невикористовувані образи',
                                    'Очищує кеш збірки',
                                    'Видаляє старі версії допоміжного образу AutoDeploy',
                                    'За бажанням, назавжди видаляє всі невикористовувані томи (якщо увімкнено в розширених налаштуваннях).',
                                    'За бажанням, назавжди видаляє всі невикористовувані мережі (якщо увімкнено в розширених налаштуваннях).',
                                ]" :confirmWithText="false"
                                :confirmWithPassword="false" step2ButtonText="Запустити очищення Docker" />
                        @endcan
                    </div>
                    <div class="mt-1 mb-6">Налаштуйте параметри очищення Docker для вашого сервера.</div>
                </div>

                <div class="flex flex-col gap-2">
                    <div class="flex gap-4">
                        <h3>Конфігурація очищення</h3>
                    </div>
                    <div class="flex items-center gap-4">
                        <x-forms.input canGate="update" :canResource="$server" placeholder="*/10 * * * *"
                            id="dockerCleanupFrequency" label="Частота очищення Docker" required
                            helper="Cron вираз для очищення Docker.<br>Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly.<br><br>За замовчуванням – щоночі опівночі." />
                        @if (!$forceDockerCleanup)
                            <x-forms.input canGate="update" :canResource="$server" id="dockerCleanupThreshold"
                                label="Поріг очищення Docker (%)" required
                                helper="Завдання очищення Docker будуть виконуватися, коли використання диска перевищить цей поріг." />
                        @endif
                    </div>
                    <div class="w-full sm:w-96">
                        <x-forms.checkbox canGate="update" :canResource="$server"
                            helper="Увімкнення примусового очищення Docker або ручний запуск очищення виконає наступні дії:
                            <ul class='list-disc pl-4 mt-2'>
                                <li>Видаляє зупинені контейнери, керовані AutoDeploy (оскільки контейнери є непостійними, дані не будуть втрачені).</li>
                                <li>Видаляє невикористовувані образи.</li>
                                <li>Очищує кеш збірки.</li>
                                <li>Видаляє старі версії допоміжного образу AutoDeploy.</li>
                                <li>За бажанням, видаляє невикористовувані томи (якщо увімкнено в розширених налаштуваннях).</li>
                                <li>За бажанням, видаляє невикористовувані мережі (якщо увімкнено в розширених налаштуваннях).</li>
                            </ul>"
                            instantSave id="forceDockerCleanup" label="Примусове очищення Docker" />
                    </div>

                </div>

                <div class="flex flex-col gap-2 mt-6">
                    <h3>Додатково</h3>
                    <x-callout type="warning" title="Увага">
                        <p>Ці параметри можуть призвести до незворотної втрати даних та функціональних проблем. Увімкніть їх лише в тому випадку, якщо ви повністю розумієте наслідки.</p>
                    </x-callout>
                    <div class="w-full sm:w-96">
                        <x-forms.checkbox canGate="update" :canResource="$server" instantSave id="deleteUnusedVolumes"
                            label="Видалити невикористовувані томи"
                            helper="Цей параметр видалить всі невикористовувані томи Docker під час очищення.<br><br><strong>Увага: Дані зі зупинених контейнерів будуть втрачені!</strong><br><br>Наслідки включають:<br>
                            <ul class='list-disc pl-4 mt-2'>
                                <li>Томи, не приєднані до запущених контейнерів, будуть назавжди видалені (це стосується томів зі зупинених контейнерів).</li>
                                <li>Дані, що зберігаються у видалених томах, не можуть бути відновлені.</li>
                            </ul>" />
                        <x-forms.checkbox canGate="update" :canResource="$server" instantSave id="deleteUnusedNetworks"
                            label="Видалити невикористовувані мережі"
                            helper="Цей параметр видалить всі невикористовувані мережі Docker під час очищення.<br><br><strong>Увага: Функціональність може бути втрачена, і контейнери можуть втратити можливість зв'язуватися один з одним!</strong><br><br>Наслідки включають:<br>
                            <ul class='list-disc pl-4 mt-2'>
                                <li>Мережі, не приєднані до запущених контейнерів, будуть назавжди видалені (це стосується мереж, що використовуються зупиненими контейнерами).</li>
                                <li>Контейнери можуть втратити з'єднання, якщо необхідні мережі будуть видалені.</li>
                            </ul>" />
                    </div>
                </div>
            </form>

            <div class="mt-8">
                <h3 class="mb-4">Недавні виконання <span class="text-xs text-neutral-500">(натисніть, щоб перевірити
                        вивід)</span></h3>
                <livewire:server.docker-cleanup-executions :server="$server" />
            </div>
        </div>
    </div>
</div>