<div>
    <div class="flex flex-col gap-4 p-4 bg-white border dark:bg-base dark:border-coolgray-300 border-neutral-200">
        @if ($isReadOnly)
            <div class="w-full p-2 text-sm rounded bg-warning/10 text-warning">
                @if ($fileStorage->is_directory)
                    Цей каталог змонтований як тільки для читання та не може бути змінений через інтерфейс.
                @else
                    Цей файл змонтований як тільки для читання та не може бути змінений через інтерфейс.
                @endif
            </div>
        @endif
        <div class="flex flex-col justify-center text-sm select-text">
            <div class="flex gap-2  md:flex-row flex-col">
                <x-forms.input label="Шлях джерела" :value="$fileStorage->fs_path" readonly />
                <x-forms.input label="Шлях призначення" :value="$fileStorage->mount_path" readonly />
            </div>
        </div>
        <form wire:submit='submit' class="flex flex-col gap-2">
            @if (!$isReadOnly)
                @can('update', $resource)
                    <div class="flex gap-2">
                        @if ($fileStorage->is_directory)
                            <x-modal-confirmation :ignoreWire="false" title="Підтвердити перетворення каталогу у файл?"
                                buttonTitle="Перетворити у файл" submitAction="convertToFile" :actions="[
                                    'Усі файли в цьому каталозі будуть безповоротно видалені, а на їх місці буде створено порожній файл.',
                                ]"
                                confirmationText="{{ $fs_path }}"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши шлях до файлу нижче"
                                shortConfirmationLabel="Шлях до файлу" :confirmWithPassword="false" step2ButtonText="Перетворити у файл" />
                            <x-modal-confirmation :ignoreWire="false" title="Підтвердити видалення каталогу?" buttonTitle="Видалити"
                                isErrorButton submitAction="delete" :checkboxes="$directoryDeletionCheckboxes" :actions="[
                                    'Вибраний каталог та весь його вміст буде безповоротно видалено з контейнера.',
                                ]"
                                confirmationText="{{ $fs_path }}"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши шлях до файлу нижче"
                                shortConfirmationLabel="Шлях до файлу" />
                        @else
                            @if (!$fileStorage->is_binary)
                                <x-modal-confirmation :ignoreWire="false" title="Підтвердити перетворення файлу у каталог?"
                                    buttonTitle="Перетворити у каталог" submitAction="convertToDirectory" :actions="[
                                        'Вибраний файл буде безповоротно видалено, а на його місці буде створено порожній каталог.',
                                    ]"
                                    confirmationText="{{ $fs_path }}"
                                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши шлях до файлу нижче"
                                    shortConfirmationLabel="Шлях до файлу" :confirmWithPassword="false"
                                    step2ButtonText="Перетворити у каталог" />
                            @endif
                            <x-forms.button type="button" wire:click="loadStorageOnServer">Завантажити з
                                сервера</x-forms.button>
                            <x-modal-confirmation :ignoreWire="false" title="Підтвердити видалення файлу?" buttonTitle="Видалити"
                                isErrorButton submitAction="delete" :checkboxes="$fileDeletionCheckboxes" :actions="['Вибраний файл буде безповоротно видалено з контейнера.']"
                                confirmationText="{{ $fs_path }}"
                                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши шлях до файлу нижче"
                                shortConfirmationLabel="Шлях до файлу" />
                        @endif
                    </div>
                @endcan
                @if (!$fileStorage->is_directory)
                    @can('update', $resource)
                        @if (data_get($resource, 'settings.is_preserve_repository_enabled'))
                            <div class="w-96">
                                <x-forms.checkbox instantSave label="Чи базується це на репозиторії Git?"
                                    id="isBasedOnGit"></x-forms.checkbox>
                            </div>
                        @endif
                        <x-forms.textarea
                            label="{{ $fileStorage->is_based_on_git ? 'Вміст (оновлюється після успішного розгортання)' : 'Вміст' }}"
                            rows="20" id="content"
                            readonly="{{ $fileStorage->is_based_on_git || $fileStorage->is_binary }}"></x-forms.textarea>
                        @if (!$fileStorage->is_based_on_git && !$fileStorage->is_binary)
                            <x-forms.button class="w-full" type="submit">Зберегти</x-forms.button>
                        @endif
                    @else
                        @if (data_get($resource, 'settings.is_preserve_repository_enabled'))
                            <div class="w-96">
                                <x-forms.checkbox disabled label="Чи базується це на репозиторії Git?"
                                    id="isBasedOnGit"></x-forms.checkbox>
                            </div>
                        @endif
                        <x-forms.textarea
                            label="{{ $fileStorage->is_based_on_git ? 'Вміст (оновлюється після успішного розгортання)' : 'Вміст' }}"
                            rows="20" id="content" disabled></x-forms.textarea>
                    @endcan
                @endif
            @else
                {{-- Read-only view --}}
                @if (!$fileStorage->is_directory)
                    @if (data_get($resource, 'settings.is_preserve_repository_enabled'))
                        <div class="w-96">
                            <x-forms.checkbox disabled label="Чи базується це на репозиторії Git?"
                                id="isBasedOnGit"></x-forms.checkbox>
                        </div>
                    @endif
                    <x-forms.textarea
                        label="{{ $fileStorage->is_based_on_git ? 'Вміст (оновлюється після успішного розгортання)' : 'Вміст' }}"
                        rows="20" id="content" disabled></x-forms.textarea>
                @endif
            @endif
        </form>
    </div>
</div>