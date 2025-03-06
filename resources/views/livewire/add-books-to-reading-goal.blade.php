<div>
    <form wire:submit="submit">
        {{ $this->form }}
        <div class="pt-6 justify-self-end">
            <x-primary-button type="submit">Submit</x-primary-button>
        </div>
    </form>
</div>
