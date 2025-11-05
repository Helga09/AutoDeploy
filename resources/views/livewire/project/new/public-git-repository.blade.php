<div x-data x-init="$nextTick(() => { if ($refs.autofocusInput) $refs.autofocusInput.focus(); })">
    <h1>Створити нову Застосунок</h1>
    <div class="pb-8">Розгорнути будь-які публічні Git-репозиторії.</div>

    <!-- Repository URL Form -->
    <form class="flex flex-col gap-2" wire:submit='loadBranch'>
        <div class="flex flex-col gap-2">
            <div class="flex gap-2 items-end">
                <x-forms.input required id="repository_url" label="URL репозиторію (https://)"
                    helper="{!! __('repository.url') !!}" autofocus />
                <x-forms.button type="submit">
                    Перевірити репозиторій
                </x-forms.button>
            </div>
        </div>
    </form>

    @if ($branchFound)
        @if ($rate_limit_remaining && $rate_limit_reset)
            <div class="flex gap-2 py-2">
                <div>Обмеження запитів</div>
                <x-helper
                    helper="Залишилося запитів: {{ $rate_limit_remaining }}<br>Скидання обмеження запитів о: {{ $rate_limit_reset }} UTC" />
            </div>
        @endif

        <!-- Application Configuration Form -->
        <form class="flex flex-col gap-2 pt-4" wire:submit='submit'>
            <div class="flex flex-col gap-2 pb-6">
                <div class="flex gap-2">
                    @if ($git_source === 'other')
                        <x-forms.input id="git_branch" label="Гілка"
                            helper="Ви можете вибрати інші гілки після завершення налаштування." />
                    @else
                        <x-forms.input disabled id="git_branch" label="Гілка"
                            helper="Ви можете вибрати інші гілки після завершення налаштування." />
                    @endif
                    <x-forms.select wire:model.live="build_pack" label="Пакет збірки" required>
                        <option value="nixpacks">Nixpacks</option>
                        <option value="static">Статичний</option>
                        <option value="dockerfile">Dockerfile</option>
                        <option value="dockercompose">Docker Compose</option>
                    </x-forms.select>
                    @if ($isStatic)
                        <x-forms.input id="publish_directory" label="Директорія публікації"
                            helper="Якщо задіяний процес збірки (наприклад, Svelte, React, Next тощо), будь ласка, вкажіть вихідну директорію для збудованих ресурсів." />
                    @endif
                </div>
                @if ($build_pack === 'dockercompose')
                    <div x-data="{ baseDir: '{{ $base_directory }}', composeLocation: '{{ $docker_compose_location }}' }" class="gap-2 flex flex-col">
                        <x-forms.input placeholder="/" wire:model.blur="base_directory" label="Базова директорія"
                            helper="Директорія для використання як коренева. Корисно для монорепозиторіїв." x-model="baseDir" />
                        <x-forms.input placeholder="/docker-compose.yaml" wire:model.blur="docker_compose_location"
                            label="Розташування Docker Compose" helper="Розраховується разом з Базовою директорією."
                            x-model="composeLocation" />
                        <div class="pt-2">
                            <span>
                                Розташування файлу Compose у вашому репозиторії: </span><span class='dark:text-warning'
                                x-text='(baseDir === "/" ? "" : baseDir) + (composeLocation.startsWith("/") ? composeLocation : "/" + composeLocation)'></span>
                        </div>
                    </div>
                @else
                    <x-forms.input wire:model="base_directory" label="Базова директорія"
                        helper="Директорія для використання як коренева. Корисно для монорепозиторіїв." />
                @endif
                @if ($show_is_static)
                    <x-forms.input type="number" id="port" label="Порт" :readonly="$isStatic || $build_pack === 'static'"
                        helper="Порт, на якому прослуховується ваш застосунок." />
                    <div class="w-64">
                        <x-forms.checkbox instantSave id="isStatic" label="Чи це статичний сайт?"
                            helper="Якщо ваш застосунок є статичним сайтом або кінцеві збудовані ресурси мають подаватися як статичний сайт, увімкніть цю опцію." />
                    </div>
                @endif
            </div>
            <x-forms.button type="submit">
                Продовжити
            </x-forms.button>
        </form>
    @endif
</div>