<div>
    <x-slot:title>
        Розширені Налаштування | Coolify
        </x-slot>
        <x-settings.navbar />
        <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }"
            class="flex flex-col h-full gap-8 sm:flex-row">
            <x-settings.sidebar activeMenu="advanced" />
            <form wire:submit='submit' class="flex flex-col w-full">
                <div class="flex items-center gap-2">
                    <h2>Розширені</h2>
                    <x-forms.button type="submit">
                        Зберегти
                    </x-forms.button>
                </div>
                <div class="pb-4">Розширені налаштування для вашого екземпляра Coolify.</div>

                <div class="flex flex-col gap-1">
                    <div class="md:w-96">
                        <x-forms.checkbox instantSave id="is_registration_enabled"
                            helper="Якщо увімкнено, користувачі можуть реєструватися самостійно. Якщо вимкнено, лише адміністратори можуть створювати нових користувачів."
                            label="Дозволена Реєстрація" />
                    </div>
                    <div class="md:w-96">
                        <x-forms.checkbox instantSave id="do_not_track"
                            helper="Якщо увімкнено, Coolify не буде відстежувати жодних даних. Це корисно, якщо ви стурбовані конфіденційністю."
                            label="Не Відстежувати" />
                    </div>
                    <h4 class="pt-4">Налаштування DNS</h4>
                    <div class="md:w-96">
                        <x-forms.checkbox instantSave id="is_dns_validation_enabled"
                            helper="Якщо ви встановлюєте власний домен, Coolify перевірятиме його у вашому DNS-провайдері."
                            label="Валідація DNS" />
                    </div>

                    <x-forms.input id="custom_dns_servers" label="Власні DNS-сервери"
                        helper="DNS-сервери для перевірки доменів. Список DNS-серверів, розділених комою."
                        placeholder="1.1.1.1,8.8.8.8" />
                    <h4 class="pt-4">Налаштування API</h4>
                    <div class="md:w-96">
                        <x-forms.checkbox instantSave id="is_api_enabled" label="Доступ до API"
                            helper="Якщо увімкнено, API буде активним. Якщо вимкнено, API буде деактивовано." />
                    </div>
                    <x-forms.input id="allowed_ips" label="Дозволені IP для доступу до API"
                        helper="Дозволені IP-адреси або підмережі для доступу до API.&lt;br&gt;Підтримуються окремі IP (192.168.1.100) та нотація CIDR (192.168.1.0/24).&lt;br&gt;Використовуйте кому для розділення кількох записів.&lt;br&gt;Використовуйте 0.0.0.0 або залиште порожнім, щоб дозволити доступ з будь-якого місця."
                        placeholder="192.168.1.100,10.0.0.0/8,203.0.113.0/24" />
                    @if (empty($allowed_ips) || in_array('0.0.0.0', array_map('trim', explode(',', $allowed_ips ?? ''))))
                        <x-callout type="warning" title="Попередження" class="mt-2">
                            Використання 0.0.0.0 (або порожнього значення) дозволяє доступ до API з будь-якого місця. Це не рекомендується для виробничих середовищ!
                        </x-callout>
                    @endif
                    <h4 class="pt-4">Налаштування Підтвердження</h4>
                    <div class="md:w-96">
                        <x-forms.checkbox instantSave id=" is_sponsorship_popup_enabled" label="Показувати Спливаюче Вікно Спонсорства"
                            helper="Коли увімкнено, спливаючі вікна спонсорства відображатимуться користувачам щомісяця. Коли вимкнено, спливаюче вікно спонсорства буде постійно приховано для всіх користувачів." />
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    @if ($disable_two_step_confirmation)
                        <div class="pb-4 md:w-96" wire:key="two-step-confirmation-enabled">
                            <x-forms.checkbox instantSave id="disable_two_step_confirmation"
                                label="Вимкнути Двохетапне Підтвердження"
                                helper="Коли вимкнено, вам не потрібно буде підтверджувати дії текстом і паролем користувача. Це значно знижує безпеку і може призвести до випадкових видалень або небажаних змін. Використовуйте з надзвичайною обережністю, особливо на виробничих серверах." />
                        </div>
                    @else
                                    <div class="pb-4 flex items-center justify-between gap-2 md:w-96"
                                        wire:key="two-step-confirmation-disabled">
                                        <label class="flex items-center gap-2">
                                            Вимкнути Двохетапне Підтвердження
                                            <x-helper
                                                helper="Коли вимкнено, вам не потрібно буде підтверджувати дії текстом і паролем користувача. Це значно знижує безпеку і може призвести до випадкових видалень або небажаних змін. Використовуйте з надзвичайною обережністю, особливо на виробничих серверах.">
                                            </x-helper>
                                        </label>
                                        <x-modal-confirmation title="Вимкнути Двохетапне Підтвердження?" buttonTitle="Вимкнути" isErrorButton
                                            submitAction="toggleTwoStepConfirmation" :actions="[
                            'Двохетапне підтвердження буде вимкнено глобально.',
                            'Вимкнення двохетапного підтвердження знижує безпеку (оскільки будь-хто може легко видалити що завгодно).',
                            'Ризик випадкових дій зросте.',
                        ]"
                                            confirmationText="ВИМКНУТИ ДВОХЕТАПНЕ ПІДТВЕРДЖЕННЯ"
                                            confirmationLabel="Будь ласка, введіть текст підтвердження, щоб вимкнути двохетапне підтвердження."
                                            shortConfirmationLabel="Текст підтвердження" />
                                    </div>
                                    <x-callout type="danger" title="Увага!" class="mb-4">
                                        Вимкнення двохетапного підтвердження знижує безпеку (оскільки будь-хто може легко видалити що завгодно) та
                                        збільшує ризик випадкових дій. Це не рекомендується для виробничих серверів.
                                    </x-callout>
                    @endif
                </div>
            </form>
        </div>
</div>