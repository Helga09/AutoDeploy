<div>
    <form wire:submit='submit' class="flex flex-col">
        <div class="flex items-center gap-2">
            <h2>Конфігурація Swarm</h2>
            @can('update', $application)
                <x-forms.button type="submit">
                    Зберегти
                </x-forms.button>
            @else
                <x-forms.button type="submit" disabled
                    title="Ви не маєте дозволу на оновлення цієї програми. Зверніться до адміністратора вашої команди для отримання доступу.">
                    Зберегти
                </x-forms.button>
            @endcan
        </div>
        <div class="flex flex-col gap-2 py-4">
            <div class="flex flex-col items-end gap-2 xl:flex-row">
                <x-forms.input id="swarmReplicas" label="Репліки" required canGate="update" :canResource="$application" />
                <x-forms.checkbox instantSave helper="Якщо вимкнено, цей ресурс також запускатиметься на вузлах менеджера."
                    id="isSwarmOnlyWorkerNodes" label="Запускати лише на робочих вузлах" canGate="update" :canResource="$application" />
            </div>
            <x-forms.textarea id="swarmPlacementConstraints" rows="7" label="Користувацькі обмеження розміщення"
                placeholder="placement:
    constraints:
        - 'node.role == worker'" canGate="update" :canResource="$application" />
        </div>
    </form>

</div>