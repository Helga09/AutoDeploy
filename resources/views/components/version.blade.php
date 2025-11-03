<a {{ $attributes->merge(['class' => 'text-xs cursor-pointer opacity-90 hover:opacity-100 dark:hover:text-white hover:text-black']) }}
    href="https://github.com/coollabsio/AutoDeploy/releases/tag/v{{ config('constants.AutoDeploy.version') }}" target="_blank">
    v{{ config('constants.AutoDeploy.version') }}
</a>