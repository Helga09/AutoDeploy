<div class="pb-6">
    <div class="flex items-end gap-2">
        <h1>Команда</h1>
        <x-modal-input buttonTitle="+ Додати" title="Нова команда">
            <livewire:team.create />
        </x-modal-input>
    </div>
    <div class="subtitle">Конфігурації команди.</div>
    <div class="navbar-main">
        <nav class="flex items-center gap-6 min-h-10">
            <a class="{{ request()->routeIs('team.index') ? 'dark:text-white' : '' }}" href="{{ route('team.index') }}">
                Загальні
            </a>
            <a class="{{ request()->routeIs('team.member.index') ? 'dark:text-white' : '' }}"
                href="{{ route('team.member.index') }}">
                Учасники
            </a>
            @if (isInstanceAdmin())
                <a class="{{ request()->routeIs('team.admin-view') ? 'dark:text-white' : '' }}"
                    href="{{ route('team.admin-view') }}">
                    Перегляд адміністратора
                </a>
            @endif
            <div class="flex-1"></div>
        </nav>
    </div>
</div>