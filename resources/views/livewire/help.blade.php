<div class="flex flex-col w-full gap-2">
    <div>Ваш відгук допомагає нам покращити Coolify. Дякуємо! 💜</div>
    <form wire:submit="submit" class="flex flex-col gap-4 pt-4">
        <x-forms.input minlength="3" required id="subject" label="Тема" placeholder="Допомога з..."></x-forms.input>
        <x-forms.textarea minlength="10" maxlength="1000" required rows="10" id="description" label="Опис"
            class="font-sans" spellcheck
            placeholder="Маєте проблеми з... Будь ласка, надайте якомога більше інформації."></x-forms.textarea>
        <div></div>
        <x-forms.button class="w-full mt-4" type="submit">Надіслати</x-forms.button>
    </form>
</div>