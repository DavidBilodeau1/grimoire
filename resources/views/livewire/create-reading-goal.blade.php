<div>
    <form wire:submit="save">
        {{ $this->form }}
        <div class="pt-6 justify-self-end">
            <x-primary-button type="submit">Submit</x-primary-button>
        </div>
    </form>
</div>
