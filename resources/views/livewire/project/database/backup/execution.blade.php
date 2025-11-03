<div>
    <x-slot:title>
        {{ data_get_str($database, 'name')->limit(10) }} > Резервна копія | AutoDeploy
    </x-slot>
    <h1>Резервні копії</h1>
    <livewire:project.shared.configuration-checker :resource="$database" />
    <livewire:project.database.heading :database="$database" />
    <div>
        <livewire:project.database.backup-edit :backup="$backup" :s3s="$s3s" :status="data_get($database, 'status')" />
        <livewire:project.database.backup-executions :backup="$backup" />
    </div>
</div>