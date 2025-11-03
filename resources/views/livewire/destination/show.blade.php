<div>
    <form class="flex flex-col">
        <div class="flex items-center gap-2">
            <h1>Призначення</h1>
            <x-forms.button canGate="update" :canResource="$destination" wire:click.prevent='submit'
                type="submit">Зберегти</x-forms.button>
            @if ($network !== 'AutoDeploy')
                <x-modal-confirmation title="Підтвердити видалення призначення?" buttonTitle="Видалити призначення" isErrorButton
                    submitAction="delete" :actions="['Це видалить вибране призначення/мережу.']" confirmationText="{{ $destination->name }}"
                    confirmationLabel="Будь ласка, підтвердьте виконання дій, ввівши назву призначення нижче"
                    shortConfirmationLabel="Назва призначення" :confirmWithPassword="false" step2ButtonText="Видалити назавжди" 
                    canGate="delete" :canResource="$destination" />
            @endif
        </div>

        @if ($destination->getMorphClass() === 'App\Models\StandaloneDocker')
            <div class="subtitle ">Проста мережа Docker.</div>
        @else
            <div class="subtitle ">Мережа Docker Swarm. У розробці</div>
        @endif
        <div class="flex gap-2">
            <x-forms.input canGate="update" :canResource="$destination" id="name" label="Назва" />
            <x-forms.input id="serverIp" label="IP-адреса сервера" readonly />
            @if ($destination->getMorphClass() === 'App\Models\StandaloneDocker')
                <x-forms.input id="network" label="Мережа Docker" readonly />
            @endif
        </div>
    </form>
</div>