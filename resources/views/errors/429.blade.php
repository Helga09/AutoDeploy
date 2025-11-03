@extends('layouts.base')
<div class="flex flex-col items-center justify-center h-full">
    <div>
        <p class="font-mono font-semibold text-7xl dark:text-warning">429</p>
        <h1 class="mt-4 font-bold tracking-tight dark:text-white">Ого, пригальмуйте!</h1>
        <p class="text-base leading-7 dark:text-neutral-400 text-black">Ви робите забагато запитів. Будь ласка, зачекайте кілька
            секунд, перш ніж спробувати знову.
        </p>
        <div class="flex items-center mt-10 gap-x-2">
            <a href="{{ url()->previous() }}">
                <x-forms.button>Повернутися</x-forms.button>
            </a>
            <a href="{{ route('dashboard') }}">
                <x-forms.button>Панель керування</x-forms.button>
            </a>
            <a target="_blank" class="text-xs" href="{{ config('constants.urls.contact') }}">Зв'язатися з
                підтримкою
                <x-external-link />
            </a>
        </div>
    </div>
</div>
