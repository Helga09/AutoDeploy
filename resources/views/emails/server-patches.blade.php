<x-emails.layout>
Для вашого сервера {{ $name }} доступні {{ $total_updates }} оновлення пакетів.

## Підсумок

- Операційна система: {{ ucfirst($osId) }}
- Менеджер пакетів: {{ $package_manager }}
- Всього оновлень: {{ $total_updates }}

## Доступні оновлення

@if ($total_updates > 0)
@foreach ($updates as $update)

Пакет: {{ $update['package'] }} ({{ $update['architecture'] }}), з версії {{ $update['current_version'] }} до {{ $update['new_version'] }} у репозиторії {{ $update['repository'] ?? 'Невідомо' }}
@endforeach

## Міркування безпеки

Деякі з цих оновлень можуть містити важливі виправлення безпеки. Ми рекомендуємо якнайшвидше переглянути та застосувати ці оновлення.

### Критичні пакети, які можуть вимагати перезапуску контейнера/сервера/сервісу:
@php
$criticalPackages = collect($updates)->filter(function ($update) {
                return str_contains(strtolower($update['package']), 'docker') ||
                    str_contains(strtolower($update['package']), 'kernel') ||
                    str_contains(strtolower($update['package']), 'openssh') ||
                    str_contains(strtolower($update['package']), 'ssl');
            });
@endphp

@if ($criticalPackages->count() > 0)
@foreach ($criticalPackages as $package)
- {{ $package['package'] }}: {{ $package['current_version'] }} → {{ $package['new_version'] }}
@endforeach
@else
Критичних пакетів, які вимагають перезапуску контейнера, не виявлено.
@endif

## Наступні кроки

1. Перегляньте доступні оновлення
2. Заплануйте вікно технічного обслуговування, якщо задіяні критичні пакети
3. Застосуйте оновлення через панель керування Coolify
4. Контролюйте сервіси після застосування оновлень
@else
Ваш сервер оновлено! Наразі жодні пакети не потребують оновлення.
@endif

---

Ви можете керувати виправленнями сервера на вашій [Панелі керування Coolify]({{ $server_url }}).
</x-emails.layout>