<x-modal-confirmation title="Підтвердити видалення середовища?" buttonTitle="Видалити середовище" isErrorButton
    submitAction="delete" :actions="['Це видалить вибране середовище.']"
    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву середовища нижче"
    shortConfirmationLabel="Назва середовища" confirmationText="{{ $environmentName }}" :confirmWithPassword="false"
    step2ButtonText="Видалити назавжди" />