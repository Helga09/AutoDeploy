<div>
    <h2>Небезпечна зона</h2>
    <div class="">Ого. Сподіваюся, ви знаєте, що робите.</div>
    <h4 class="pt-4">Видалити ресурс</h4>
    <div class="pb-4">Це зупинить ваші контейнери, видалить усі пов'язані дані тощо. Обережно! Повернути нічого буде неможливо!
    </div>

    @if ($canDelete)
        <x-modal-confirmation title="Підтвердити видалення ресурсу?" buttonTitle="Видалити" isErrorButton submitAction="delete"
            buttonTitle="Видалити" :checkboxes="$checkboxes" :actions="['Безповоротно видалити всі контейнери цього ресурсу.']" confirmationText="{{ $resourceName }}"
            confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву ресурсу нижче"
            shortConfirmationLabel="Назва ресурсу" />
    @else
        <x-callout type="danger" title="Недостатньо дозволів">
            У вас немає дозволу на видалення цього ресурсу. Зверніться до адміністратора вашої команди для отримання доступу.
        </x-callout>
    @endif
</div>