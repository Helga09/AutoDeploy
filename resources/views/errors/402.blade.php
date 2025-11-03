@extends('layouts.base')

<div class="flex flex-col items-center justify-center h-full">
    <div>
        <p class="font-mono font-semibold text-7xl dark:text-warning">402</p>
        <h1 class="mt-4 font-bold tracking-tight dark:text-white">Потрібна оплата.</h1>
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
