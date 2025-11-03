@extends('layouts.base')
<div class="flex flex-col items-center justify-center h-full">
    <div>
        <p class="font-mono font-semibold text-7xl dark:text-warning">400</p>
        <h1 class="mt-4 font-bold tracking-tight dark:text-white">Невірний Запит</h1>
        @if ($exception->getMessage())
            <p class="text-base leading-7 text-red-500">{{ $exception->getMessage() }}</p>
        @else
            <p class="text-base leading-7 dark:text-neutral-400 text-black">Сервер не зміг зрозуміти запит через
                неправильний синтаксис.
            </p>
        @endif
        <div class="flex items-center mt-10 gap-x-2">
            <a href="{{ url()->previous() }}">
                <x-forms.button>Повернутися</x-forms.button>
            </a>
            <a href="{{ route('dashboard') }}">
                <x-forms.button>Панель керування</x-forms.button>
            </a>

        </div>
    </div>
</div>
