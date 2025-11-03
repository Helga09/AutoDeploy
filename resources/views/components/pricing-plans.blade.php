@props([
    'showSubscribeButtons' => true,
])
<div x-data="{ selected: 'monthly' }" class="w-full pb-20">
    <div class="px-6 mx-auto lg:px-8">
        <div class="flex justify-center">
            <fieldset
                class="grid grid-cols-2 p-1 text-xs font-semibold leading-5 text-center rounded-sm dark:text-white gap-x-1 bg-white/5">
                <legend class="sr-only">Частота платежів</legend>
                <label class="cursor-pointer rounded-sm px-2.5 py-1"
                    :class="selected === 'monthly' ? 'bg-coollabs-100 text-white' : ''">
                    <input type="radio" x-on:click="selected = 'monthly'" name="frequency" value="monthly"
                        class="sr-only">
                    <span>Щомісячно</span>
                </label>
                <label class="cursor-pointer rounded-sm px-2.5 py-1"
                    :class="selected === 'yearly' ? 'bg-coollabs-100 text-white' : ''">
                    <input type="radio" x-on:click="selected = 'yearly'" name="frequency" value="annually"
                        class="sr-only">
                    <span>Щорічно</span>
                </label>
            </fieldset>
        </div>
        @if (config('constants.limits.trial_period') > 0)
            <div class="py-2 text-center"><span
                    class="font-bold dark:text-warning">{{ config('constants.limits.trial_period') }}
                    днів пробного періоду</span> включено у всі плани, без даних кредитної картки.</div>
        @endif
        <div x-show="selected === 'monthly'" class="flex justify-center h-10 mt-3 text-sm leading-6 ">
            <div>Заощаджуйте <span class="font-bold text-black dark:text-warning">10%</span> щорічно з річними планами.
            </div>
        </div>
        <div x-show="selected === 'yearly'" class="flex justify-center h-10 mt-3 text-sm leading-6 ">
            <div>
            </div>
        </div>
        <div class="p-4 rounded-sm bg-coolgray-400">
            <h2 id="tier-hobby" class="flex items-start gap-4 text-4xl font-bold tracking-tight">Необмежений пробний період
                <x-forms.button><a class="font-bold dark:text-white hover:no-underline"
                        href="https://github.com/coollabsio/coolify">Почати</a></x-forms.button>
            </h2>
            <p class="mt-4 text-sm leading-6">Почніть самостійний хостинг <span class="dark:text-warning">без обмежень</span>
                з нашою
                OSS версією. Ті ж функції, що й у платній версії, але вам доведеться керувати самостійно.</p>
        </div>

        <div class="flow-root mt-12">
            <div class="pb-10 text-xl text-center">Для детального списку функцій відвідайте нашу цільову сторінку: <a
                    class="font-bold underline dark:text-white" href="https://coolify.io">coolify.io</a></div>
            <div
                class="grid max-w-sm grid-cols-1 -mt-16 divide-y divide-neutral-200 dark:divide-coolgray-500 isolate gap-y-16 sm:mx-auto lg:-mx-8 lg:mt-0 lg:max-w-none lg:grid-cols-3 lg:divide-x lg:divide-y-0 xl:-mx-4">

                <div class="pt-16 lg:px-8 lg:pt-0 xl:px-14">
                    <h3 id="tier-basic" class="text-base font-semibold leading-7 dark:text-white">Базовий</h3>
                    <p class="flex items-baseline mt-6 gap-x-1">
                        <span x-show="selected === 'monthly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">$5</span>
                            <span class="text-sm font-semibold leading-6 ">/місяць + ПДВ</span>
                        </span>
                        <span x-show="selected === 'yearly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">$4</span>
                            <span class="text-sm font-semibold leading-6 ">/місяць + ПДВ</span>
                        </span>
                    </p>
                    <span x-show="selected === 'monthly'" x-cloak>
                        <span>оплата щомісяця</span>
                    </span>
                    <span x-show="selected === 'yearly'" x-cloak>
                        <span>оплата щорічно</span>
                    </span>
                    @if ($showSubscribeButtons)
                        @isset($basic)
                            {{ $basic }}
                        @endisset
                    @endif
                    <p class="mt-10 text-sm leading-6 dark:text-white h-[6.5rem]">Почніть розміщувати власні сервіси в хмарі.
                    </p>
                    <ul role="list" class="space-y-3 text-sm leading-6 ">
                        <li class="flex">
                            <svg class="flex-none w-5 h-6 mr-3 dark:text-warning" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.775 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Підключіть <span class="px-1 font-bold dark:text-white">2</span> серверів
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Включена система електронної пошти
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Підтримка електронною поштою
                        </li>
                        <li class="flex font-bold dark:text-white gap-x-3">
                            <svg width="512" height="512" class="flex-none w-5 h-6 text-green-600"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2">
                                    <path
                                        d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3-5a9 9 0 0 0 6-8a3 3 0 0 0-3-3a9 9 0 0 0-8 6a6 6 0 0 0-5 3" />
                                    <path d="M7 14a6 6 0 0 0-3 6a6 6 0 0 0 6-3m4-8a1 1 0 1 0 2 0a1 1 0 1 0-2 0" />
                                </g>
                            </svg>
                            + Всі майбутні функції
                        </li>
                    </ul>
                </div>
                <div class="pt-16 lg:px-8 lg:pt-0 xl:px-14">
                    <h3 id="tier-pro" class="text-base font-semibold leading-7 dark:text-white">Професійний</h3>
                    <p class="flex items-baseline mt-6 gap-x-1">
                        <span x-show="selected === 'monthly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">$30</span>
                            <span class="text-sm font-semibold leading-6 ">/місяць + ПДВ</span>
                        </span>
                        <span x-show="selected === 'yearly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">$27</span>
                            <span class="text-sm font-semibold leading-6 ">/місяць + ПДВ</span>
                        </span>
                    </p>
                    <span x-show="selected === 'monthly'" x-cloak>
                        <span>оплата щомісяця</span>
                    </span>
                    <span x-show="selected === 'yearly'" x-cloak>
                        <span>оплата щорічно</span>
                    </span>
                    @if ($showSubscribeButtons)
                        @isset($pro)
                            {{ $pro }}
                        @endisset
                    @endif
                    <p class="h-20 mt-10 text-sm leading-6 dark:text-white">Розширте свій бізнес або налаштуйте власне середовище хостингу.
                    </p>
                    <ul role="list" class="mt-6 space-y-3 text-sm leading-6 ">
                        <li class="flex ">
                            <svg class="flex-none w-5 h-6 mr-3 dark:text-warning" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Підключіть <span class="px-1 font-bold dark:text-white">10</span> серверів
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Включена система електронної пошти
                        </li>
                        <li class="flex gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Пріоритетна підтримка електронною поштою
                        </li>
                        <li class="flex font-bold dark:text-white gap-x-3">
                            <svg width="512" height="512" class="flex-none w-5 h-6 text-green-600"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2">
                                    <path
                                        d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3-5a9 9 0 0 0 6-8a3 3 0 0 0-3-3a9 9 0 0 0-8 6a6 6 0 0 0-5 3" />
                                    <path d="M7 14a6 6 0 0 0-3 6a6 6 0 0 0 6-3m4-8a1 1 0 1 0 2 0a1 1 0 1 0-2 0" />
                                </g>
                            </svg>
                            + Всі майбутні функції
                        </li>
                    </ul>
                </div>
                <div class="pt-16 lg:px-8 lg:pt-0 xl:px-12">
                    <h3 id="tier-ultimate" class="text-base font-semibold leading-7 dark:text-white">Преміум</h3>
                    <p class="flex items-baseline mt-6 gap-x-1">
                        <span x-show="selected === 'monthly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">Індивідуально</span>
                            {{-- <span class="text-sm font-semibold leading-6 ">pay-as-you-go</span> --}}
                        </span>
                        <span x-show="selected === 'yearly'" x-cloak>
                            <span class="text-4xl font-bold tracking-tight dark:text-white">Індивідуально</span>
                            {{-- <span class="text-sm font-semibold leading-6 ">/month + VAT</span> --}}
                        </span>
                    </p>
                    <span x-show="selected === 'monthly'" x-cloak>
                        <span>оплата за фактом використання</span>
                    </span>
                    <span x-show="selected === 'yearly'" x-cloak>
                        <span>оплата за фактом використання</span>
                    </span>
                    @if ($showSubscribeButtons)
                        @isset($ultimate)
                            {{ $ultimate }}
                        @endisset
                    @endif
                    <p class="h-20 mt-10 text-sm leading-6 dark:text-white">Легко керуйте складними інфраструктурами в одному місці.</p>
                    <ul role="list" class="mt-6 space-y-3 text-sm leading-6 ">
                        <li class="flex ">
                            <svg class="flex-none w-5 h-6 mr-3 dark:text-warning" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Підключіть <span class="px-1 font-bold dark:text-white">10+</span> серверів
                        </li>

                        <li class="flex gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Включена система електронної пошти
                        </li>
                        <li class="flex font-bold dark:text-white gap-x-3">
                            <svg class="flex-none w-5 h-6 dark:text-warning" viewBox="0 0 20 20" fill="currentColor"
                                aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                    clip-rule="evenodd" />
                            </svg>
                            Пріоритетна підтримка (електронна пошта/чат)
                        </li>
                        <li class="flex font-bold dark:text-white gap-x-3">
                            <svg width="512" height="512" class="flex-none w-5 h-6 text-green-600"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g fill="none" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2">
                                    <path
                                        d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3-5a9 9 0 0 0 6-8a3 3 0 0 0-3-3a9 9 0 0 0-8 6a6 6 0 0 0-5 3" />
                                    <path d="M7 14a6 6 0 0 0-3 6a6 6 0 0 0 6-3m4-8a1 1 0 1 0 2 0a1 1 0 1 0-2 0" />
                                </g>
                            </svg>
                            + Всі майбутні функції
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @isset($other)
        {{ $other }}
    @endisset