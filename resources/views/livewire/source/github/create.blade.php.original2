@can('createAnyResource')
    <form wire:submit='createGitHubApp' class="flex flex-col w-full gap-2">
        <div class="pb-2">Це обов'язково, якщо ви бажаєте отримати повну інтеграцію (розгортання комітів/пул-реквестів
            тощо)
            з GitHub.</div>
        <div class="flex gap-2">
            <x-forms.input id="name" label="Назва" required />
            <x-forms.input helper="Якщо порожньо, буде використано ваш користувач GitHub."
                placeholder="Якщо порожньо, буде використано ваш користувач GitHub." id="organization" label="Організація (на GitHub)" />
        </div>
        @if (!isCloud())
            <div x-data="{ showWarning: @entangle('is_system_wide') }">
                <div class="w-48">
                    <x-forms.checkbox id="is_system_wide" label="Загальносистемний"
                        helper="Якщо встановлено, цей додаток GitHub буде доступний для всіх користувачів цього екземпляра Coolify." />
                </div>
                <div x-show="showWarning" x-transition x-cloak class="w-full max-w-2xl mx-auto pt-2">
                    <x-callout type="warning" title="Не рекомендовано">
                        <div class="whitespace-normal break-words">
                            Загальносистемні додатки GitHub надаються всім командам цього екземпляра Coolify. Це означає, що будь-яка команда
                            може використовувати цей додаток GitHub для розгортання програм з ваших репозиторіїв. Для кращої безпеки та
                            ізоляції рекомендується створювати додатки GitHub для конкретних команд.
                        </div>
                    </x-callout>
                </div>
            </div>
        @endif
        <div x-data="{
                                activeAccordion: '',
                                setActiveAccordion(id) {
                                    this.activeAccordion = (this.activeAccordion == id) ? '' : id
                                }
                            }" class="relative w-full py-2 mx-auto overflow-hidden text-sm font-normal rounded-md">
            <div x-data="{ id: $id('accordion') }" class="cursor-pointer">
                <button @click="setActiveAccordion(id)"
                    class="flex items-center justify-between w-full px-1 py-2 text-left select-none dark:hover:text-white hover:bg-white/5"
                    type="button">
                    <h4>Самостійно розміщений / Корпоративний GitHub</h4>
                    <svg class="w-4 h-4 duration-200 ease-out" :class="{ 'rotate-180': activeAccordion == id }"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <div x-show="activeAccordion==id" x-collapse x-cloak class="px-2">
                    <div class="flex flex-col gap-2 pt-0 opacity-70">
                        <div class="flex gap-2">
                            <x-forms.input id="html_url" label="HTML URL" required />
                            <x-forms.input id="api_url" label="API URL" required />
                        </div>
                        <div class="flex gap-2">
                            <x-forms.input id="custom_user" label="Користувацький користувач Git" required />
                            <x-forms.input id="custom_port" type="number" label="Користувацький порт Git" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-forms.button class="mt-4" type="submit">
            Продовжити
        </x-forms.button>
    </form>
@else
    <x-callout type="warning" title="Потрібен дозвіл">
        У вас немає дозволу на створення нових додатків GitHub. Будь ласка, зв'яжіться з адміністратором вашої команди для отримання доступу.
    </x-callout>
@endcan