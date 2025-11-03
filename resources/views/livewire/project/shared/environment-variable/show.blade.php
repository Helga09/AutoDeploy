<div>
    <form wire:submit='submit' @class([
        'flex flex-col items-center gap-4 p-4 bg-white border lg:items-start dark:bg-base',
        'border-error' => $is_really_required,
        'dark:border-coolgray-300 border-neutral-200' => !$is_really_required,
    ])>
        @if ($isLocked)
            <div class="flex flex-1 w-full gap-2">
                <x-forms.input disabled id="key" />
                <svg class="icon  my-1" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M5 13a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v6a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-6z" />
                        <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0-2 0m-3-5V7a4 4 0 1 1 8 0v4" />
                    </g>
                </svg>
                @can('delete', $this->env)
                    <x-modal-confirmation title="Підтвердити видалення змінної середовища?" isErrorButton buttonTitle="Видалити"
                        submitAction="delete" :actions="['Вибрана змінна середовища буде безповоротно видалена.']" confirmationText="{{ $env->key }}"
                        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву змінної середовища нижче"
                        shortConfirmationLabel="Назва змінної середовища" :confirmWithPassword="false"
                        step2ButtonText="Видалити безповоротно" />
                @endcan
            </div>
            @can('update', $this->env)
                <div class="flex flex-col w-full gap-3">
                    <div class="flex flex-wrap w-full items-center gap-4">
                        @if (!$is_redis_credential)
                            @if ($type === 'service')
                                <x-forms.checkbox instantSave id="is_buildtime"
                                    helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                    label="Доступно під час збірки" />
                                <x-forms.checkbox instantSave id="is_runtime"
                                    helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                    label="Доступно під час виконання" />
                                <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                <x-forms.checkbox instantSave id="is_literal"
                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                    label="Буквальне значення?" />
                            @else
                                @if ($is_shared)
                                    <x-forms.checkbox instantSave id="is_literal"
                                        helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                        label="Буквальне значення?" />
                                @else
                                    @if ($isSharedVariable)
                                        <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                    @else
                                        @if (!$env->is_nixpacks)
                                            <x-forms.checkbox instantSave id="is_buildtime"
                                                helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                                label="Доступно під час збірки" />
                                        @endif
                                        <x-forms.checkbox instantSave id="is_runtime"
                                            helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                            label="Доступно під час виконання" />
                                        @if (!$env->is_nixpacks)
                                            <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                            @if ($is_multiline === false)
                                                <x-forms.checkbox instantSave id="is_literal"
                                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                                    label="Буквальне значення?" />
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            @else
                <div class="flex flex-col w-full gap-3">
                    <div class="flex flex-wrap w-full items-center gap-4">
                        @if (!$is_redis_credential)
                            @if ($type === 'service')
                                <x-forms.checkbox disabled id="is_buildtime"
                                    helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                    label="Доступно під час збірки" />
                                <x-forms.checkbox disabled id="is_runtime"
                                    helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                    label="Доступно під час виконання" />
                                <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                <x-forms.checkbox disabled id="is_literal"
                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                    label="Буквальне значення?" />
                            @else
                                @if ($is_shared)
                                    <x-forms.checkbox disabled id="is_literal"
                                        helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                        label="Буквальне значення?" />
                                @else
                                    @if ($isSharedVariable)
                                        <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                    @else
                                        <x-forms.checkbox disabled id="is_buildtime"
                                            helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                            label="Доступно під час збірки" />
                                        <x-forms.checkbox disabled id="is_runtime"
                                            helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                            label="Доступно під час виконання" />
                                        <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                        @if ($is_multiline === false)
                                            <x-forms.checkbox disabled id="is_literal"
                                                helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                                label="Буквальне значення?" />
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            @endcan
        @else
            @can('update', $this->env)
                @if ($isDisabled)
                    <div class="flex flex-col w-full gap-2 lg:flex-row">
                        <x-forms.input disabled id="key" />
                        <x-forms.input disabled type="password" id="value" />
                        @if ($is_shared)
                            <x-forms.input disabled type="password" id="real_value" />
                        @endif
                    </div>
                @else
                    <div class="flex flex-col w-full gap-2 lg:flex-row">
                        @if ($is_multiline)
                            <x-forms.input :required="$is_redis_credential" isMultiline="{{ $is_multiline }}" id="key" />
                            <x-forms.textarea :required="$is_redis_credential" type="password" id="value" />
                        @else
                            <x-forms.input :disabled="$is_redis_credential" :required="$is_redis_credential" id="key" />
                            <x-forms.input :required="$is_redis_credential" type="password" id="value" />
                        @endif
                        @if ($is_shared)
                            <x-forms.input :disabled="$is_redis_credential" :required="$is_redis_credential" disabled type="password" id="real_value" />
                        @endif
                    </div>
                @endif
            @else
                <div class="flex flex-col w-full gap-2 lg:flex-row">
                    <x-forms.input disabled id="key" />
                    <x-forms.input disabled type="password" id="value" />
                    @if ($is_shared)
                        <x-forms.input disabled type="password" id="real_value" />
                    @endif
                </div>
            @endcan
            @can('update', $this->env)
                <div class="flex flex-col w-full gap-3">
                    <div class="flex flex-wrap w-full items-center gap-4">
                        @if (!$is_redis_credential)
                            @if ($type === 'service')
                                <x-forms.checkbox instantSave id="is_buildtime"
                                    helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                    label="Доступно під час збірки" />
                                <x-forms.checkbox instantSave id="is_runtime"
                                    helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                    label="Доступно під час виконання" />
                                <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                <x-forms.checkbox instantSave id="is_literal"
                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                    label="Буквальне значення?" />
                            @else
                                @if ($is_shared)
                                    <x-forms.checkbox instantSave id="is_literal"
                                        helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                        label="Буквальне значення?" />
                                @else
                                    @if ($isSharedVariable)
                                        <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                    @else
                                        @if (!$env->is_nixpacks)
                                            <x-forms.checkbox instantSave id="is_buildtime"
                                                helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                                label="Доступно під час збірки" />
                                        @endif
                                        <x-forms.checkbox instantSave id="is_runtime"
                                            helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                            label="Доступно під час виконання" />
                                        @if (!$env->is_nixpacks)
                                            <x-forms.checkbox instantSave id="is_multiline" label="Багаторядкова?" />
                                            @if ($is_multiline === false)
                                                <x-forms.checkbox instantSave id="is_literal"
                                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                                    label="Буквальне значення?" />
                                            @endif
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                    <x-environment-variable-warning :problematic-variables="$problematicVariables" />
                    <div class="flex w-full justify-end gap-2">
                        @if ($isDisabled)
                            <x-forms.button disabled type="submit">Оновити</x-forms.button>
                            <x-forms.button wire:click='lock'>Заблокувати</x-forms.button>
                            <x-modal-confirmation title="Підтвердити видалення змінної середовища?" isErrorButton
                                buttonTitle="Видалити" submitAction="delete" :actions="['Вибрана змінна середовища буде безповоротно видалена.']"
                                confirmationText="{{ $key }}" buttonFullWidth="true"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву змінної середовища нижче"
                                shortConfirmationLabel="Назва змінної середовища" :confirmWithPassword="false"
                                step2ButtonText="Видалити безповоротно" />
                        @else
                            <x-forms.button type="submit">Оновити</x-forms.button>
                            <x-forms.button wire:click='lock'>Заблокувати</x-forms.button>
                            <x-modal-confirmation title="Підтвердити видалення змінної середовища?" isErrorButton
                                buttonTitle="Видалити" submitAction="delete" :actions="['Вибрана змінна середовища буде безповоротно видалена.']"
                                confirmationText="{{ $key }}" buttonFullWidth="true"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву змінної середовища нижче"
                                shortConfirmationLabel="Назва змінної середовища" :confirmWithPassword="false"
                                step2ButtonText="Видалити безповоротно" />
                        @endif
                    </div>
                </div>
            @else
                <div class="flex flex-col w-full gap-3">
                    <div class="flex flex-wrap w-full items-center gap-4">
                        @if (!$is_redis_credential)
                            @if ($type === 'service')
                                <x-forms.checkbox disabled id="is_buildtime"
                                    helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                    label="Доступно під час збірки" />
                                <x-forms.checkbox disabled id="is_runtime"
                                    helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                    label="Доступно під час виконання" />
                                <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                <x-forms.checkbox disabled id="is_literal"
                                    helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                    label="Буквальне значення?" />
                            @else
                                @if ($is_shared)
                                    <x-forms.checkbox disabled id="is_literal"
                                        helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                        label="Буквальне значення?" />
                                @else
                                    @if ($isSharedVariable)
                                        <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                    @else
                                        <x-forms.checkbox disabled id="is_buildtime"
                                            helper="Зробити цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
                                            label="Доступно під час збірки" />
                                        <x-forms.checkbox disabled id="is_runtime"
                                            helper="Зробити цю змінну доступною у запущеному контейнері під час виконання."
                                            label="Доступно під час виконання" />
                                        <x-forms.checkbox disabled id="is_multiline" label="Багаторядкова?" />
                                        @if ($is_multiline === false)
                                            <x-forms.checkbox disabled id="is_literal"
                                                helper="Це означає, що при використанні $ЗМІННИХ у значенні, вони повинні інтерпретуватися як фактичні символи '$ЗМІННІ', а не як значення змінної з назвою ЗМІННА.<br><br>Корисно, якщо у вашому значенні є знак $, і після нього є символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення як 'true'."
                                                label="Буквальне значення?" />
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            @endcan
        @endif

    </form>
</div>