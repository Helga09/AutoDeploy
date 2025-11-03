<form wire:submit="submit">
    <div class="flex gap-2 pb-2">
        <h2>Заплановане резервне копіювання</h2>
        <x-forms.button type="submit">
            Зберегти
        </x-forms.button>
        @if (str($status)->startsWith('running'))
            <livewire:project.database.backup-now :backup="$backup" />
        @endif
        @if ($backup->database_id !== 0)
            <x-modal-confirmation title="Підтвердити видалення розкладу резервного копіювання?" buttonTitle="Видалити резервні копії та розклад"
                isErrorButton submitAction="delete" :checkboxes="$checkboxes" :actions="[
                    'Вибраний розклад резервного копіювання буде видалено.',
                    'Заплановані резервні копії для цієї бази даних буде зупинено (якщо це єдиний розклад резервного копіювання для цієї бази даних).',
                ]"
                confirmationText="{{ $backup->database->name }}"
                confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву бази даних запланованих резервних копій нижче"
                shortConfirmationLabel="Назва бази даних" />
        @endif
    </div>
    <div class="w-64 pb-2">
        <x-forms.checkbox instantSave label="Резервне копіювання увімкнено" id="backupEnabled" />
        @if ($s3s->count() > 0)
            <x-forms.checkbox instantSave label="S3 увімкнено" id="saveS3" />
        @else
            <x-forms.checkbox instantSave helper="Немає доступного перевіреного S3 сховища." label="S3 увімкнено" id="saveS3"
                disabled />
        @endif
        @if ($backup->save_s3)
            <x-forms.checkbox instantSave label="Вимкнути локальне резервне копіювання" id="disableLocalBackup"
                helper="Після ввімкнення файли резервних копій буде видалено з локального сховища одразу після завантаження до S3. Для цього потрібне увімкнене резервне копіювання S3." />
        @else
            <x-forms.checkbox disabled label="Вимкнути локальне резервне копіювання" id="disableLocalBackup"
                helper="Після ввімкнення файли резервних копій буде видалено з локального сховища одразу після завантаження до S3. Для цього потрібне увімкнене резервне копіювання S3." />
        @endif
    </div>
    @if ($backup->save_s3)
        <div class="pb-6">
            <x-forms.select id="s3StorageId" label="S3 сховище" required>
                <option value="default" disabled>Виберіть S3 сховище</option>
                @foreach ($s3s as $s3)
                    <option value="{{ $s3->id }}">{{ $s3->name }}</option>
                @endforeach
            </x-forms.select>
        </div>
    @endif
    <div class="flex flex-col gap-2">
        <h3>Налаштування</h3>
        <div class="flex gap-2 flex-col ">
            @if ($backup->database_type === 'App\Models\StandalonePostgresql' && $backup->database_id !== 0)
                <div class="w-48">
                    <x-forms.checkbox label="Резервне копіювання всіх баз даних" id="dumpAll" instantSave />
                </div>
                @if (!$backup->dump_all)
                    <x-forms.input label="Бази даних для резервного копіювання"
                        helper="Список баз даних для резервного копіювання, розділений комами. Порожнє поле включатиме базу даних за замовчуванням."
                        id="databasesToBackup" />
                @endif
            @elseif($backup->database_type === 'App\Models\StandaloneMongodb')
                <x-forms.input label="Бази даних для включення"
                    helper="Список баз даних для резервного копіювання. Ви можете вказати, які колекції для кожної бази даних виключити з резервної копії. Порожнє поле включатиме всі бази даних та колекції.<br><br>Приклад:<br><br>database1:collection1,collection2|database2:collection3,collection4<br><br> database1 включатиме всі колекції, крім collection1 та collection2. <br>database2 включатиме всі колекції, крім collection3 та collection4.<br><br>Інший приклад:<br><br>database1:collection1|database2<br><br> database1 включатиме всі колекції, крім collection1.<br>database2 включатиме ВСІ колекції."
                    id="databasesToBackup" />
            @elseif($backup->database_type === 'App\Models\StandaloneMysql')
                <div class="w-48">
                    <x-forms.checkbox label="Резервне копіювання всіх баз даних" id="dumpAll" instantSave />
                </div>
                @if (!$backup->dump_all)
                    <x-forms.input label="Бази даних для резервного копіювання"
                        helper="Список баз даних для резервного копіювання, розділений комами. Порожнє поле включатиме базу даних за замовчуванням."
                        id="databasesToBackup" />
                @endif
            @elseif($backup->database_type === 'App\Models\StandaloneMariadb')
                <div class="w-48">
                    <x-forms.checkbox label="Резервне копіювання всіх баз даних" id="dumpAll" instantSave />
                </div>
                @if (!$backup->dump_all)
                    <x-forms.input label="Бази даних для резервного копіювання"
                        helper="Список баз даних для резервного копіювання, розділений комами. Порожнє поле включатиме базу даних за замовчуванням."
                        id="databasesToBackup" />
                @endif
            @endif
        </div>
        <div class="flex gap-2">
            <x-forms.input label="Частота" id="frequency" />
            <x-forms.input label="Часовий пояс" id="timezone" disabled
                helper="Часовий пояс сервера, на якому заплановано виконання резервного копіювання (якщо не встановлено, буде використано часовий пояс інстансу)" />
            <x-forms.input label="Таймаут" id="timeout" helper="Таймаут завдання резервного копіювання в секундах." />
        </div>

        <h3 class="mt-6 mb-2 text-lg font-medium">Налаштування збереження резервних копій</h3>
        <div class="mb-4">
            <ul class="list-disc pl-6 space-y-2">
                <li>Встановлення значення 0 означає необмежене збереження.</li>
                <li>Правила збереження працюють незалежно – яке б обмеження не було досягнуто першим, воно запустить очищення.</li>
            </ul>
        </div>

        <div class="flex gap-6 flex-col">
            <div>
                <h4 class="mb-3 font-medium">Збереження локальних резервних копій</h4>
                <div class="flex gap-2">
                    <x-forms.input label="Кількість резервних копій для збереження" id="databaseBackupRetentionAmountLocally"
                        type="number" min="0"
                        helper="Зберігає лише вказану кількість найновіших резервних копій на сервері. Встановіть 0 для необмеженої кількості резервних копій." />
                    <x-forms.input label="Днів для збереження резервних копій" id="databaseBackupRetentionDaysLocally" type="number"
                        min="0"
                        helper="Автоматично видаляє резервні копії, старіші за вказану кількість днів. Встановіть 0 для відсутності обмеження за часом." />
                    <x-forms.input label="Максимальний обсяг сховища (ГБ)" id="databaseBackupRetentionMaxStorageLocally"
                        type="number" min="0" step="0.0000001"
                        helper="Коли загальний розмір усіх резервних копій у поточному завданні резервного копіювання перевищує цей ліміт у ГБ, найстаріші резервні копії будуть видалені. Підтримуються десяткові значення (наприклад, 0.001 для 1 МБ). Встановіть 0 для необмеженого сховища." />
                </div>
            </div>

            @if ($backup->save_s3)
                <div>
                    <h4 class="mb-3 font-medium">Збереження S3 сховища</h4>
                    <div class="flex gap-2">
                        <x-forms.input label="Кількість резервних копій для збереження" id="databaseBackupRetentionAmountS3"
                            type="number" min="0"
                            helper="Зберігає лише вказану кількість найновіших резервних копій у S3 сховищі. Встановіть 0 для необмеженої кількості резервних копій." />
                        <x-forms.input label="Днів для збереження резервних копій" id="databaseBackupRetentionDaysS3" type="number"
                            min="0"
                            helper="Автоматично видаляє S3 резервні копії, старіші за вказану кількість днів. Встановіть 0 для відсутності обмеження за часом." />
                        <x-forms.input label="Максимальний обсяг сховища (ГБ)" id="databaseBackupRetentionMaxStorageS3"
                            type="number" min="0" step="0.0000001"
                            helper="Коли загальний розмір усіх резервних копій у поточному завданні резервного копіювання перевищує цей ліміт у ГБ, найстаріші резервні копії будуть видалені. Підтримуються десяткові значення (наприклад, 0.5 для 500 МБ). Встановіть 0 для необмеженого сховища." />
                    </div>
                </div>
            @endif
        </div>
    </div>
</form>