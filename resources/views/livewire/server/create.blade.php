<div class="w-full">
    <div class="flex flex-col gap-4">
        <div>
            <h3 class="pb-2">Додати сервер за IP-адресою</h3>
            <livewire:server.new.by-ip :private_keys="$private_keys" :limit_reached="$limit_reached" />
        </div>
    </div>
</div>