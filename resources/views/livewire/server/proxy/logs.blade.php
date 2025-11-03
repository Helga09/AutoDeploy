<div>
    <x-slot:title>
        Журнали проксі | Coolify
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar-proxy :server="$server" :parameters="$parameters" />
        <div class="w-full">
            <h2 class="pb-4">Журнали</h2>
            <livewire:project.shared.get-logs :server="$server" container="coolify-proxy" displayName="Проксі Coolify" />
        </div>
    </div>
</div>