<div>
    <x-security.navbar />
    <div class="flex gap-2">
        <h2 class="pb-4">Приватні ключі</h2>
        @can('create', App\Models\PrivateKey::class)
            <x-modal-input buttonTitle="+ Додати" title="Новий приватний ключ">
                <livewire:security.private-key.create />
            </x-modal-input>
        @endcan
        @can('create', App\Models\PrivateKey::class)
            <x-modal-confirmation title="Підтвердити видалення невикористаних SSH ключів?" buttonTitle="Видалити невикористані SSH ключі" isErrorButton
                submitAction="cleanupUnusedKeys" :actions="['Всі невикористані SSH ключі (позначені як «unused») будуть видалені назавжди.']" :confirmWithText="false" :confirmWithPassword="false" />
        @endcan
    </div>
    <div class="grid gap-4 lg:grid-cols-2">
        @forelse ($privateKeys as $key)
            @can('view', $key)
                {{-- Admin/Owner: Clickable link --}}
                <a class="box group"
                    href="{{ route('security.private-key.show', ['private_key_uuid' => data_get($key, 'uuid')]) }}">
                    <div class="flex flex-col justify-center mx-6">
                        <div class="box-title">
                            {{ data_get($key, 'name') }}
                        </div>
                        <div class="box-description">
                            {{ $key->description }}
                            @if (!$key->isInUse())
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-sm text-xs font-medium bg-yellow-400 text-black">Невикористаний</span>
                            @endif
                        </div>
                    </div>
                </a>
            @else
                {{-- Member: Visible but not clickable --}}
                <div class="box opacity-60 cursor-not-allowed hover:bg-transparent dark:hover:bg-transparent" title="У вас немає дозволу на перегляд цього приватного ключа">
                    <div class="flex flex-col justify-center mx-6">
                        <div class="box-title">
                            {{ data_get($key, 'name') }}
                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-sm text-xs font-medium bg-gray-400 dark:bg-gray-600 text-white">Лише перегляд</span>
                        </div>
                        <div class="box-description">
                            {{ $key->description }}
                            @if (!$key->isInUse())
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-sm text-xs font-medium bg-yellow-400 text-black">Невикористаний</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endcan
        @empty
            <div>Приватні ключі не знайдено.</div>
        @endforelse
    </div>
</div>