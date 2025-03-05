<?php

namespace App\Livewire;

use App\Models\ReadingGoal;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;

class CreateReadingGoal extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public $readingGoal = null;

    public function mount($readingGoal = null): void
    {
        $this->readingGoal = $readingGoal;
        $this->form->fill([
            'name' => $readingGoal?->name,
            'tags' => $readingGoal?->tags->pluck('name')->toArray(),
        ]);
    }

    public function form(Form $form)
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TagsInput::make('tags')
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        if ($this->readingGoal) {
            // Update existing reading goal
            $this->readingGoal->update($this->data);

            // Update tags
            $this->readingGoal->tags()->delete(); // Remove old tags
            foreach ($this->data['tags'] as $tag) {
                $this->readingGoal->tags()->create(['name' => $tag]);
            }

            Notification::make()
                ->title('Saved successfully')
                ->success()
                ->send();
        } else {
            // Create new reading goal (same logic as before)
            $this->data['user_id'] = auth()->id();
            $goal = ReadingGoal::create($this->data);
            foreach ($this->data['tags'] as $tag) {
                $goal->tags()->create(['name' => $tag]);
            }

            Notification::make()
                ->title('Created successfully')
                ->success()
                ->send();

            redirect()->route('reading-goals.index');
        }


    }

    public function render()
    {
        return view('livewire.create-reading-goal');
    }
}
