<div class="w-full">
    @if ($limit_reached)
        <x-limit-reached name="servers" />
    @else
        <form class="flex flex-col w-full gap-2" wire:submit='submit'>
            <div class="flex w-full gap-2 flex-wrap sm:flex-nowrap">
                <x-forms.input id="name" label="Назва" required />
                <x-forms.input id="description" label="Опис" />
            </div>
            <div class="flex gap-2 flex-wrap sm:flex-nowrap">
                <x-forms.input id="ip" label="IP-адреса/Домен" required
                    helper="IP-адреса (127.0.0.1) або домен (example.com)." />
                <x-forms.input type="number" id="port" label="Порт" required />
            </div>
            <x-forms.input id="user" label="Користувач" required />
            <div class="text-xs dark:text-warning text-coollabs ">Користувач без root-прав є експериментальним: <a
                    class="font-bold underline" target="_blank"
                    href="https://AutoDeploy.io/docs/knowledge-base/server/non-root-user">документація</a>.</div>
            <x-forms.select label="Приватний ключ" id="private_key_id">
                <option disabled>Виберіть приватний ключ</option>
                @foreach ($private_keys as $key)
                    @if ($loop->first)
                        <option selected value="{{ $key->id }}">{{ $key->name }}</option>
                    @else
                        <option value="{{ $key->id }}">{{ $key->name }}</option>
                    @endif
                @endforeach
            </x-forms.select>
            <div class="">
                <x-forms.checkbox instantSave type="checkbox" id="is_build_server"
                    helper="Сервери збірки використовуються для створення ваших застосунків, тому ви не можете розгортати на них застосунки."
                    label="Використовувати як сервер збірки?" />
            </div>
            <x-forms.button type="submit">
                Продовжити
            </x-forms.button>
        </form>
    @endif
</div>