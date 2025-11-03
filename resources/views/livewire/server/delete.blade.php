<div>
    <x-slot:title>
        {{ data_get_str($server, 'name')->limit(10) }} > Видалити сервер | AutoDeploy
    </x-slot>
    <livewire:server.navbar :server="$server" />
    <div class="flex flex-col h-full gap-8 sm:flex-row">
        <x-server.sidebar :server="$server" activeMenu="danger" />
        <div class="w-full">
            @if ($server->id !== 0)
                <h2>Небезпечна зона</h2>
                <div class="">Ого. Сподіваюся, ви знаєте, що робите.</div>
                <h4 class="pt-4">Видалити сервер</h4>
                <div class="pb-4">Це видалить сервер з AutoDeploy. Будьте обережні! Повернути його буде неможливо!
                </div>
                @if ($server->definedResources()->count() > 0)
                    <div class="pb-2 text-red-500">Вам потрібно видалити всі ресурси перед видаленням цього сервера.</div>
                @endif

                <x-modal-confirmation title="Підтвердити видалення сервера?" isErrorButton buttonTitle="Видалити"
                    submitAction="delete"
                    :actions="['Цей сервер буде назавжди видалено з AutoDeploy.']"
                    :checkboxes="$checkboxes"
                    confirmationText="{{ $server->name }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши ім'я сервера нижче"
                    shortConfirmationLabel="Ім'я сервера" />
            @endif
        </div>
    </div>
</div>