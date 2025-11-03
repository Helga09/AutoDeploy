<div>
    <x-slot:title>
        Сховища | AutoDeploy
    </x-slot>
    <div class="flex items-center gap-2">
        <h1>S3 Сховища</h1>
        @can('create', App\Models\S3Storage::class)
            <x-modal-input buttonTitle="+ Додати" title="Нове S3 сховище" :closeOutside="false">
                <livewire:storage.create />
            </x-modal-input>
        @endcan
    </div>
    <div class="subtitle">S3 сховища для резервних копій.</div>
    <div class="grid gap-4 lg:grid-cols-2 -mt-1">
        @forelse ($s3 as $storage)
            <a href="/storages/{{ $storage->uuid }}" @class(['gap-2 border cursor-pointer box group'])>
                <div class="flex flex-col justify-center mx-6">
                    <div class="box-title">
                        {{ $storage->name }}
                    </div>
                    <div class="box-description">
                        {{ $storage->description }}
                    </div>
                    @if (!$storage->is_usable)
                        <span
                            class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded dark:text-red-100 dark:bg-red-800">
                            Непридатне для використання
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <div>
                <div>Сховищ не знайдено.</div>
            </div>
        @endforelse
    </div>
</div>