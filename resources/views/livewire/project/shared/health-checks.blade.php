<form wire:submit='submit' class="flex flex-col">
    <div class="flex items-center gap-2">
        <h2>Перевірки стану</h2>
        <x-forms.button canGate="update" :canResource="$resource" type="submit">Зберегти</x-forms.button>
        @if (!$healthCheckEnabled)
            <x-modal-confirmation title="Підтвердити увімкнення перевірки стану?" buttonTitle="Увімкнути перевірку стану"
                submitAction="toggleHealthcheck" :actions="['Увімкнути перевірку стану для цього ресурсу.']"
                warningMessage="Якщо перевірка стану не пройде, ваша програма стане недоступною."
                step2ButtonText="Увімкнути перевірку стану" :confirmWithText="false" :confirmWithPassword="false"
                isHighlightedButton>
            </x-modal-confirmation>
        @else
            <x-forms.button canGate="update" :canResource="$resource" wire:click="toggleHealthcheck">Вимкнути перевірку стану</x-forms.button>
        @endif
    </div>
    <div class="mt-1 pb-4">Визначте, як слід перевіряти стан вашого ресурсу.</div>
    <div class="flex flex-col gap-4">
        @if ($customHealthcheckFound)
            <x-callout type="warning" title="Обережно">
                <p>Виявлено власну перевірку стану. Якщо ви ввімкнете цю перевірку стану, вона вимкне власну і використовуватиме цю натомість.</p>
            </x-callout>
        @endif
        <div class="flex gap-2">
            <x-forms.select canGate="update" :canResource="$resource" id="healthCheckMethod" label="Метод" required>
                <option value="GET">GET</option>
                <option value="POST">POST</option>
            </x-forms.select>
            <x-forms.select canGate="update" :canResource="$resource" id="healthCheckScheme" label="Схема" required>
                <option value="http">http</option>
                <option value="https">https</option>
            </x-forms.select>
            <x-forms.input canGate="update" :canResource="$resource" id="healthCheckHost" placeholder="localhost" label="Хост" required />
            <x-forms.input canGate="update" :canResource="$resource" type="number" id="healthCheckPort"
                helper="Якщо порт не визначено, буде використано перший відкритий порт." placeholder="80" label="Порт" />
            <x-forms.input canGate="update" :canResource="$resource" id="healthCheckPath" placeholder="/health" label="Шлях" required />
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$resource" type="number" id="healthCheckReturnCode" placeholder="200" label="Код повернення"
                required />
            <x-forms.input canGate="update" :canResource="$resource" id="healthCheckResponseText" placeholder="OK" label="Текст відповіді" />
        </div>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$resource" min="1" type="number" id="healthCheckInterval" placeholder="30"
                label="Інтервал (с)" required />
            <x-forms.input canGate="update" :canResource="$resource" type="number" id="healthCheckTimeout" placeholder="30" label="Таймаут (с)"
                required />
            <x-forms.input canGate="update" :canResource="$resource" type="number" id="healthCheckRetries" placeholder="3" label="Повторні спроби" required />
            <x-forms.input canGate="update" :canResource="$resource" min=1 type="number" id="healthCheckStartPeriod" placeholder="30"
                label="Початковий період (с)" required />
        </div>
    </div>
</form>