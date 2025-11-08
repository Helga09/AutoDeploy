@can('create', App\Models\S3Storage::class)
    <div class="w-full">
        <form class="flex flex-col gap-2" wire:submit='submit'>
            <div class="flex gap-2">
                <x-forms.input required label="Назва" id="name" />
                <x-forms.input label="Опис" id="description" />
            </div>
            <x-forms.input required type="url" label="Кінцева точка" wire:model.blur="endpoint" />
            <div class="flex gap-2">
                <x-forms.input required label="Бакет" id="bucket" />
                <x-forms.input required helper="Регіон потрібен лише для AWS. Залиште як є для інших провайдерів."
                    label="Регіон" id="region" />
            </div>
            <div class="flex gap-2">
                <x-forms.input required type="password" label="Ключ доступу" id="key" />
                <x-forms.input required type="password" label="Секретний ключ" id="secret" />
            </div>

            <x-forms.button class="mt-4" type="submit">
                Перевірити з'єднання та продовжити
            </x-forms.button>
        </form>
    </div>
@else
    <x-callout type="warning" title="Потрібен дозвіл">
        У вас немає дозволу на створення нових конфігурацій сховища S3. Будь ласка, зв'яжіться з адміністратором вашої команди для отримання доступу.
    </x-callout>
@endcan