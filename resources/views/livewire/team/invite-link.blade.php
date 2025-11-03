@can('manageInvitations', currentTeam())
    <form wire:submit='viaLink' class="flex gap-2 flex-col lg:flex-row items-end">
        <div class="flex flex-1 lg:w-fit w-full gap-2">
            <x-forms.input id="email" type="email" label="Електронна пошта" name="email" placeholder="Електронна пошта" required />
            <x-forms.select id="role" name="role" label="Роль">
                @if (auth()->user()->role() === 'owner')
                    <option value="owner">Власник</option>
                @endif
                <option value="admin">Адміністратор</option>
                <option value="member">Учасник</option>
            </x-forms.select>
        </div>
        <div class="flex gap-2 lg:w-fit w-full">
            <x-forms.button type="submit">Згенерувати посилання-запрошення</x-forms.button>
            @if (is_transactional_emails_enabled())
                <x-forms.button wire:click.prevent='viaEmail'>Надіслати запрошення електронною поштою</x-forms.button>
            @endif
        </div>
    </form>
@endcan