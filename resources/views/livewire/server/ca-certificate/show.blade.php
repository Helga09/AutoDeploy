<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Сертифікат CA | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="ca-certificate" />
        <div class="flex flex-col gap-4">
            <div class="flex items-center gap-2">
                <h2>Сертифікат CA</h2>
                @can('update', $server)
                    <div class="flex gap-2">
                        <x-modal-confirmation title="Підтвердити зміну сертифіката CA?" buttonTitle="Зберегти"
                            submitAction="saveCaCertificate" :actions="[
                                'Це перезапише наявний сертифікат CA за адресою /data/AutoDeploy/ssl/AutoDeploy-ca.crt вашим власним сертифікатом CA.',
                                'Це повторно згенерує всі SSL-сертифікати для баз даних на цьому сервері та підпише їх вашим власним CA.',
                                'Ви повинні вручну перерозгорнути всі ваші бази даних на цьому сервері, щоб вони використовували нові SSL-сертифікати, підписані вашим новим сертифікатом CA.',
                                'Через кешування вам, ймовірно, також потрібно буде перерозгорнути всі ваші ресурси на цьому сервері, які використовують цей сертифікат CA.',
                            ]"
                            confirmationText="/data/AutoDeploy/ssl/AutoDeploy-ca.crt" shortConfirmationLabel="Шлях до сертифіката CA"
                            step3ButtonText="Зберегти сертифікат">
                        </x-modal-confirmation>
                        <x-modal-confirmation title="Підтвердити повторну генерацію сертифіката?" buttonTitle="Відновити "
                            submitAction="regenerateCaCertificate" :actions="[
                                'Це згенерує новий сертифікат CA за адресою /data/AutoDeploy/ssl/AutoDeploy-ca.crt та замінить існуючий.',
                                'Це повторно згенерує всі SSL-сертифікати для баз даних на цьому сервері та підпише їх новим сертифікатом CA.',
                                'Ви повинні вручну перерозгорнути всі ваші бази даних на цьому сервері, щоб вони використовували нові SSL-сертифікати, підписані новим сертифікатом CA.',
                                'Через кешування вам, ймовірно, також потрібно буде перерозгорнути всі ваші ресурси на цьому сервері, які використовують цей сертифікат CA.',
                            ]"
                            confirmationText="/data/AutoDeploy/ssl/AutoDeploy-ca.crt" shortConfirmationLabel="Шлях до сертифіката CA"
                            step3ButtonText="Відновити сертифікат">
                        </x-modal-confirmation>
                    </div>
                @endcan
            </div>
            <div class="space-y-4">
                <div class="text-sm">
                    <p class="font-medium mb-2">Рекомендована конфігурація:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Змонтуйте цей сертифікат CA AutoDeploy у всі контейнери, яким потрібно підключитися до однієї з
                            ваших баз даних через SSL. Ви можете побачити та скопіювати точку монтування нижче.</li>
                        <li>Дізнайтеся більше про те, коли і чому це потрібно <a class="underline dark:text-white"
                                href="https://AutoDeploy.io/docs/databases/ssl" target="_blank">тут</a>.</li>
                    </ul>
                </div>
                <div class="relative">
                    <x-forms.copy-button text="- /data/AutoDeploy/ssl/AutoDeploy-ca.crt:/etc/ssl/certs/AutoDeploy-ca.crt:ro" />
                </div>
            </div>
            <div>
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <span class="text-sm">Сертифікат CA</span>
                        @if ($certificateValidUntil)
                            <span class="text-sm">(Дійсний до:
                                @if (now()->gt($certificateValidUntil))
                                    <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} -
                                        Прострочено)</span>
                                @elseif(now()->addDays(30)->gt($certificateValidUntil))
                                    <span class="text-red-500">{{ $certificateValidUntil->format('d.m.Y H:i:s') }} -
                                        Незабаром закінчується)</span>
                                @else
                                    <span>{{ $certificateValidUntil->format('d.m.Y H:i:s') }})</span>
                                @endif
                            </span>
                        @endif
                    </div>
                    @can('view', $server)
                        <x-forms.button wire:click="toggleCertificate" type="button" class="py-1! px-2! text-sm">
                            {{ $showCertificate ? 'Сховати' : 'Показати' }}
                        </x-forms.button>
                    @endcan
                </div>
                @if ($showCertificate)
                    <textarea class="w-full h-[370px] input" wire:model="certificateContent"
                        placeholder="Вставте або відредагуйте вміст сертифіката CA тут..."></textarea>
                @else
                    <div class="w-full h-[370px] input">
                        <div class="h-full flex flex-col items-center justify-center text-gray-300">
                            <div class="mb-2">
                                ━━━━━━━━ ВМІСТ СЕРТИФІКАТА ━━━━━━━━
                            </div>
                            <div class="text-sm">
                                Натисніть "Показати", щоб переглянути або відредагувати
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>