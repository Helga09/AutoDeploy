<x-modal-confirmation title="Підтвердити видалення проєкту?" buttonTitle="Видалити проєкт" isErrorButton submitAction="delete"
    :actions="[
        'Це видалить обраний проєкт',
        'Усі середовища в проєкті також будуть видалені.',
    ]" confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву проєкту нижче"
    shortConfirmationLabel="Назва проєкту" confirmationText="{{ $projectName }}" :confirmWithPassword="false"
    step2ButtonText="Видалити безповоротно" />