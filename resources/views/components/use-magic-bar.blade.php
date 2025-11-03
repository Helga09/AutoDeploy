<div class="pt-4">
    @if (isset($link))
        Створити новий
        <a href="{{ $link }}" class="underline dark:text-warning">
            тут.
        </a>
    {{-- @else
        Use the magic
        bar (press <span class="kbd-custom">/</span>) to create a new one. --}}
    @endif
</div>