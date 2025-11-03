<div class="flex flex-col items-start gap-2 min-w-fit">
    <a class="menu-item {{ $activeMenu === 'general' ? 'menu-item-active' : '' }}"
        href="{{ route('settings.index') }}">Загальні</a>
    <a class="menu-item {{ $activeMenu === 'advanced' ? 'menu-item-active' : '' }}"
        href="{{ route('settings.advanced') }}">Розширені</a>
</div>