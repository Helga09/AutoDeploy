<div>
    <form wire:submit='submit' class="flex flex-col">
        <div class="flex items-center gap-2">
            <h2>Джерело</h2>
            @can('update', $application)
                <x-forms.button type="submit">Зберегти</x-forms.button>
            @endcan
            <div class="flex items-center gap-4 px-2">
                <a target="_blank" class="hover:no-underline flex items-center gap-1"
                    href="{{ $application?->gitBranchLocation }}">
                    Відкрити репозиторій
                    <x-external-link />
                </a>
                @if (data_get($application, 'source.is_public') === false)
                    <a target="_blank" class="hover:no-underline flex items-center gap-1"
                        href="{{ getInstallationPath($application->source) }}">
                        Відкрити Git застосунок
                        <x-external-link />
                    </a>
                @endif
                <a target="_blank" class="flex hover:no-underline items-center gap-1"
                    href="{{ $application?->gitCommits }}">
                    Відкрити комміти в Git
                    <x-external-link />
                </a>
            </div>
        </div>
        <div class="pb-4">Вихідний код вашого застосунку.</div>

        <div class="flex flex-col gap-2">
            @if (!$privateKeyId)
                <div>Наразі підключене джерело: <span
                        class="font-bold text-warning">{{ data_get($application, 'source.name', 'Джерело не підключено') }}</span>
                </div>
            @endif
            <div class="flex gap-2">
                <x-forms.input placeholder="coollabsio/coolify-example" id="gitRepository" label="Репозиторій"
                    canGate="update" :canResource="$application" />
                <x-forms.input placeholder="main" id="gitBranch" label="Гілка" canGate="update" :canResource="$application" />
            </div>
            <div class="flex items-end gap-2">
                <x-forms.input placeholder="HEAD" id="gitCommitSha" placeholder="HEAD" label="Хеш комміту"
                    canGate="update" :canResource="$application" />
            </div>
        </div>

        @if ($privateKeyId)
            <h3 class="pt-4">Ключ розгортання</h3>
            <div class="py-2 pt-4">Наразі приєднаний приватний ключ: <span
                    class="dark:text-warning">{{ $privateKeyName }}</span>
            </div>

            @can('update', $application)
                <h4 class="py-2 ">Вибрати інший приватний ключ</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach ($privateKeys as $key)
                        <x-forms.button wire:click="setPrivateKey('{{ $key->id }}')">{{ $key->name }}
                        </x-forms.button>
                    @endforeach
                </div>
            @endcan
        @else
            @can('update', $application)
                <div class="pt-4">
                    <h3 class="pb-2">Змінити джерело Git</h3>
                    <div class="grid grid-cols-1 gap-2">
                        @forelse ($sources as $source)
                            <div wire:key="{{ $source->name }}">
                                <x-modal-confirmation title="Змінити джерело Git" :actions="['Змінити джерело Git на ' . $source->name]" :buttonFullWidth="true"
                                    :isHighlightedButton="$application->source_id === $source->id" :disabled="$application->source_id === $source->id"
                                    submitAction="changeSource({{ $source->id }}, {{ $source->getMorphClass() }})"
                                    :confirmWithText="true" confirmationText="Змінити джерело Git"
                                    confirmationLabel="Будь ласка, підтвердьте зміну джерела Git, ввівши текст нижче"
                                    shortConfirmationLabel="Текст підтвердження" :confirmWithPassword="false">
                                    <x-slot:customButton>
                                        <div class="flex items-center gap-2">
                                            <div class="box-title">
                                                {{ $source->name }}
                                                @if ($application->source_id === $source->id)
                                                    <span class="text-xs">(поточне)</span>
                                                @endif
                                            </div>
                                            <div class="box-description">
                                                {{ $source->organization ?? 'Особистий обліковий запис' }}
                                            </div>
                                        </div>
                                    </x-slot:customButton>
                                </x-modal-confirmation>
                            </div>
                        @empty
                            <div>Інших джерел не знайдено</div>
                        @endforelse
                    </div>
                </div>
            @endcan
        @endif
    </form>
</div>