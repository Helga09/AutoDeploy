<div>
    <x-slot:title>
        Адміністратор команди | Coolify
    </x-slot>
    <x-team.navbar />
    <h2>Вигляд адміністратора</h2>
    <div class="subtitle">
        Керуйте користувачами цього інстансу.
    </div>
    <form wire:submit="submitSearch" class="flex flex-col gap-2 lg:flex-row">
        <x-forms.input wire:model="search" placeholder="Пошук користувача" />
        <x-forms.button type="submit">Пошук</x-forms.button>
    </form>
    <h3 class="py-4">Користувачі</h3>
    <div class="grid grid-cols-1 gap-2 lg:grid-cols-2">
        @forelse ($users as $user)
            <div wire:key="user-{{ $user->id }}"
                class="flex items-center justify-center gap-2 bg-white box-without-bg dark:bg-coolgray-100">
                <div>{{ $user->name }}</div>
                <div>{{ $user->email }}</div>
                <div class="flex-1"></div>
                <div class="flex items-center justify-center gap-2 mx-4 text-xs font-bold ">
                    <x-modal-confirmation title="Підтвердити видалення користувача?" buttonTitle="Видалити" isErrorButton
                        submitAction="delete({{ $user->id }})" :actions="[
                            'Вибраний користувач буде назавжди видалений з бази даних Coolify.',
                            'Усі ресурси (додатки, бази даних, сервіси, конфігурації, сервери, приватні ключі, теги тощо), пов\'язані з командою за замовчуванням цього користувача, будуть видалені з бази даних Coolify.',
                        ]"
                        confirmationText="{{ $user->name }}"
                        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши ім'я користувача нижче"
                        shortConfirmationLabel="Ім'я користувача" />
                </div>
            </div>
        @empty
            <div>Користувачів, окрім кореневого, не знайдено.</div>
        @endforelse
        @if ($lots_of_users)
            <div>Відображено більше користувачів, ніж показано. Будь ласка, скористайтеся рядком пошуку, щоб знайти потрібного користувача.</div>
        @endif
    </div>
</div>