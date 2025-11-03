<div class="w-full px-2">
    <x-modal-confirmation buttonFullWidth title="Підтвердити видалення команди?" buttonTitle="Видалити команду" isErrorButton
        submitAction="delete" :actions="['Поточну команду буде безповоротно видалено.']" confirmationText="{{ $team }}"
        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву команди нижче"
        shortConfirmationLabel="Назва команди" />
</div>