<div x-data="{ error: $wire.entangle('error'), filesize: $wire.entangle('filesize'), filename: $wire.entangle('filename'), isUploading: $wire.entangle('isUploading'), progress: $wire.entangle('progress') }">
    <script type="text/javascript" src="{{ URL::asset('js/dropzone.js') }}"></script>
    @script
        <script data-navigate-once>
            Dropzone.options.myDropzone = {
                chunking: true,
                method: "POST",
                maxFilesize: 1000000000,
                chunkSize: 10000000,
                createImageThumbnails: false,
                disablePreviews: true,
                parallelChunkUploads: false,
                init: function() {
                    let button = this.element.querySelector('button');
                    button.innerText = 'Виберіть або перетягніть файл резервної копії сюди.'
                    this.on('sending', function(file, xhr, formData) {
                        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        formData.append("_token", token);
                    });
                    this.on("addedfile", file => {
                        $wire.isUploading = true;
                    });
                    this.on('uploadprogress', function(file, progress, bytesSent) {
                        $wire.progress = progress;
                    });
                    this.on('complete', function(file) {
                        $wire.filename = file.name;
                        $wire.filesize = Number(file.size / 1024 / 1024).toFixed(2) + ' MB';
                        $wire.isUploading = false;
                    });
                    this.on('error', function(file, message) {
                        $wire.error = true;
                        $wire.$dispatch('error', message.error)
                    });
                }
            };
        </script>
    @endscript
    <h2>Імпорт резервної копії</h2>
    @if ($unsupported)
        <div>Відновлення бази даних не підтримується.</div>
    @else
        <div class="pt-2 rounded-sm alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 stroke-current shrink-0" fill="none"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <span>Це деструктивна дія, існуючі дані будуть замінені!</span>
        </div>
        @if (str(data_get($resource, 'status'))->startsWith('running'))
            @if ($resource->type() === 'standalone-postgresql')
                @if ($dumpAll)
                    <x-forms.textarea rows="6" readonly label="Користувацька команда імпорту"
                        wire:model='restoreCommandText'></x-forms.textarea>
                @else
                    <x-forms.input label="Користувацька команда імпорту" wire:model='postgresqlRestoreCommand'></x-forms.input>
                    <div class="flex flex-col gap-1 pt-1">
                        <span class="text-xs">Ви можете додати "--clean", щоб видалити об'єкти перед їх створенням, уникаючи конфліктів.</span>
                        <span class="text-xs">Ви можете додати "--verbose" для детальнішого логування.</span>
                    </div>
                @endif
                <div class="w-64 pt-2">
                    <x-forms.checkbox label="Резервна копія включає всі бази даних"
                        wire:model.live='dumpAll'></x-forms.checkbox>
                </div>
            @elseif ($resource->type() === 'standalone-mysql')
                @if ($dumpAll)
                    <x-forms.textarea rows="14" readonly label="Користувацька команда імпорту"
                        wire:model='restoreCommandText'></x-forms.textarea>
                @else
                    <x-forms.input label="Користувацька команда імпорту" wire:model='mysqlRestoreCommand'></x-forms.input>
                @endif
                <div class="w-64 pt-2">
                    <x-forms.checkbox label="Резервна копія включає всі бази даних"
                        wire:model.live='dumpAll'></x-forms.checkbox>
                </div>
            @elseif ($resource->type() === 'standalone-mariadb')
                @if ($dumpAll)
                    <x-forms.textarea rows="14" readonly label="Користувацька команда імпорту"
                        wire:model='restoreCommandText'></x-forms.textarea>
                @else
                    <x-forms.input label="Користувацька команда імпорту" wire:model='mariadbRestoreCommand'></x-forms.input>
                @endif
                <div class="w-64 pt-2">
                    <x-forms.checkbox label="Резервна копія включає всі бази даних"
                        wire:model.live='dumpAll'></x-forms.checkbox>
                </div>
            @endif
            <h3 class="pt-6">Файл резервної копії</h3>
            <form class="flex gap-2 items-end">
                <x-forms.input label="Розташування файлу резервної копії на сервері"
                    placeholder="напр. /home/user/backup.sql.gz" wire:model='customLocation'></x-forms.input>
                <x-forms.button class="w-full" wire:click='checkFile'>Перевірити файл</x-forms.button>
            </form>
            <div class="pt-2 text-center text-xl font-bold">
                Або
            </div>
            <form action="/upload/backup/{{ $resource->uuid }}" class="dropzone" id="my-dropzone" wire:ignore>
                @csrf
            </form>
            <div x-show="isUploading">
                <progress max="100" x-bind:value="progress" class="progress progress-warning"></progress>
            </div>
            <h3 class="pt-6" x-show="filename && !error">Інформація про файл</h3>
            <div x-show="filename && !error">
                <div>Розташування: <span x-text="filename ?? 'Н/Д'"></span> <span x-text="filesize">/ </span></div>
                <x-forms.button class="w-full my-4" wire:click='runImport'>Відновити резервну копію</x-forms.button>
            </div>
            <div class="container w-full mx-auto" x-show="$wire.importRunning">
                <livewire:activity-monitor header="Вивід відновлення бази даних" :showWaiting="false" />
            </div>
        @else
            <div>База даних повинна бути запущена для відновлення резервної копії.</div>
        @endif
    @endif
</div>