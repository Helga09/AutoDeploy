<div>
    <form wire:submit='submit' class="flex flex-col">
        <div class="flex items-center gap-2 ">
            <h2>Обмеження ресурсів</h2>
            <x-forms.button canGate="update" :canResource="$resource" type='submit'>Зберегти</x-forms.button>
        </div>
        <div class="">Обмежте ресурси свого контейнера за допомогою ЦП та пам'яті.</div>
        <h3 class="pt-4">Обмеження ЦП</h3>
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$resource" placeholder="1.5"
                helper="0 означає використання всіх ЦП. Число з плаваючою комою, наприклад, 0.002 або 1.5. Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/engine/reference/run/#cpu-share-constraint'>тут</a>."
                label="Кількість ЦП" id="limitsCpus" />
            <x-forms.input canGate="update" :canResource="$resource" placeholder="0-2"
                helper="Порожнє значення означає використання всіх наборів ЦП. 0-2 використовуватиме ЦП 0, ЦП 1 та ЦП 2. Додаткова інформація <a class='underline dark:text-white'  target='_blank' href='https://docs.docker.com/engine/reference/run/#cpu-share-constraint'>тут</a>."
                label="Набори ЦП для використання" id="limitsCpuset" />
            <x-forms.input canGate="update" :canResource="$resource" placeholder="1024"
                helper="Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/engine/reference/run/#cpu-share-constraint'>тут</a>."
                label="Вага ЦП" id="limitsCpuShares" />
        </div>
        <h3 class="pt-4">Обмеження пам'яті</h3>
        <div class="flex flex-col gap-2">
            <div class="flex gap-2">
                <x-forms.input canGate="update" :canResource="$resource"
                    helper="Приклади: 69b (байт) або 420k (кілобайт) або 1337m (мегабайт) або 1g (гігабайт).<br>Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/compose/compose-file/05-services/#mem_reservation'>тут</a>."
                    label="М'яке обмеження пам'яті" id="limitsMemoryReservation" />
                <x-forms.input canGate="update" :canResource="$resource"
                    helper="0-100.<br>Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/compose/compose-file/05-services/#mem_swappiness'>тут</a>."
                    type="number" min="0" max="100" label="Використання swap"
                    id="limitsMemorySwappiness" />
            </div>
            <div class="flex gap-2">
                <x-forms.input canGate="update" :canResource="$resource"
                    helper="Приклади: 69b (байт) або 420k (кілобайт) або 1337m (мегабайт) або 1g (гігабайт).<br>Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/compose/compose-file/05-services/#mem_limit'>тут</a>."
                    label="Максимальне обмеження пам'яті" id="limitsMemory" />
                <x-forms.input canGate="update" :canResource="$resource"
                    helper="Приклади: 69b (байт) або 420k (кілобайт) або 1337m (мегабайт) або 1g (гігабайт).<br>Додаткова інформація <a class='underline dark:text-white' target='_blank' href='https://docs.docker.com/compose/compose-file/05-services/#memswap_limit'>тут</a>."
                    label="Максимальне обмеження Swap" id="limitsMemorySwap" />
            </div>
        </div>
    </form>
</div>