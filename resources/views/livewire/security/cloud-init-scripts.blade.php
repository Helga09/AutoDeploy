<div>
    <x-security.navbar />
    <div class="flex gap-2">
        <h2 class="pb-4">Скрипти Cloud-Init</h2>
        @can('create', App\Models\CloudInitScript::class)
            <x-modal-input buttonTitle="+ Додати" title="Новий скрипт Cloud-Init">
                <livewire:security.cloud-init-script-form />
            </x-modal-input>
        @endcan
    </div>
    <div class="pb-4 text-sm">Керуйте багаторазовими скриптами cloud-init для ініціалізації сервера. Наразі працює лише з <span class="text-red-500 font-bold">інтеграцією Hetzner's</span>.</div>

    <div class="grid gap-4 lg:grid-cols-2">
        @forelse ($scripts as $script)
            <div wire:key="script-{{ $script->id }}"
                class="flex flex-col gap-1 p-2 border dark:border-coolgray-200 hover:no-underline">
                <div class="flex justify-between items-center">
                    <div class="flex-1">
                        <div class="font-bold dark:text-white">{{ $script->name }}</div>
                        <div class="text-xs text-neutral-500 dark:text-neutral-400">
                            Створено {{ $script->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 mt-2">
                    @can('update', $script)
                        <x-modal-input buttonTitle="Редагувати" title="Редагувати скрипт Cloud-Init" fullWidth>
                            <livewire:security.cloud-init-script-form :scriptId="$script->id"
                                wire:key="edit-{{ $script->id }}" />
                        </x-modal-input>
                    @endcan

                    @can('delete', $script)
                        <x-modal-confirmation title="Підтвердити видалення скрипта?" isErrorButton buttonTitle="Видалити"
                            submitAction="deleteScript({{ $script->id }})" :actions="[
                                'Цей скрипт cloud-init буде видалено назавжди.',
                                'Цю дію не можна скасувати.',
                            ]" confirmationText="{{ $script->name }}"
                            confirmationLabel="Будь ласка, підтвердьте видалення, ввівши назву скрипта нижче"
                            shortConfirmationLabel="Назва скрипта" :confirmWithPassword="false"
                            step2ButtonText="Видалити скрипт" />
                    @endcan
                </div>
            </div>
        @empty
            <div class="text-neutral-500">Скриптів cloud-init не знайдено. Створіть один, щоб розпочати.</div>
        @endforelse
    </div>
</div>