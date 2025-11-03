<form wire:submit='submit'>
    <div class="flex items-center gap-2">
        <h2>Попередній перегляд розгортань</h2>
        @can('update', $application)
            <x-forms.button type="submit">Зберегти</x-forms.button>
            <x-forms.button isHighlighted wire:click="resetToDefault">Скинути шаблон до типового</x-forms.button>
        @endcan
    </div>
    <div class="pb-4 ">Попередні перегляди розгортань на основі запитів на злиття тут.</div>
    <div class="flex flex-col gap-2 pb-4">
        <x-forms.input id="previewUrlTemplate" label="Шаблон URL попереднього перегляду"
            helper="Шаблони:<br/><span class='text-helper'>@@{{ random }}</span> для генерації випадкового субдомену щоразу, коли розгортається PR<br/><span class='text-helper'>@@{{ pr_id }}</span> для використання ID запиту на злиття як субдомену або <span class='text-helper'>@@{{ domain }}</span> для заміни доменного імені на доменне ім'я застосунку." canGate="update" :canResource="$application" />
        @if ($previewUrlTemplate)
            <div class="">Попередній перегляд домену: {{ $previewUrlTemplate }}</div>
        @endif
    </div>
</form>