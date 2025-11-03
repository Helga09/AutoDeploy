<div class="flex gap-2">
    <h3 class="dark:text-white">Файл: {{ str_replace('|', '.', $fileName) }}</h3>
    @can('update', $server)
        <div class="flex gap-2">
            <x-modal-input buttonTitle="Редагувати" title="Редагувати конфігурацію">
                <livewire:server.proxy.new-dynamic-configuration :server_id="$server_id" :fileName="$fileName" :value="$value"
                    :newFile="$newFile" wire:key="{{ $fileName }}" />
            </x-modal-input>
        </div>
        <x-forms.button isError wire:click="delete('{{ $fileName }}')">Видалити</x-forms.button>
    @endcan
</div>