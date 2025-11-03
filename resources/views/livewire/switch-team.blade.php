<x-forms.select wire:model.live="selectedTeamId">
    <option value="default" disabled selected>Переключити команду</option>
    @foreach (auth()->user()->teams as $team)
        <option value="{{ $team->id }}">{{ $team->name }}</option>
    @endforeach
</x-forms.select>