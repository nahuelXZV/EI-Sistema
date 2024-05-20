<?php

namespace App\Livewire\Tics\SupportRequest;

use App\Services\TICs\SupportService;
use Livewire\Component;

class ShowRequest extends Component
{
    public $breadcrumbs = [['title' => "Soporte", "url" => "support.list"], ['title' => "Ver", "url" => "support.show"]];

    public $support;

    public function mount($support)
    {
        $this->support = SupportService::getOneAll($support);
    }

    public function render()
    {
        return view('livewire..tics.support-request.show-request');
    }
}
