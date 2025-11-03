<div>
    <x-slot:title>
        Команди | Coolify
    </x-slot>
    <x-team.navbar />

    <form class="flex flex-col" wire:submit='submit'>
        <h2>Загальні</h2>
        <div class="subtitle">
            Керуйте загальними налаштуваннями цієї команди.
        </div>

        <div class="flex items-end gap-2 pb-6">
            <x-forms.input id="name" label="Назва" required canGate="update" :canResource="$team" />
            <x-forms.input id="description" label="Опис" canGate="update" :canResource="$team" />
            @can('update', $team)
                <x-forms.button type="submit">
                    Зберегти
                </x-forms.button>
            @endcan
        </div>
    </form>

    @can('delete', $team)
        <div>
            <h2>Небезпечна зона</h2>
            <div class="pb-4">Ого. Сподіваюся, ви знаєте, що робите.</div>
            <h4 class="pb-4">Видалити команду</h4>
            @if (session('currentTeam.id') === 0)
                <div>Це команда за замовчуванням. Ви не можете її видалити.</div>
            @elseif(auth()->user()->teams()->get()->count() === 1 || auth()->user()->currentTeam()->personal_team)
                <div>Ви не можете видалити свою останню / особисту команду.</div>
            @elseif(currentTeam()->subscription)
                <div>Будь ласка, скасуйте вашу підписку <a class="underline dark:text-white"
                        href="{{ route('subscription.show') }}">тут</a> перед видаленням цієї команди.</div>
            @else
                @if (currentTeam()->isEmpty())
                    <div class="pb-4">Це призведе до видалення вашої команди. Будьте обережні! Повернення немає!</div>
                    <x-modal-confirmation title="Підтвердити видалення команди?" buttonTitle="Видалити" isErrorButton
                        submitAction="delete({{ currentTeam()->id }})" :actions="['Поточна команда буде безповоротно видалена з Coolify та бази даних.']"
                        confirmationText="{{ currentTeam()->name }}"
                        confirmationLabel="Будь ласка, підтвердіть виконання дій, ввівши назву команди нижче"
                        shortConfirmationLabel="Назва команди" :confirmWithPassword="false" step2ButtonText="Видалити безповоротно" />
                @else
                    <div>
                        <div class="pb-4">Вам потрібно видалити наступні ресурси, щоб мати можливість видалити команду:</div>
                        @if (currentTeam()->projects()->count() > 0)
                            <h4 class="pb-4">Проєкти:</h4>
                            <ul class="pl-8 list-disc">
                                @foreach (currentTeam()->projects as $resource)
                                    <li>{{ $resource->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if (currentTeam()->servers()->count() > 0)
                            <h4 class="py-4">Сервери:</h4>
                            <ul class="pl-8 list-disc">
                                @foreach (currentTeam()->servers as $resource)
                                    <li>{{ $resource->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if (currentTeam()->privateKeys()->count() > 0)
                            <h4 class="py-4">Приватні ключі:</h4>
                            <ul class="pl-8 list-disc">
                                @foreach (currentTeam()->privateKeys as $resource)
                                    <li>{{ $resource->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                        @if (currentTeam()->sources()->count() > 0)
                            <h4 class="py-4">Джерела:</h4>
                            <ul class="pl-8 list-disc">
                                @foreach (currentTeam()->sources() as $resource)
                                    <li>{{ $resource->name }}</li>
                                @endforeach
                            </ul>
                        @endif
                @endif
            @endif
        </div>
    @endcan
</div>