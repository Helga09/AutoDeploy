<form>
    <x-slot:title>
        {{ data_get_str($project, 'name')->limit(10) }} > Клонувати | AutoDeploy
    </x-slot>
    <div class="flex flex-col">
        <h1>Клонувати</h1>
        <div class="subtitle ">Швидко клонуйте всі ресурси в новий проєкт або середовище.</div>
    </div>
    <x-forms.input required id="newName" label="Нова Назва" />
    <h3 class="pt-8 ">Сервер Призначення</h3>
    <div class="pb-2">Оберіть сервер та мережу, куди клонувати ресурси.</div>
    <div class="flex flex-col">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Сервер</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Мережа</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($servers->sortBy('id') as $server)
                                    @foreach ($server->destinations() as $destination)
                                        <tr class="cursor-pointer hover:bg-coolgray-50 dark:hover:bg-coolgray-200"
                                            wire:click="selectServer('{{ $server->id }}', '{{ $destination->id }}')">
                                            <td class="px-5 py-4 text-sm whitespace-nowrap dark:text-white"
                                                :class="'{{ $selectedDestination === $destination->id }}' ?
                                                'bg-coollabs text-white' : 'dark:bg-coolgray-100 bg-white'">
                                                {{ $server->name }}</td>
                                            <td class="px-5 py-4 text-sm whitespace-nowrap dark:text-white "
                                                :class="'{{ $selectedDestination === $destination->id }}' ?
                                                'bg-coollabs text-white' : 'dark:bg-coolgray-100 bg-white'">
                                                {{ $destination->name }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="pt-8">Ресурси</h3>
    <div class="pb-2">Їх буде клоновано в новий проєкт</div>
    <div class="flex flex-col pt-4">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Назва</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Тип</th>
                                    <th class="px-5 py-3 text-xs font-medium text-left uppercase">Опис</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($environment->applications->sortBy('name') as $application)
                                    <tr>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap font-bold dark:text-white">
                                            {{ $application->name }}</td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap dark:text-white">Застосунок</td>
                                        <td class="px-5 py-4 text-sm dark:text-white">
                                            {{ $application->description ?: '-' }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($environment->databases()->sortBy('name') as $database)
                                    <tr>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap font-bold dark:text-white">
                                            {{ $database->name }}
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap dark:text-white">База Даних</td>
                                        <td class="px-5 py-4 text-sm dark:text-white">
                                            {{ $database->description ?: '-' }}</td>
                                    </tr>
                                @endforeach
                                @foreach ($environment->services->sortBy('name') as $service)
                                    <tr>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap font-bold dark:text-white">
                                            {{ $service->name }}
                                        </td>
                                        <td class="px-5 py-4 text-sm whitespace-nowrap dark:text-white">Сервіс</td>
                                        <td class="px-5 py-4 text-sm dark:text-white">
                                            {{ $service->description ?: '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="flex gap-4 pt-4 w-full">
        <x-forms.button isHighlighted class="w-full" wire:click="clone('project')" :disabled="!filled($selectedDestination)">Клонувати в новий
            Проєкт</x-forms.button>
        <x-forms.button isHighlighted class="w-full" wire:click="clone('environment')" :disabled="!filled($selectedDestination)">Клонувати в нове
            Середовище</x-forms.button>
    </div>
</form>