<div>
    <x-slot:title>
        Спільні змінні | AutoDeploy
    </x-slot>
    <div class="flex items-start gap-2">
        <h1>Спільні змінні</h1>
    </div>
    <div class="subtitle">Встановіть змінні на рівні команди / проєкту / середовища.</div>

    <div class="flex flex-col gap-2 -mt-1">
        <a class="box group" href="{{ route('shared-variables.team.index') }}">
            <div class="flex flex-col justify-center mx-6">
                <div class="box-title">На рівні команди</div>
                <div class="box-description">Використовується для всіх ресурсів у команді.</div>
            </div>
        </a>
        <a class="box group" href="{{ route('shared-variables.project.index') }}">
            <div class="flex flex-col justify-center mx-6">
                <div class="box-title">На рівні проєкту</div>
                <div class="box-description">Використовується для всіх ресурсів у проєкті.</div>
            </div>
        </a>
        <a class="box group" href="{{ route('shared-variables.environment.index') }}">
            <div class="flex flex-col justify-center mx-6">
                <div class="box-title">На рівні середовища</div>
                <div class="box-description">Використовується для всіх ресурсів у середовищі.</div>
            </div>
        </a>

    </div>
</div>