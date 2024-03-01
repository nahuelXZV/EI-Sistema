<?php

namespace App\Livewire\System\Dashboard;

use Livewire\Component;

class Home extends Component
{
    public $breadcrumbs = [['title' => "Usuarios", "url" => "user.list"]];
    public function render()
    {
        return view('livewire.system.dashboard.home');
    }
}
