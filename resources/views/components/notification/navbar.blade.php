<div class="pb-6">
    <h1>Сповіщення</h1>
    <div class="subtitle">Отримуйте сповіщення про вашу інфраструктуру.</div>
    <div class="navbar-main">
        <nav class="flex items-center gap-6 min-h-10">
            <a class="{{ request()->routeIs('notifications.email') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.email') }}">
                <button>Електронна пошта</button>
            </a>
            <a class="{{ request()->routeIs('notifications.discord') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.discord') }}">
                <button>Discord</button>
            </a>
            <a class="{{ request()->routeIs('notifications.telegram') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.telegram') }}">
                <button>Telegram</button>
            </a>
            <a class="{{ request()->routeIs('notifications.slack') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.slack') }}">
                <button>Slack</button>
            </a>
            <a class="{{ request()->routeIs('notifications.pushover') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.pushover') }}">
                <button>Pushover</button>
            </a>
            <a class="{{ request()->routeIs('notifications.webhook') ? 'dark:text-white' : '' }}"
                href="{{ route('notifications.webhook') }}">
                <button>Вебхук</button>
            </a>
        </nav>
    </div>
</div>