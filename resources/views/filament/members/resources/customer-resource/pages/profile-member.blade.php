<x-filament-panels::page>
    <form wire:submit='save' method="post">
        {{ $this->form }}
        <button type="submit" class="btn btn-primary"></button>
    </form>
</x-filament-panels::page>
