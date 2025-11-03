@can('createAnyResource')
    <div class="w-full ">
        <div class="subtitle">Призначення використовуються для розподілу ресурсів за мережею.</div>
        <form class="flex flex-col gap-4" wire:submit='submit'>
            <div class="flex gap-2">
                <x-forms.input id="name" label="Назва" required />
                <x-forms.input id="network" label="Мережа" required />
            </div>
            <x-forms.select id="serverId" label="Виберіть сервер" required wire:change="generateName">
                <option disabled>Виберіть сервер</option>
                @foreach ($servers as $server)
                    <option value="{{ $server->id }}">{{ $server->name }}</option>
                @endforeach
            </x-forms.select>
            <x-forms.button type="submit">
                Продовжити
            </x-forms.button>
        </form>
    </div>
@else
    <x-callout type="warning" title="Потрібен дозвіл">
        У вас немає дозволу на створення нових призначень. Будь ласка, зв'яжіться з адміністратором вашої команди для отримання доступу.
    </x-callout>
@endcan