<div>
    <div class="flex gap-2">
        <h2>Заплановані завдання</h2>
        @can('update', $resource)
            <x-modal-input buttonTitle="+ Додати" title="Нове заплановане завдання" :closeOutside="false">
                @if ($resource->type() == 'application')
                    <livewire:project.shared.scheduled-task.add :type="$resource->type()" :id="$resource->id" :containerNames="$containerNames" />
                @elseif ($resource->type() == 'service')
                    <livewire:project.shared.scheduled-task.add :type="$resource->type()" :id="$resource->id" :containerNames="$containerNames" />
                @endif
            </x-modal-input>
        @endcan
    </div>
    <div class="flex flex-col flex-wrap gap-2 pt-4">
        @forelse($resource->scheduled_tasks as $task)
            @if ($resource->type() == 'application')
                <a class="box"
                    href="{{ route('project.application.scheduled-tasks', [...$parameters, 'task_uuid' => $task->uuid]) }}">
                    <span class="flex flex-col">
                        <span class="text-lg font-bold">{{ $task->name }}
                            @if ($task->container)
                                <span class="text-xs font-normal">({{ $task->container }})</span>
                            @endif
                        </span>

                        <span>Частота: {{ $task->frequency }}</span>
                        <span>Останній запуск: {{ data_get($task->latest_log, 'status', 'Запусків ще не було') }}
                        </span>
                    </span>
                </a>
            @elseif ($resource->type() == 'service')
                <a class="box"
                    href="{{ route('project.service.scheduled-tasks', [...$parameters, 'task_uuid' => $task->uuid]) }}">
                    <span class="flex flex-col">
                        <span class="text-lg font-bold">{{ $task->name }}
                            @if ($task->container)
                                <span class="text-xs font-normal">({{ $task->container }})</span>
                            @endif
                        </span>
                        <span>Частота: {{ $task->frequency }}</span>
                        <span>Останній запуск: {{ data_get($task->latest_log, 'status', 'Запусків ще не було') }}
                        </span>
                    </span>
                </a>
            @endif
        @empty
            <div>Заплановані завдання не налаштовані.</div>
        @endforelse
    </div>
</div>