<div>
    <div class="flex items-end gap-2">
        <h1>Створити новий застосунок</h1>
        <x-modal-input buttonTitle="+ Додати GitHub Застосунок" title="Новий GitHub Застосунок" closeOutside="false">
            <livewire:source.github.create />
        </x-modal-input>
        @if ($repositories->count() > 0)
            <a target="_blank" class="flex hover:no-underline" href="{{ getInstallationPath($github_app) }}">
                <x-forms.button>
                    Змінити репозиторії на GitHub
                    <x-external-link />
                </x-forms.button>
            </a>
        @endif
    </div>
    <div class="pb-4">Розгортайте будь-які публічні або приватні Git-репозиторії за допомогою GitHub Застосунку.</div>
    @if ($github_apps->count() !== 0)
        <div class="flex flex-col gap-2">
            @if ($current_step === 'github_apps')
                <h2 class="pt-4 pb-4">Виберіть GitHub Застосунок</h2>
                <div class="flex flex-col justify-center gap-2 text-left">
                    @foreach ($github_apps as $ghapp)
                        <div class="flex">
                            <div class="w-full gap-2 py-4 bg-white cursor-pointer group hover:bg-coollabs dark:bg-coolgray-200 box"
                                wire:click.prevent="loadRepositories({{ $ghapp->id }})"
                                wire:key="{{ $ghapp->id }}">
                                <div class="flex mr-4">
                                    <div class="flex flex-col mx-6">
                                        <div class="box-title">
                                            {{ data_get($ghapp, 'name') }}
                                        </div>
                                        <div class="box-description">
                                            {{ data_get($ghapp, 'html_url') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                <x-loading wire:loading wire:target="loadRepositories({{ $ghapp->id }})" />
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($current_step === 'repository')
                @if ($repositories->count() > 0)
                    <div class="flex flex-col gap-2 pb-6">
                        <div class="flex gap-2">
                            <x-forms.select class="w-full" label="Репозиторій" wire:model="selected_repository_id">
                                @foreach ($repositories as $repo)
                                    @if ($loop->first)
                                        <option selected value="{{ data_get($repo, 'id') }}">
                                            {{ data_get($repo, 'name') }}
                                        </option>
                                    @else
                                        <option value="{{ data_get($repo, 'id') }}">{{ data_get($repo, 'name') }}
                                        </option>
                                    @endif
                                @endforeach
                            </x-forms.select>
                        </div>
                        <x-forms.button wire:click.prevent="loadBranches"> Завантажити репозиторій </x-forms.button>
                    </div>
                @else
                    <div>Репозиторії не знайдені. Перевірте конфігурацію вашого GitHub Застосунку.</div>
                @endif
                @if ($branches->count() > 0)
                    <h2 class="text-lg font-bold">Конфігурація</h2>
                    <div class="flex flex-col gap-2 pb-6">
                        <form class="flex flex-col" wire:submit='submit'>
                            <div class="flex flex-col gap-2 pb-6">
                                <div class="flex gap-2">
                                    <x-forms.select id="selected_branch_name" label="Гілка">
                                        <option value="default" disabled selected>Виберіть гілку</option>
                                        @foreach ($branches as $branch)
                                            @if ($loop->first)
                                                <option selected value="{{ data_get($branch, 'name') }}">
                                                    {{ data_get($branch, 'name') }}
                                                </option>
                                            @else
                                                <option value="{{ data_get($branch, 'name') }}">
                                                    {{ data_get($branch, 'name') }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </x-forms.select>
                                    <x-forms.select wire:model.live="build_pack" label="Пакет збірки" required>
                                        <option value="nixpacks">Nixpacks</option>
                                        <option value="static">Статичний</option>
                                        <option value="dockerfile">Dockerfile</option>
                                        <option value="dockercompose">Docker Compose</option>
                                    </x-forms.select>
                                    @if ($is_static)
                                        <x-forms.input id="publish_directory" label="Каталог публікації"
                                            helper="Якщо є процес збірки (наприклад, Svelte, React, Next тощо), будь ласка, вкажіть вихідний каталог для зібраних ресурсів." />
                                    @endif
                                </div>
                                @if ($build_pack === 'dockercompose')
                                    <div x-data="{ baseDir: '{{ $base_directory }}', composeLocation: '{{ $docker_compose_location }}' }" class="gap-2 flex flex-col">
                                        <x-forms.input placeholder="/" wire:model.blur="base_directory"
                                            label="Базовий каталог"
                                            helper="Каталог, який використовувати як корінь. Корисно для монорепозиторіїв."
                                            x-model="baseDir" />
                                        <x-forms.input placeholder="/docker-compose.yaml"
                                            wire:model.blur="docker_compose_location" label="Розташування Docker Compose"
                                            helper="Розраховується разом з базовим каталогом."
                                            x-model="composeLocation" />
                                        <div class="pt-2">
                                            <span>
                                                Розташування файлу Compose у вашому репозиторії: </span><span
                                                class='dark:text-warning'
                                                x-text='(baseDir === "/" ? "" : baseDir) + (composeLocation.startsWith("/") ? composeLocation : "/" + composeLocation)'></span>
                                        </div>
                                    </div>
                                @else
                                    <x-forms.input wire:model="base_directory" label="Базовий каталог"
                                        helper="Каталог, який використовувати як корінь. Корисно для монорепозиторіїв." />
                                @endif
                                @if ($show_is_static)
                                    <x-forms.input type="number" id="port" label="Порт" :readonly="$is_static || $build_pack === 'static'"
                                        helper="Порт, на якому працює ваш застосунок." />
                                    <div class="w-52">
                                        <x-forms.checkbox instantSave id="is_static" label="Це статичний сайт?"
                                            helper="Якщо ваш застосунок є статичним сайтом або кінцеві зібрані ресурси мають подаватися як статичний сайт, увімкніть це." />
                                    </div>
                                @endif
                            </div>
                            <x-forms.button type="submit">
                                Продовжити
                            </x-forms.button>
                @endif
            @endif
        </div>
    @else
        <div class="hero">
            GitHub Застосунок не знайдено. Будь ласка, створіть новий GitHub Застосунок.
        </div>
    @endif
</div>