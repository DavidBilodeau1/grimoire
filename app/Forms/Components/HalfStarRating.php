<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Field;

class HalfStarRating extends Field
{
    use HasExtraInputAttributes;

    protected string $view = 'forms.components.half-star-rating';

    protected int | Closure $maxRating = 5;

    public function maxRating(int | Closure $maxRating): static
    {
        $this->maxRating = $maxRating;

        return $this;
    }

    public function getMaxRating(): int
    {
        return $this->evaluate($this->maxRating);
    }
}
