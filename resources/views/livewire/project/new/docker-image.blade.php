<div x-data x-init="$nextTick(() => { if ($refs.autofocusInput) $refs.autofocusInput.focus(); })">
    <h1>Створити новий застосунок</h1>
    <div class="pb-4">Ви можете розгорнути існуючий образ Docker з будь-якого реєстру.</div>
    <form wire:submit="submit">
        <div class="flex gap-2 pt-4 pb-1">
            <h2>Образ Docker</h2>
            <x-forms.button type="submit">Зберегти</x-forms.button>
        </div>
        <div class="space-y-4">
            <x-forms.input id="imageName" label="Назва образу" placeholder="nginx, docker.io/nginx:latest, ghcr.io/user/app:v1.2.3, or nginx:stable@sha256:abc123..."
                helper="Введіть назву образу Docker з необов'язковим реєстром. Ви також можете вставити повне посилання, наприклад 'nginx:stable@sha256:abc123...', і поля нижче будуть автоматично заповнені."
                required autofocus />
            <div class="relative grid grid-cols-1 gap-4 md:grid-cols-2">
                <x-forms.input id="imageTag" label="Тег (необов'язково)" placeholder="latest"
                    helper="Введіть тег, наприклад 'latest' або 'v1.2.3'. Залиште порожнім, якщо використовуєте SHA256." />
                <div
                    class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 hidden md:flex items-center justify-center z-10">
                    <div
                        class="px-2 py-1 bg-white dark:bg-coolgray-100 border border-neutral-300 dark:border-coolgray-300 rounded text-xs font-bold text-neutral-500 dark:text-neutral-400">
                        АБО
                    </div>
                </div>
                <x-forms.input id="imageSha256" label="Дайджест SHA256 (необов'язково)"
                    placeholder="59e02939b1bf39f16c93138a28727aec520bb916da021180ae502c61626b3cf0"
                    helper="Введіть лише 64-символьний шістнадцятковий дайджест (без префікса 'sha256:')" />
            </div>
        </div>
    </form>
</div>