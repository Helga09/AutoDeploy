<div>
    <x-slot:title>
        Налаштування | Coolify
    </x-slot>
    <x-settings.navbar />
    <div class="flex flex-col">
        <div class="flex items-center gap-2 pb-2">
            <h2>Резервне копіювання</h2>
            @if (isset($database) && $server->isFunctional())
                <x-forms.button type="submit" wire:click="submit">
                    Зберегти
                </x-forms.button>
            @endif
        </div>
        <div class="pb-4">Конфігурація резервного копіювання для інстансу Coolify.</div>
        <div>
            @if ($server->isFunctional())
                @if (isset($database) && isset($backup))
                    <div class="flex flex-col gap-3 pb-4">
                        <div class="flex gap-2">
                            <x-forms.input label="UUID" readonly id="uuid" />
                            <x-forms.input label="Назва" readonly id="name" />
                            <x-forms.input label="Опис" id="description" />
                        </div>
                        <div class="flex gap-2">
                            <x-forms.input label="Користувач" readonly id="postgres_user" />
                            <x-forms.input type="password" label="Пароль" readonly id="postgres_password" />
                        </div>
                    </div>
                    <livewire:project.database.backup-edit :backup="$backup" :s3s="$s3s" :status="data_get($database, 'status')" />
                    <div class="py-4">
                        <livewire:project.database.backup-executions :backup="$backup" />
                    </div>
                @else
                    Щоб налаштувати автоматичне резервне копіювання для вашого інстансу Coolify, спочатку потрібно додати ресурс бази даних до Coolify.
                    <x-forms.button class="mt-2" wire:click="addCoolifyDatabase">Налаштувати резервне копіювання</x-forms.button>
                @endif
            @else
                <div class="p-6 bg-red-500/10 rounded-lg border border-red-500/20">
                    <div class="text-red-500 font-medium mb-4">
                        Резервне копіювання інстансу наразі вимкнено, оскільки сервер localhost не пройшов належну перевірку. Будь ласка, перевірте ваш сервер, щоб увімкнути резервне копіювання інстансу.
                    </div>
                    <a href="{{ route('server.show', [$server->uuid]) }}"
                        class="text-black hover:text-gray-700 dark:text-white dark:hover:text-gray-200 underline">
                        Перейти до налаштувань сервера для перевірки
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>