<div>
    <x-slot:title>
        {{ data_get_str($project, 'name')->limit(10) }} > Ресурси | AutoDeploy
    </x-slot>
    <div class="flex flex-col">
        <div class="flex items-center gap-2">
            <h1>Ресурси</h1>
            @if ($environment->isEmpty())
                @can('createAnyResource')
                    <a class="button"
                        href="{{ route('project.clone-me', ['project_uuid' => data_get($project, 'uuid'), 'environment_uuid' => data_get($environment, 'uuid')]) }}">
                        Клонувати
                    </a>
                @endcan
            @else
                @can('createAnyResource')
                    <a href="{{ route('project.resource.create', ['project_uuid' => data_get($parameters, 'project_uuid'), 'environment_uuid' => data_get($environment, 'uuid')]) }}"
                        class="button">+
                        Новий</a>
                @endcan
                @can('createAnyResource')
                    <a class="button"
                        href="{{ route('project.clone-me', ['project_uuid' => data_get($project, 'uuid'), 'environment_uuid' => data_get($environment, 'uuid')]) }}">
                        Клонувати
                    </a>
                @endcan
            @endif
            @can('delete', $environment)
                <livewire:project.delete-environment :disabled="!$environment->isEmpty()" :environment_id="$environment->id" />
            @endcan
        </div>
        <nav class="flex pt-2 pb-6">
            <ol class="flex items-center">
                <li class="inline-flex items-center">
                    <a class="text-xs truncate lg:text-sm"
                        href="{{ route('project.show', ['project_uuid' => data_get($parameters, 'project_uuid')]) }}">
                        {{ $project->name }}</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg aria-hidden="true" class="w-4 h-4 mx-1 font-bold dark:text-warning" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>

                        <livewire:project.resource.environment-select :environments="$project->environments" />
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    @if ($environment->isEmpty())
        @can('createAnyResource')
            <a href="{{ route('project.resource.create', ['project_uuid' => data_get($parameters, 'project_uuid'), 'environment_uuid' => data_get($environment, 'uuid')]) }}"
                class="items-center justify-center box">+ Додати ресурс</a>
        @else
            <div
                class="flex flex-col items-center justify-center p-8 text-center border border-dashed border-neutral-300 dark:border-coolgray-300 rounded-lg">
                <h3 class="mb-2 text-lg font-semibold text-neutral-600 dark:text-neutral-400">Ресурси не знайдено</h3>
                <p class="text-sm text-neutral-600 dark:text-neutral-400">
                    Це середовище ще не має жодних ресурсів.<br>
                    Зверніться до адміністратора вашої команди, щоб додати ресурси.
                </p>
            </div>
        @endcan
    @else
        <div x-data="searchComponent()">
            <x-forms.input placeholder="Пошук за назвою, FQDN..." x-model="search" id="null" />
            <template
                x-if="filteredApplications.length === 0 && filteredDatabases.length === 0 && filteredServices.length === 0">
                <div class="flex flex-col items-center justify-center p-8 text-center">
                    <div x-show="search.length > 0">
                        <p class="text-neutral-600 dark:text-neutral-400">Ресурсів за запитом "<span
                                class="font-semibold" x-text="search"></span>" не знайдено.</p>
                        <p class="text-sm text-neutral-500 dark:text-neutral-500 mt-1">Спробуйте змінити критерії пошуку.
                        </p>
                    </div>
                    <div x-show="search.length === 0">
                        <p class="text-neutral-600 dark:text-neutral-400">У цьому середовищі ресурсів не знайдено.</p>
                        @cannot('createAnyResource')
                            <p class="text-sm text-neutral-500 dark:text-neutral-500 mt-1">Зверніться до адміністратора вашої команди,
                                щоб додати ресурси.</p>
                        @endcannot
                    </div>
                </div>
            </template>

            <template x-if="filteredApplications.length > 0">
                <h2 class="pt-4">Застосунки</h2>
            </template>
            <div x-show="filteredApplications.length > 0"
                class="grid grid-cols-1 gap-4 pt-4 lg:grid-cols-2 xl:grid-cols-3">
                <template x-for="item in filteredApplications" :key="item.uuid">
                    <span>
                        <a class="h-24 box group" :href="item.hrefLink">
                            <div class="flex flex-col w-full">
                                <div class="flex gap-2 px-4">
                                    <div class="pb-2 truncate box-title" x-text="item.name"></div>
                                    <div class="flex-1"></div>
                                    <template x-if="item.status.startsWith('running')">
                                        <div title="працює" class="bg-success badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('exited')">
                                        <div title="зупинено" class="bg-error badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('starting')">
                                        <div title="запускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('restarting')">
                                        <div title="перезапускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('degraded')">
                                        <div title="деградовано" class="bg-warning badge-dashboard"></div>
                                    </template>
                                </div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.description"></div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.fqdn"></div>
                                <template x-if="item.server_status == false">
                                    <div class="px-4 text-xs font-bold text-error">Основний сервер має проблеми
                                    </div>
                                </template>
                            </div>
                        </a>
                        <div
                            class="flex flex-wrap gap-1 pt-1 dark:group-hover:text-white group-hover:text-black group min-h-6">
                            <template x-for="tag in item.tags">
                                <a :href="`/tags/${tag.name}`" class="tag" x-text="tag.name">
                                </a>
                            </template>
                            <a :href="`${item.hrefLink}/tags`" class="add-tag">
                                Додати тег
                            </a>
                        </div>
                    </span>
                </template>
            </div>
            <template x-if="filteredDatabases.length > 0">
                <h2 class="pt-4">Бази даних</h2>
            </template>
            <div x-show="filteredDatabases.length > 0"
                class="grid grid-cols-1 gap-4 pt-4 lg:grid-cols-2 xl:grid-cols-3">
                <template x-for="item in filteredDatabases" :key="item.uuid">
                    <span>
                        <a class="h-24 box group" :href="item.hrefLink">
                            <div class="flex flex-col w-full">
                                <div class="flex gap-2 px-4">
                                    <div class="pb-2 truncate box-title" x-text="item.name"></div>
                                    <div class="flex-1"></div>
                                    <template x-if="item.status.startsWith('running')">
                                        <div title="працює" class="bg-success badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('exited')">
                                        <div title="зупинено" class="bg-error badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('starting')">
                                        <div title="запускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('restarting')">
                                        <div title="перезапускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('degraded')">
                                        <div title="деградовано" class="bg-warning badge-dashboard"></div>
                                    </template>
                                </div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.description"></div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.fqdn"></div>
                                <template x-if="item.server_status == false">
                                    <div class="px-4 text-xs font-bold text-error">Основний сервер має проблеми
                                    </div>
                                </template>
                            </div>
                        </a>
                        <div
                            class="flex flex-wrap gap-1 pt-1 dark:group-hover:text-white group-hover:text-black group min-h-6">
                            <template x-for="tag in item.tags">
                                <a :href="`/tags/${tag.name}`" class="tag" x-text="tag.name">
                                </a>
                            </template>
                            <a :href="`${item.hrefLink}/tags`" class="add-tag">
                                Додати тег
                            </a>
                        </div>
                    </span>
                </template>
            </div>
            <template x-if="filteredServices.length > 0">
                <h2 class="pt-4">Сервіси</h2>
            </template>
            <div x-show="filteredServices.length > 0"
                class="grid grid-cols-1 gap-4 pt-4 lg:grid-cols-2 xl:grid-cols-3">
                <template x-for="item in filteredServices" :key="item.uuid">
                    <span>
                        <a class="h-24 box group" :href="item.hrefLink">
                            <div class="flex flex-col w-full">
                                <div class="flex gap-2 px-4">
                                    <div class="pb-2 truncate box-title" x-text="item.name"></div>
                                    <div class="flex-1"></div>
                                    <template x-if="item.status.startsWith('running')">
                                        <div title="працює" class="bg-success badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('exited')">
                                        <div title="зупинено" class="bg-error badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('starting')">
                                        <div title="запускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('restarting')">
                                        <div title="перезапускається" class="bg-warning badge-dashboard"></div>
                                    </template>
                                    <template x-if="item.status.startsWith('degraded')">
                                        <div title="деградовано" class="bg-warning badge-dashboard"></div>
                                    </template>
                                </div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.description"></div>
                                <div class="max-w-full px-4 truncate box-description" x-text="item.fqdn"></div>
                                <template x-if="item.server_status == false">
                                    <div class="px-4 text-xs font-bold text-error">Основний сервер має проблеми
                                    </div>
                                </template>
                            </div>
                        </a>
                        <div
                            class="flex flex-wrap gap-1 pt-1 dark:group-hover:text-white group-hover:text-black group min-h-6">
                            <template x-for="tag in item.tags">
                                <a :href="`/tags/${tag.name}`" class="tag" x-text="tag.name">
                                </a>
                            </template>
                            <a :href="`${item.hrefLink}/tags`" class="add-tag">
                                Додати тег
                            </a>
                        </div>
                    </span>
                </template>
            </div>
        </div>
    @endif

</div>

<script>
    function sortFn(a, b) {
        return a.name.localeCompare(b.name)
    }

    function searchComponent() {
        return {
            search: '',
            applications: @js($applications),
            postgresqls: @js($postgresqls),
            redis: @js($redis),
            mongodbs: @js($mongodbs),
            mysqls: @js($mysqls),
            mariadbs: @js($mariadbs),
            keydbs: @js($keydbs),
            dragonflies: @js($dragonflies),
            clickhouses: @js($clickhouses),
            services: @js($services),
            filterAndSort(items) {
                if (this.search === '') {
                    return Object.values(items).sort(sortFn);
                }
                const searchLower = this.search.toLowerCase();
                return Object.values(items).filter(item => {
                    return (item.name?.toLowerCase().includes(searchLower) ||
                        item.fqdn?.toLowerCase().includes(searchLower) ||
                        item.description?.toLowerCase().includes(searchLower) ||
                        item.tags?.some(tag => tag.name.toLowerCase().includes(searchLower)));
                }).sort(sortFn);
            },
            get filteredApplications() {
                return this.filterAndSort(this.applications)
            },
            get filteredDatabases() {
                return [
                    this.postgresqls,
                    this.redis,
                    this.mongodbs,
                    this.mysqls,
                    this.mariadbs,
                    this.keydbs,
                    this.dragonflies,
                    this.clickhouses,
                ].flatMap((items) => this.filterAndSort(items))
            },
            get filteredServices() {
                return this.filterAndSort(this.services)
            }
        };
    }
</script>