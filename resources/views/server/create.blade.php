<x-layout>
    @if ($private_keys->count() === 0)
        <h1>Створити приватний ключ</h1>
        <div class="subtitle">Вам потрібно створити приватний ключ, перш ніж ви зможете створити сервер.</div>
        <livewire:private-key.create from="server" />
    @else
        <livewire:server.new.by-ip :private_keys="$private_keys" :limit_reached="$limit_reached" />
    @endif
</x-layout>