<form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='submit'>
    <x-forms.input placeholder="NODE_ENV" id="key" label="Ім'я" required />
    <x-forms.textarea x-show="$wire.is_multiline === true" x-cloak id="value" label="Значення" required />
    <x-forms.input x-show="$wire.is_multiline === false" x-cloak placeholder="production" id="value"
        x-bind:label="$wire.is_multiline === false && 'Значення'" required />

    @if (!$shared)
        <x-forms.checkbox id="is_buildtime"
            helper="Зробіть цю змінну доступною під час процесу збірки Docker. Корисно для секретів збірки та залежностей."
            label="Доступно під час збірки" />

        <x-environment-variable-warning :problematic-variables="$problematicVariables" />

        <x-forms.checkbox id="is_runtime" helper="Зробіть цю змінну доступною у запущеному контейнері під час виконання."
            label="Доступно під час виконання" />
        <x-forms.checkbox id="is_literal"
            helper="Це означає, що коли ви використовуєте $VARIABLES у значенні, це має інтерпретуватися як фактичні символи '$VARIABLES', а не як значення змінної з назвою VARIABLE.<br><br>Корисно, якщо у вашому значенні є символ $ і за ним є деякі символи, але ви не хотіли б інтерполювати його з іншого значення. У цьому випадку, ви повинні встановити це значення в true."
            label="Це буквальне значення?" />
    @endif

    <x-forms.checkbox id="is_multiline" label="Це багаторядкове значення?" />
    <x-forms.button type="submit" @click="slideOverOpen=false">
        Зберегти
    </x-forms.button>
</form>