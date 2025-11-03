<div>
    <h2>Токени хмарних провайдерів</h2>
    <div class="pb-4">Керуйте токенами API для хмарних провайдерів (Hetzner, DigitalOcean тощо).</div>

    <h3>Новий токен</h3>
    @can('create', App\Models\CloudProviderToken::class)
        <livewire:security.cloud-provider-token-form :modal_mode="false" />
    @endcan

    <h3 class="py-4">Збережені токени</h3>
    <div class="grid gap-2 lg:grid-cols-1">
        @forelse ($tokens as $savedToken)
            <div wire:key="token-{{ $savedToken->id }}"
                class="flex flex-col gap-1 p-2 border dark:border-coolgray-200 hover:no-underline">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 text-xs font-bold rounded dark:bg-coolgray-300 dark:text-white">
                        {{ strtoupper($savedToken->provider) }}
                    </span>
                    <span class="font-bold dark:text-white">{{ $savedToken->name }}</span>
                </div>
                <div class="text-sm">Створено: {{ $savedToken->created_at->diffForHumans() }}</div>

                @can('delete', $savedToken)
                    <x-modal-confirmation title="Підтвердити видалення токена?" isErrorButton buttonTitle="Видалити токен"
                        submitAction="deleteToken({{ $savedToken->id }})" :actions="[
                            'Цей токен хмарного провайдера буде остаточно видалено.',
                            'Будь-які сервери, що використовують цей токен, потребуватимуть переналаштування.',
                        ]"
                        confirmationText="{{ $savedToken->name }}"
                        confirmationLabel="Будь ласка, підтвердьте видалення, ввівши ім'я токена нижче"
                        shortConfirmationLabel="Ім'я токена" :confirmWithPassword="false" step2ButtonText="Видалити токен" />
                @endcan
            </div>
        @empty
            <div>
                <div>Токенів хмарних провайдерів не знайдено.</div>
            </div>
        @endforelse
    </div>
</div>