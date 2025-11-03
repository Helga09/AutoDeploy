<div>
    <x-slot:title>
        Підписка | Coolify
    </x-slot>
    @if (auth()->user()->isAdminFromSession())
        @if (request()->query->get('cancelled'))
            <div class="mb-6 rounded-sm alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Щось пішло не так з вашою підпискою. Будь ласка, спробуйте знову або зв'яжіться зі службою
                    підтримки.</span>
            </div>
        @endif
        <div class="flex gap-2">
            <h1>Підписки</h1>
        </div>
        @if ($loading)
            <div class="flex gap-2" wire:init="getStripeStatus">
                Завантаження статусу вашої підписки...
            </div>
        @else
            @if ($isUnpaid)
                <div class="mb-6 rounded-sm alert-error">
                    <span>Ваш останній платіж для Coolify Cloud не вдався.</span>
                </div>
                <div>
                    <p class="mb-2">Відкрийте наступне посилання, перейдіть до кнопки та сплатіть свою
                        несплачену/прострочену підписку.
                    </p>
                    <x-forms.button wire:click='stripeCustomerPortal'>Платіжний портал</x-forms.button>
                </div>
            @else
                @if (config('subscription.provider') === 'stripe')
                    <div @class([
                        'pb-4' => $isCancelled,
                        'pb-10' => !$isCancelled,
                    ])>
                        @if ($isCancelled)
                            <div class="alert-error">
                                <span>Схоже, вашу попередню підписку було скасовано, оскільки ви забули сплатити
                                    рахунки.<br />Будь ласка, підпишіться знову, щоб продовжувати користуватися
                                    Coolify.</span>
                            </div>
                        @endif
                    </div>
                    <livewire:subscription.pricing-plans />
                @endif
            @endif
        @endif
    @else
        <div class="flex flex-col justify-center mx-10">
            <div class="flex gap-2">
                <h1>Підписка</h1>
            </div>
            <x-callout type="warning" title="Потрібен дозвіл">
                Ви не є адміністратором, тому не можете керувати підпискою вашої команди. Якщо це незрозуміло, будь
                ласка,
                <span class="underline cursor-pointer dark:text-white" wire:click="help">зв'яжіться з нами</span>.
            </x-callout>
        </div>
    @endif
</div>