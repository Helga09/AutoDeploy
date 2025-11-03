<div>
    <form wire:submit='submit'>
        <div class="flex items-center gap-2 pb-4">
            @if ($application->human_name)
                <h2>{{ Str::headline($application->human_name) }}</h2>
            @else
                <h2>{{ Str::headline($application->name) }}</h2>
            @endif
            <x-forms.button canGate="update" :canResource="$application" type="submit">Зберегти</x-forms.button>
            @can('update', $application)
                <x-modal-confirmation wire:click="convertToDatabase" title="Перетворити в базу даних"
                    buttonTitle="Перетворити в базу даних" submitAction="convertToDatabase" :actions="['Вибраний ресурс буде перетворено на службову базу даних.']"
                    confirmationText="{{ Str::headline($application->name) }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву службової програми нижче"
                    shortConfirmationLabel="Назва службової програми" />
            @endcan
            @can('delete', $application)
                <x-modal-confirmation title="Підтвердити видалення службової програми?" buttonTitle="Видалити" isErrorButton
                    submitAction="delete" :actions="['Вибраний контейнер службової програми буде зупинено та безповоротно видалено.']" confirmationText="{{ Str::headline($application->name) }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву службової програми нижче"
                    shortConfirmationLabel="Назва службової програми" />
            @endcan
        </div>
        <div class="flex flex-col gap-2">
            <div class="flex gap-2">
                <x-forms.input canGate="update" :canResource="$application" label="Назва" id="humanName"
                    placeholder="Зрозуміла для людини назва"></x-forms.input>
                <x-forms.input canGate="update" :canResource="$application" label="Опис"
                    id="description"></x-forms.input>
            </div>
            <div class="flex gap-2">
                @if (!$application->serviceType()?->contains(str($application->image)->before(':')))
                    @if ($application->required_fqdn)
                        <x-forms.input canGate="update" :canResource="$application" required placeholder="https://app.coolify.io"
                            label="Домени" id="fqdn"
                            helper="Ви можете вказати один домен зі шляхом або кілька через кому. Ви можете вказати порт для прив'язки домену.<br><br><span class='text-helper'>Приклад</span><br>- http://app.coolify.io,https://cloud.coolify.io/dashboard<br>- http://app.coolify.io/api/v3<br>- http://app.coolify.io:3000 -> app.coolify.io буде вказувати на порт 3000 всередині контейнера. "></x-forms.input>
                    @else
                        <x-forms.input canGate="update" :canResource="$application" placeholder="https://app.coolify.io"
                            label="Домени" id="fqdn"
                            helper="Ви можете вказати один домен зі шляхом або кілька через кому. Ви можете вказати порт для прив'язки домену.<br><br><span class='text-helper'>Приклад</span><br>- http://app.coolify.io,https://cloud.coolify.io/dashboard<br>- http://app.coolify.io/api/v3<br>- http://app.coolify.io:3000 -> app.coolify.io буде вказувати на порт 3000 всередині контейнера. "></x-forms.input>
                    @endif
                @endif
                <x-forms.input canGate="update" :canResource="$application"
                    helper="Ви можете змінити образ, який хочете розгорнути.<br><br><span class='dark:text-warning'>УВАГА. Ви можете пошкодити свої дані. Робіть це лише якщо знаєте, що робите.</span>"
                    label="Образ" id="image"></x-forms.input>
            </div>
        </div>
        <h3 class="py-2 pt-4">Додатково</h3>
        <div class="w-96 flex flex-col gap-1">
            @if (str($application->image)->contains('pocketbase'))
                <x-forms.checkbox canGate="update" :canResource="$application" instantSave id="isGzipEnabled"
                    label="Увімкнути Gzip стиснення"
                    helper="Pocketbase не потребує Gzip стиснення, інакше SSE не працюватиме." disabled />
            @else
                <x-forms.checkbox canGate="update" :canResource="$application" instantSave id="isGzipEnabled"
                    label="Увімкнути Gzip стиснення"
                    helper="Ви можете вимкнути Gzip стиснення, якщо бажаєте. Деякі сервіси стискають дані за замовчуванням. У цьому випадку вам це не потрібно." />
            @endif
            <x-forms.checkbox canGate="update" :canResource="$application" instantSave id="isStripprefixEnabled"
                label="Видаляти префікси"
                helper="Видалення префіксів використовується для видалення префіксів зі шляхів. Наприклад, /api/ до /api." />
            <x-forms.checkbox canGate="update" :canResource="$application" instantSave label="Виключити зі статусу сервісу"
                helper="Якщо вам не потрібно моніторити цей ресурс, увімкніть. Корисно, якщо цей сервіс є необов'язковим."
                id="excludeFromStatus"></x-forms.checkbox>
            <x-forms.checkbox canGate="update" :canResource="$application"
                helper="Відводити логи до налаштованої кінцевої точки відведення логів у налаштуваннях вашого сервера."
                instantSave="instantSaveAdvanced" id="isLogDrainEnabled" label="Відводити логи" />
        </div>
    </form>
    
    <x-domain-conflict-modal 
        :conflicts="$domainConflicts" 
        :showModal="$showDomainConflictModal" 
        confirmAction="confirmDomainUsage">
        <x-slot:consequences>
            <ul class="mt-2 ml-4 list-disc">
                <li>Лише один сервіс буде доступний за цим доменом</li>
                <li>Поведінка маршрутизації буде непередбачуваною</li>
                <li>Ви можете зіткнутися з перебоями в роботі сервісу</li>
                <li>Сертифікати SSL можуть працювати некоректно</li>
            </ul>
        </x-slot:consequences>
    </x-domain-conflict-modal>
</div>