@props([
    'title' => 'Ви впевнені?',
    'isErrorButton' => false,
    'isHighlightedButton' => false,
    'buttonTitle' => 'Підтвердити дію',
    'buttonFullWidth' => false,
    'customButton' => null,
    'disabled' => false,
    'dispatchAction' => false,
    'submitAction' => 'delete',
    'content' => null,
    'checkboxes' => [],
    'actions' => [],
    'warningMessage' => null,
    'confirmWithText' => true,
    'confirmationText' => 'Підтвердити видалення',
    'confirmationLabel' => 'Будь ласка, підтвердьте виконання дій, ввівши Назву нижче',
    'shortConfirmationLabel' => 'Назва',
    'confirmWithPassword' => true,
    'step1ButtonText' => 'Продовжити',
    'step2ButtonText' => 'Продовжити',
    'step3ButtonText' => 'Підтвердити',
    'dispatchEvent' => false,
    'dispatchEventType' => 'success',
    'dispatchEventMessage' => '',
    'ignoreWire' => true,
    'temporaryDisableTwoStepConfirmation' => false,
])

@php
    use App\Models\InstanceSettings;
    $disableTwoStepConfirmation = data_get(InstanceSettings::get(), 'disable_two_step_confirmation');
    if ($temporaryDisableTwoStepConfirmation) {
        $disableTwoStepConfirmation = false;
    }
@endphp

<div {{ $ignoreWire ? 'wire:ignore' : '' }} x-data="{
    modalOpen: false,
    step: {{ empty($checkboxes) ? 2 : 1 }},
    initialStep: {{ empty($checkboxes) ? 2 : 1 }},
    finalStep: {{ $confirmWithPassword && !$disableTwoStepConfirmation ? 3 : 2 }},
    deleteText: '',
    password: '',
    actions: @js($actions),
    confirmationText: (() => {
        const textarea = document.createElement('textarea');
        textarea.innerHTML = @js($confirmationText);
        return textarea.value;
    })(),
    userConfirmationText: '',
    confirmWithText: @js($confirmWithText && !$disableTwoStepConfirmation),
    confirmWithPassword: @js($confirmWithPassword && !$disableTwoStepConfirmation),
    submitAction: @js($submitAction),
    dispatchAction: @js($dispatchAction),
    passwordError: '',
    selectedActions: @js(collect($checkboxes)->pluck('id')->filter(fn($id) => $this->$id)->values()->all()),
    dispatchEvent: @js($dispatchEvent),
    dispatchEventType: @js($dispatchEventType),
    dispatchEventMessage: @js($dispatchEventMessage),
    disableTwoStepConfirmation: @js($disableTwoStepConfirmation),
    resetModal() {
        this.step = this.initialStep;
        this.deleteText = '';
        this.password = '';
        this.userConfirmationText = '';
        this.selectedActions = @js(collect($checkboxes)->pluck('id')->filter(fn($id) => $this->$id)->values()->all());
        $wire.$refresh();
    },
    step1ButtonText: @js($step1ButtonText),
    step2ButtonText: @js($step2ButtonText),
    step3ButtonText: @js($step3ButtonText),
    validatePassword() {
        if (this.confirmWithPassword && !this.password) {
            return 'Пароль обов’язковий.';
        }
        return '';
    },
    submitForm() {
        if (this.confirmWithPassword) {
            this.passwordError = this.validatePassword();
            if (this.passwordError) {
                return Promise.resolve(this.passwordError);
            }
        }
        if (this.dispatchAction) {
            $wire.dispatch(this.submitAction);
            return true;
        }

        const methodName = this.submitAction.split('(')[0];
        const paramsMatch = this.submitAction.match(/\((.*?)\)/);
        const params = paramsMatch ? paramsMatch[1].split(',').map(param => param.trim()) : [];

        if (this.confirmWithPassword) {
            params.push(this.password);
        }
        params.push(this.selectedActions);
        return $wire[methodName](...params)
            .then(result => {
                if (result === true) {
                    return true;
                } else if (typeof result === 'string') {
                    return result;
                }
            });
    },
    toggleAction(id) {
        const index = this.selectedActions.indexOf(id);
        if (index > -1) {
            this.selectedActions.splice(index, 1);
        } else {
            this.selectedActions.push(id);
        }
    }
}"
    @keydown.escape.window="if (modalOpen) { modalOpen = false; resetModal(); }" :class="{ 'z-40': modalOpen }"
    class="relative w-auto h-auto">
    @if ($customButton)
        @if ($buttonFullWidth)
            <x-forms.button @click="modalOpen=true" class="w-full">
                {{ $customButton }}
            </x-forms.button>
        @else
            <x-forms.button @click="modalOpen=true">
                {{ $customButton }}
            </x-forms.button>
        @endif
    @else
        @if ($content)
            <div @click="modalOpen=true">
                {{ $content }}
            </div>
        @else
            @if ($disabled)
                @if ($buttonFullWidth)
                    <x-forms.button class="w-full" isError disabled wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @else
                    <x-forms.button isError disabled wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @endif
            @elseif ($isErrorButton)
                @if ($buttonFullWidth)
                    <x-forms.button class="w-full" isError @click="modalOpen=true">
                        {{ $buttonTitle }}
                    </x-forms.button>
                @else
                    <x-forms.button isError @click="modalOpen=true">
                        {{ $buttonTitle }}
                    </x-forms.button>
                @endif
            @elseif($isHighlightedButton)
                @if ($buttonFullWidth)
                    <x-forms.button @click="modalOpen=true" class="flex gap-2 w-full" isHighlighted wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @else
                    <x-forms.button @click="modalOpen=true" class="flex gap-2" isHighlighted wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @endif
            @else
                @if ($buttonFullWidth)
                    <x-forms.button @click="modalOpen=true" class="flex gap-2 w-full" wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @else
                    <x-forms.button @click="modalOpen=true" class="flex gap-2" wire:target>
                        {{ $buttonTitle }}
                    </x-forms.button>
                @endif
            @endif
        @endif
    @endif
    <template x-teleport="body">
        <div x-show="modalOpen"
            class="fixed top-0 left-0 z-99 flex items-center justify-center w-screen h-screen p-4" x-cloak>
            <div x-show="modalOpen" class="absolute inset-0 w-full h-full bg-black/20 backdrop-blur-xs">
            </div>
            <div x-show="modalOpen" x-trap.inert.noscroll="modalOpen" x-transition:enter="ease-out duration-100"
                x-transition:enter-start="opacity-0 -translate-y-2 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-100"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 -translate-y-2 sm:scale-95"
                class="relative w-full border rounded-sm min-w-full lg:min-w-[36rem] max-w-[48rem] max-h-[calc(100vh-2rem)] bg-neutral-100 border-neutral-400 dark:bg-base dark:border-coolgray-300 flex flex-col">
                <div class="flex justify-between items-center py-6 px-7 shrink-0">
                    <h3 class="pr-8 text-2xl font-bold">{{ $title }}</h3>
                    <button @click="modalOpen = false; resetModal()"
                        class="flex absolute top-2 right-2 justify-center items-center w-8 h-8 rounded-full dark:text-white hover:bg-coolgray-300">
                        <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="relative w-auto overflow-y-auto px-7 pb-6" style="-webkit-overflow-scrolling: touch;">
                    @if (!empty($checkboxes))
                        <!-- Step 1: Select actions -->
                        <div x-show="step === 1">
                            @foreach ($checkboxes as $index => $checkbox)
                                <div class="flex justify-between items-center mb-2">
                                    <x-forms.checkbox fullWidth :label="$checkbox['label']" :id="$checkbox['id']"
                                        :wire:model="$checkbox['id']"
                                        x-on:change="toggleAction('{{ $checkbox['id'] }}')" :checked="$this->{$checkbox['id']}"
                                        x-bind:checked="selectedActions.includes('{{ $checkbox['id'] }}')" />
                                </div>
                            @endforeach

                            <div class="flex flex-wrap gap-2 justify-between mt-4">
                                <x-forms.button @click="modalOpen = false; resetModal()"
                                    class="w-24 dark:bg-coolgray-200 dark:hover:bg-coolgray-300">
                                    Скасувати
                                </x-forms.button>
                                <x-forms.button @click="step++" class="w-auto" isError>
                                    <span x-text="step1ButtonText"></span>
                                </x-forms.button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </template>
</div>