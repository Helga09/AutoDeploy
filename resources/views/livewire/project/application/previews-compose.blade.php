<form wire:submit="save" class="flex items-end gap-2">
    <x-forms.input helper="Один домен на попередній перегляд." label="Домени для {{ str($serviceName)->headline() }}" id="domain"
        canGate="update" :canResource="$preview->application"></x-forms.input>
    <x-forms.button type="submit">Зберегти</x-forms.button>
    <x-forms.button wire:click="generate">Згенерувати домен</x-forms.button>
</form>