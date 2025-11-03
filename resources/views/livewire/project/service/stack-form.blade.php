<form wire:submit.prevent='submit' class="flex flex-col gap-4 pb-2">
    <div>
        <div class="flex gap-2">
            <h2>Стек сервісів</h2>
            @if (isDev())
                <div>{{ $service->compose_parsing_version }}</div>
            @endif
            <x-forms.button canGate="update" :canResource="$service" wire:target='submit'
                type="submit">Зберегти</x-forms.button>
            @can('update', $service)
                <x-modal-input buttonTitle="Редагувати файл Compose" title="Редагувати Docker Compose" :closeOutside="false">
                    <livewire:project.service.edit-compose serviceId="{{ $service->id }}" />
                </x-modal-input>
            @endcan
        </div>
        <div>Конфігурація</div>
    </div>
    <div class="flex gap-2">
        <x-forms.input canGate="update" :canResource="$service" id="name" required label="Назва сервісу"
            placeholder="Мій суперсайт WordPress" />
        <x-forms.input canGate="update" :canResource="$service" id="description" label="Опис" />
    </div>
    <div class="w-96">
        <x-forms.checkbox canGate="update" :canResource="$service" instantSave id="connectToDockerNetwork"
            label="Підключитися до заздалегідь визначеної мережі"
            helper="За замовчуванням ви не маєте доступу до мереж, визначених Coolify.<br>Запуск ресурсу на основі Docker Compose матиме внутрішню мережу. <br>Якщо ви підключаєтеся до мережі, визначеної Coolify, вам може знадобитися використовувати різні внутрішні імена DNS для підключення до ресурсу.<br><br>Для отримання додаткової інформації перегляньте <a class='underline dark:text-white' target='_blank' href='https://coolify.io/docs/knowledge-base/docker/compose#connect-to-predefined-networks'>це</a>." />
    </div>
    @if ($fields->count() > 0)
        <div>
            <h3>Конфігурація, специфічна для сервісу</h3>
        </div>
        <div class="grid grid-cols-2 gap-2">
            @foreach ($fields as $serviceName => $field)
                <div class="flex items-center gap-2"><span
                        class="font-bold">{{ data_get($field, 'serviceName') }}</span>{{ data_get($field, 'name') }}
                    @if (data_get($field, 'customHelper'))
                        <x-helper helper="{{ data_get($field, 'customHelper') }}" />
                    @else
                        <x-helper helper="Ім'я змінної: {{ $serviceName }}" />
                    @endif
                </div>
                <x-forms.input canGate="update" :canResource="$service"
                    type="{{ data_get($field, 'isPassword') ? 'password' : 'text' }}"
                    required="{{ str(data_get($field, 'rules'))?->contains('required') }}"
                    id="fields.{{ $serviceName }}.value"></x-forms.input>
            @endforeach
        </div>
    @endif
</form>