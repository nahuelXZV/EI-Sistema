<?php

namespace App\Livewire\Marketing\Program;

use App\Services\Academic\ProgramService;
use Livewire\Component;
use Livewire\WithPagination;

class ListProgramOffer extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Programas en oferta", "url" => "program-offer.list"]];
    public $search = '';

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function render()
    {
        $programs = ProgramService::getAllProgramOfferPaginate($this->search, 15);
        return view('livewire.marketing.program.list-program-offer', compact('programs'));
    }
}
