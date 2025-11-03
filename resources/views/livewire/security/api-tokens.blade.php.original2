<div>
    <x-slot:title>
        Токени API | Coolify
    </x-slot>
    <x-security.navbar />
    <div class="pb-4">
        <h2>Токени API</h2>
        @if (!$isApiEnabled)
            <div>API вимкнено. Якщо ви бажаєте використовувати API, будь ласка, увімкніть його в меню <a
                    href="{{ route('settings.advanced') }}" class="underline dark:text-white">Налаштування</a>.</div>
        @else
            <div>Токени створюються з поточною командою як областю дії.</div>
    </div>
    <h3>Новий Токен</h3>
    @can('create', App\Models\PersonalAccessToken::class)
        <form class="flex flex-col gap-2" wire:submit='addNewToken'>
            <div class="flex gap-2 items-end w-96">
                <x-forms.input required id="description" label="Опис" />
                <x-forms.button type="submit">Створити</x-forms.button>
            </div>
            <div class="flex">
                Дозволи
                <x-helper class="px-1" helper="Ці дозволи будуть надані токену." /><span
                    class="pr-1">:</span>
                <div class="flex gap-1 font-bold dark:text-white">
                    @if ($permissions)
                        @foreach ($permissions as $permission)
                            <div>{{ $permission }}</div>
                        @endforeach
                    @endif
                </div>
            </div>

            <h4>Дозволи Токена</h4>
            <div class="w-64">
                @if ($canUseRootPermissions)
                    <x-forms.checkbox label="root" wire:model.live="permissions" domValue="root"
                        helper="Доступ root, будьте обережні!" :checked="in_array('root', $permissions)"></x-forms.checkbox>
                @else
                    <x-forms.checkbox label="root (лише для адміністратора/власника)" disabled domValue="root"
                        helper="Доступ root вимагає ролі адміністратора або власника" :checked="false"></x-forms.checkbox>
                @endif

                @if (!in_array('root', $permissions))
                    @if ($canUseWritePermissions)
                        <x-forms.checkbox label="write" wire:model.live="permissions" domValue="write"
                            helper="Доступ на запис до всіх ресурсів." :checked="in_array('write', $permissions)"></x-forms.checkbox>
                    @else
                        <x-forms.checkbox label="write (лише для адміністратора/власника)" disabled domValue="write"
                            helper="Доступ на запис вимагає ролі адміністратора або власника" :checked="false"></x-forms.checkbox>
                    @endif

                    <x-forms.checkbox label="deploy" wire:model.live="permissions" domValue="deploy"
                        helper="Може запускати вебхуки розгортання." :checked="in_array('deploy', $permissions)"></x-forms.checkbox>
                    <x-forms.checkbox label="read" domValue="read" wire:model.live="permissions" domValue="read"
                        :checked="in_array('read', $permissions)"></x-forms.checkbox>
                    <x-forms.checkbox label="read:sensitive" wire:model.live="permissions" domValue="read:sensitive"
                        helper="Відповіді включатимуть секрети, логі, паролі та вміст файлів compose."
                        :checked="in_array('read:sensitive', $permissions)"></x-forms.checkbox>
                @endif
            </div>
            @if (in_array('root', $permissions))
                <div class="font-bold dark:text-warning">Доступ root, будьте обережні!</div>
            @endif
        </form>
    @endcan
    @if (session()->has('token'))
        <div class="py-4 font-bold dark:text-warning">Будь ласка, скопіюйте цей токен зараз. З міркувань безпеки він більше не буде показаний.
        </div>
        <div class="pb-4 font-bold dark:text-white"> {{ session('token') }}</div>
    @endif
    <h3 class="py-4">Випущені Токени</h3>
    <div class="grid gap-2 lg:grid-cols-1">
        @forelse ($tokens as $token)
            <div wire:key="token-{{ $token->id }}"
                class="flex flex-col gap-1 p-2 border dark:border-coolgray-200 hover:no-underline">
                <div>Опис: {{ $token->name }}</div>
                <div>Останнє використання: {{ $token->last_used_at ? $token->last_used_at->diffForHumans() : 'Ніколи' }}</div>
                <div class="flex gap-1">
                    @if ($token->abilities)
                        Дозволи:
                        @foreach ($token->abilities as $ability)
                            <div class="font-bold dark:text-white">{{ $ability }}</div>
                        @endforeach
                    @endif
                </div>

                @if (auth()->id() === $token->tokenable_id)
                    <x-modal-confirmation title="Підтвердити відкликання токена API?" isErrorButton buttonTitle="Відкликати токен"
                        submitAction="revoke({{ data_get($token, 'id') }})" :actions="[
                            'Цей токен API буде відкликано та назавжди видалено.',
                            'Будь-який виклик API, зроблений за допомогою цього токена, завершиться невдачею.',
                        ]"
                        confirmationText="{{ $token->name }}"
                        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши опис токена API нижче"
                        shortConfirmationLabel="Опис токена API" :confirmWithPassword="false"
                        step2ButtonText="Відкликати токен API" />
                @endif
            </div>
        @empty
            <div>
                <div>Токени API не знайдено.</div>
            </div>
        @endforelse
    </div>
    @endif
</div>