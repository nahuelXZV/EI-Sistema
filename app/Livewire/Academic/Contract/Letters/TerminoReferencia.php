<?php

namespace App\Livewire\Academic\Contract\Letters;

use App\Services\Academic\LetterService;
use Livewire\Component;

class TerminoReferencia extends Component
{
    public $letter;

    public function mount($letter)
    {
        $this->letter = LetterService::getOne($letter);
    }

    public function render()
    {
        return view('livewire.academic.contract.letters.termino-referencia');
    }
}
