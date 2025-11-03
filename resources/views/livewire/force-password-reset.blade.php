<section class="bg-gray-50 dark:bg-base">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <a class="flex items-center mb-6 text-5xl font-extrabold tracking-tight text-gray-900 dark:text-white">
            AutoDeploy
        </a>
        <div class="w-full bg-white shadow-sm md:mt-0 sm:max-w-md xl:p-0 dark:bg-base ">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                <form class="flex flex-col gap-2" wire:submit='submit'>
                    <x-forms.input id="email" type="email" placeholder="Електронна пошта" readonly label="Електронна пошта" />
                    <x-forms.input id="password" type="password" placeholder="Новий пароль" label="Новий пароль"
                        required />
                    <x-forms.input id="password_confirmation" type="password" placeholder="Підтвердіть новий пароль"
                        label="Підтвердіть новий пароль" required />
                    <x-forms.button type="submit">Скинути пароль</x-forms.button>
                </form>
            </div>
        </div>
    </div>
</section>