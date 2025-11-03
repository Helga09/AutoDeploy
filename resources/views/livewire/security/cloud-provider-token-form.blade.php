<div class="w-full">
    <form class="flex flex-col gap-2 {{ $modal_mode ? 'w-full' : '' }}" wire:submit='addToken'>
        @if ($modal_mode)
            {{-- Modal layout: vertical, compact --}}
            @if (!isset($provider) || empty($provider) || $provider === '')
                <x-forms.select required id="provider" label="Провайдер">
                    <option value="hetzner">Hetzner</option>
                    <option value="digitalocean">DigitalOcean</option>
                </x-forms.select>
            @else
                <input type="hidden" wire:model="provider" />
            @endif

            <x-forms.input required id="name" label="Назва токена"
                placeholder="напр., Production Hetzner. підказка: додайте назву проекту Hetzner для легшої ідентифікації" />

            <x-forms.input required type="password" id="token" label="API Токен" placeholder="Введіть ваш API токен" />

            @if (auth()->user()->currentTeam()->cloudProviderTokens->where('provider', $provider)->isEmpty())
                <div class="text-sm text-neutral-500 dark:text-neutral-400">
                    Створіть API токен у <a
                        href='{{ $provider === 'hetzner' ? 'https://console.hetzner.com/projects' : '#' }}' target='_blank'
                        class='underline dark:text-white'>Консолі {{ ucfirst($provider) }}</a> → виберіть Проект → Безпека → API Токени.
                    @if ($provider === 'hetzner')
                        <br><br>
                        Немає облікового запису Hetzner? <a href='https://AutoDeploy.io/hetzner' target='_blank'
                            class='underline dark:text-white'>Зареєструйтесь тут</a>
                        <br>
                        <span class="text-xs">(Партнерське посилання AutoDeploy, лише для нових облікових записів - підтримує нас (€10)
                        і дає вам €20)</span>
                    @endif
                </div>
            @endif

            <x-forms.button type="submit">Перевірити та додати токен</x-forms.button>
        @else
            {{-- Full page layout: horizontal, spacious --}}
            <div class="flex gap-2 items-end flex-wrap">
                <div class="w-64">
                    <x-forms.select required id="provider" label="Провайдер" disabled>
                        <option value="hetzner" selected>Hetzner</option>
                        <option value="digitalocean">DigitalOcean</option>
                    </x-forms.select>
                </div>
                <div class="flex-1 min-w-64">
                    <x-forms.input required id="name" label="Назва токена"
                        placeholder="напр., Production Hetzner. підказка: додайте назву проекту Hetzner для легшої ідентифікації" />
                </div>
            </div>
            <div class="flex-1 min-w-64">
                <x-forms.input required type="password" id="token" label="API Токен" placeholder="Введіть ваш API токен" />
                @if (auth()->user()->currentTeam()->cloudProviderTokens->where('provider', $provider)->isEmpty())
                    <div class="text-sm text-neutral-500 dark:text-neutral-400 mt-2">
                        Створіть API токен у <a href='https://console.hetzner.com/projects' target='_blank'
                            class='underline dark:text-white'>Консолі Hetzner</a> → виберіть Проект → Безпека → API
                        Токени.
                        <br><br>
                        Немає облікового запису Hetzner? <a href='https://AutoDeploy.io/hetzner' target='_blank'
                            class='underline dark:text-white'>Зареєструйтесь тут</a>
                        <br>
                        <span class="text-xs">(Партнерське посилання AutoDeploy, лише для нових облікових записів - підтримує нас (€10)
                        і дає вам €20)</span>
                    </div>
                @endif
            </div>
            <x-forms.button type="submit">Перевірити та додати токен</x-forms.button>
        @endif
    </form>
</div>