<div class="pb-6">
    <h1>Безпека</h1>
    <div class="subtitle">Налаштування, пов'язані з безпекою.</div>
    <div class="navbar-main">
        <nav class="flex items-center gap-6 scrollbar min-h-10">
            <a href="{{ route('security.private-key.index') }}">
                <button>Приватні ключі</button>
            </a>
            @can('viewAny', App\Models\CloudProviderToken::class)
                <a href="{{ route('security.cloud-tokens') }}">
                    <button>Хмарні токени</button>
                </a>
            @endcan
            @can('viewAny', App\Models\CloudInitScript::class)
                <a href="{{ route('security.cloud-init-scripts') }}">
                    <button>Скрипти Cloud-Init</button>
                </a>
            @endcan
            <a href="{{ route('security.api-tokens') }}">
                <button>API Токени</button>
            </a>
        </nav>
    </div>
</div>