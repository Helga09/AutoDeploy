<form class="flex flex-col w-full gap-2 rounded-sm" wire:submit='submit'>
    <x-forms.input placeholder="0 0 * * * or daily" id="frequency"
        helper="Ви можете використовувати every_minute, hourly, daily, weekly, monthly, yearly або cron вираз." label="Частота"
        required />
    <h2>S3</h2>
    @if ($definedS3s->count() === 0)
        <div class="text-red-500">Не знайдено перевірених сховищ S3.</div>
    @else
        <x-forms.checkbox wire:model.live="saveToS3" label="Зберегти в S3" />
        @if ($saveToS3)
            <x-forms.select id="s3StorageId" label="Виберіть сховище S3">
                @foreach ($definedS3s as $s3)
                    <option value="{{ $s3->id }}">{{ $s3->name }}</option>
                @endforeach
            </x-forms.select>
        @endif
    @endif
    <x-forms.button type="submit" @click="modalOpen=false">
        Зберегти
    </x-forms.button>
</form>