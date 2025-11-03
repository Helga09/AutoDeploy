<div class="flex flex-col items-center justify-center h-32">
    <span class="text-xl font-bold dark:text-white">Ви досягли ліміту {{ $name }}, які можете створити.</span>
    <span>Будь ласка, <a class="dark:text-white underline "href="{{ route('subscription.show') }}">оновіть вашу
            підписку</a>, щоб створити більше
        {{ $name }}.</span>
</div>