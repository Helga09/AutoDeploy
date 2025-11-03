<div>
    <x-slot:title>
        Автоматичне оновлення | Coolify
    </x-slot>
    <x-settings.navbar />
    <div x-data="{ activeTab: window.location.hash ? window.location.hash.substring(1) : 'general' }" class="flex flex-col h-full gap-8 sm:flex-row">
        <x-settings.sidebar activeMenu="updates" />
        <form wire:submit='submit' class="flex flex-col w-full">
            <div class="flex items-center gap-2">
                <h2>Оновлення</h2>
                <x-forms.button type="submit">
                    Зберегти
                </x-forms.button>
            </div>
            <div class="pb-4">Налаштування оновлень вашого інстансу.</div>


            <div class="flex flex-col gap-2">
                <div class="flex items-end gap-2">
                    <x-forms.input required id="update_check_frequency" label="Частота перевірки оновлень"
                        placeholder="0 * * * *"
                        helper="Частота (cron-вираз) для перевірки нових версій Coolify та завантаження нових шаблонів сервісів з CDN.<br>Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly.<br><br>За замовчуванням – щогодини." />
                    <x-forms.button wire:click='checkManually'>Перевірити вручну</x-forms.button>
                </div>

                <h4 class="pt-4">Автоматичне оновлення</h4>

                <div class="text-right md:w-64">
                    @if (!is_null(config('constants.coolify.autoupdate', null)))
                        <div class="text-right">
                            <x-forms.checkbox instantSave
                                helper="Параметр AUTOUPDATE встановлено у файлі .env, вам потрібно змінити його там." disabled
                                checked="{{ config('constants.coolify.autoupdate') }}" label="Увімкнено" />
                        </div>
                    @else
                        <x-forms.checkbox instantSave id="is_auto_update_enabled" label="Увімкнено" />
                    @endif
                </div>
                @if (is_null(config('constants.coolify.autoupdate', null)) && $is_auto_update_enabled)
                    <x-forms.input required id="auto_update_frequency" label="Частота (cron-вираз)"
                        placeholder="0 0 * * *"
                        helper="Частота (cron-вираз) (автоматичне оновлення coolify).<br>Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly.<br><br>За замовчуванням – щодня о 00:00" />
                @else
                    <x-forms.input required label="Частота (cron-вираз)" disabled placeholder="вимкнено"
                        helper="Частота (cron-вираз) (автоматичне оновлення coolify).<br>Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly.<br><br>За замовчуванням – щодня о 00:00" />
                @endif
            </div>

        </form>
    </div>
</div>