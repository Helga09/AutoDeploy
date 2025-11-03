<div class="w-full">
    <form wire:submit.prevent='submit' class="flex flex-col w-full gap-2">
        <div class="pb-2">Примітка: Якщо служба має визначений порт, не видаляйте його. <br>Якщо ви бажаєте використовувати власний домен, ви можете додати його з портом.</div>
        <x-forms.input canGate="update" :canResource="$application" placeholder="https://app.AutoDeploy.io" label="Домени"
            id="fqdn"
            helper="Ви можете вказати один домен зі шляхом або декілька, розділивши їх комами. Ви можете вказати порт для прив'язки домену.<br><br><span class='text-helper'>Приклад</span><br>- http://app.AutoDeploy.io,https://cloud.AutoDeploy.io/dashboard<br>- http://app.AutoDeploy.io/api/v3<br>- http://app.AutoDeploy.io:3000 -> app.AutoDeploy.io вказуватиме на порт 3000 всередині контейнера. "></x-forms.input>
        <x-forms.button canGate="update" :canResource="$application" type="submit">Зберегти</x-forms.button>
    </form>

    <x-domain-conflict-modal :conflicts="$domainConflicts" :showModal="$showDomainConflictModal" confirmAction="confirmDomainUsage">
        <x-slot:consequences>
            <ul class="mt-2 ml-4 list-disc">
                <li>Лише одна служба буде доступна за цим доменом</li>
                <li>Поведінка маршрутизації буде непередбачуваною</li>
                <li>Ви можете відчувати перебої в роботі служб</li>
                <li>Сертифікати SSL можуть працювати некоректно</li>
            </ul>
        </x-slot:consequences>
    </x-domain-conflict-modal>
</div>