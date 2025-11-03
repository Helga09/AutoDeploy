<div>
    <form wire:submit='submit' class="flex flex-col items-center gap-4 p-4 bg-white border lg:items-start dark:bg-base dark:border-coolgray-300 border-neutral-200">
        @if ($isReadOnly)
            <div class="w-full p-2 text-sm rounded bg-warning/10 text-warning">
                Цей том змонтований як доступний лише для читання і не може бути змінений через інтерфейс користувача.
            </div>
            @if ($isFirst)
                <div class="flex gap-2 items-end w-full  md:flex-row flex-col">
                    @if (
                        $storage->resource_type === 'App\Models\ServiceApplication' ||
                            $storage->resource_type === 'App\Models\ServiceDatabase')
                        <x-forms.input id="name" label="Назва тому" required readonly
                            helper="Попередження: Зміна назви тому після початкового запуску може спричинити проблеми. Використовуйте це лише тоді, коли ви знаєте, що робите." />
                    @else
                        <x-forms.input id="name" label="Назва тому" required readonly
                            helper="Попередження: Зміна назви тому після початкового запуску може спричинити проблеми. Використовуйте це лише тоді, коли ви знаєте, що робите." />
                    @endif
                    @if ($isService || $startedAt)
                        <x-forms.input id="hostPath" readonly helper="Каталог у файловій системі хоста."
                            label="Шлях джерела"
                            helper="Попередження: Зміна шляху джерела після початкового запуску може спричинити проблеми. Використовуйте це лише тоді, коли ви знаєте, що робите." />
                        <x-forms.input id="mountPath" label="Шлях призначення"
                            helper="Каталог всередині контейнера." required readonly />
                    @else
                        <x-forms.input id="hostPath" readonly helper="Каталог у файловій системі хоста."
                            label="Шлях джерела"
                            helper="Попередження: Зміна шляху джерела після початкового запуску може спричинити проблеми. Використовуйте це лише тоді, коли ви знаєте, що робите." />
                        <x-forms.input id="mountPath" label="Шлях призначення"
                            helper="Каталог всередині контейнера." required readonly />
                    @endif
                </div>
            @else
                <div class="flex gap-2 items-end w-full">
                    <x-forms.input id="name" required readonly />
                    <x-forms.input id="hostPath" readonly />
                    <x-forms.input id="mountPath" required readonly />
                </div>
            @endif
        @else
            @can('update', $resource)
                @if ($isFirst)
                    <div class="flex gap-2 items-end w-full">
                        <x-forms.input id="name" label="Назва тому" required />
                        <x-forms.input id="hostPath" helper="Каталог у файловій системі хоста." label="Шлях джерела" />
                        <x-forms.input id="mountPath" label="Шлях призначення"
                            helper="Каталог всередині контейнера." required />
                    </div>
                @else
                    <div class="flex gap-2 items-end w-full">
                        <x-forms.input id="name" required />
                        <x-forms.input id="hostPath" />
                        <x-forms.input id="mountPath" required />
                    </div>
                @endif
                <div class="flex gap-2">
                    <x-forms.button type="submit">
                        Оновити
                    </x-forms.button>
                    <x-modal-confirmation title="Підтвердити видалення постійного сховища?" isErrorButton buttonTitle="Видалити"
                        submitAction="delete" :actions="[
                            'Вибране постійне сховище/том буде остаточно видалено.',
                            'Якщо постійне сховище/том активно використовується ресурсом, дані будуть втрачені.',
                        ]" confirmationText="{{ $storage->name }}"
                        confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши Назву сховища нижче"
                        shortConfirmationLabel="Назва сховища" />
                </div>
            @else
                @if ($isFirst)
                    <div class="flex gap-2 items-end w-full">
                        <x-forms.input id="name" label="Назва тому" required disabled />
                        <x-forms.input id="hostPath" helper="Каталог у файловій системі хоста." label="Шлях джерела"
                            disabled />
                        <x-forms.input id="mountPath" label="Шлях призначення"
                            helper="Каталог всередині контейнера." required disabled />
                    </div>
                @else
                    <div class="flex gap-2 items-end w-full">
                        <x-forms.input id="name" required disabled />
                        <x-forms.input id="hostPath" disabled />
                        <x-forms.input id="mountPath" required disabled />
                    </div>
                @endif
            @endcan
        @endif
    </form>
</div>