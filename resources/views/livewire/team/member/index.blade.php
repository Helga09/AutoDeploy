<div>
    <x-slot:title>
        Учасники команди | Coolify
    </x-slot>
    <x-team.navbar />
    <h2>Учасники</h2>
    <div class="subtitle">
        Керуйте або запрошуйте учасників цієї команди.
    </div>
    <div class="flex flex-col">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Ім'я
                                    </th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Електронна пошта</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Роль</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Дії</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (currentTeam()->members as $member)
                                    <livewire:team.member :member="$member" :wire:key="$member->id" />
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @can('manageInvitations', currentTeam())
        <div class="py-4">
            @if (is_transactional_emails_enabled())
                <h2 class="pb-4">Запросити нового учасника</h2>
            @else
                <h2>Запросити нового учасника</h2>
                @if (isInstanceAdmin())
                    <div class="pb-4 text-xs dark:text-warning">Вам потрібно налаштувати (як головна команда) <a
                            href="/settings/email" class="underline dark:text-warning">Транзакційні електронні листи</a>
                        перш ніж
                        ви зможете
                        запросити нового
                        учасника
                        електронною поштою.
                    </div>
                @endif
            @endif
            <livewire:team.invite-link />
        </div>
        <livewire:team.invitations :invitations="$invitations" />
    @endcan
</div>