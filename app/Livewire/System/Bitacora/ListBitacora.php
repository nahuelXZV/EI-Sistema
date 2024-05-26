<?php

namespace App\Livewire\System\Bitacora;

use App\Services\System\BitacoraService;
use Livewire\Component;
use Livewire\WithPagination;

class ListBitacora extends Component
{
    use WithPagination;
    public $breadcrumbs = [['title' => "Bitacora", "url" => "bitacora.list"]];
    public $search = '';
    public $type = '';
    public $message = '';

    public function render()
    {
        $activityLogs = BitacoraService::getAllPaginate($this->search, 15);
        return view('livewire..system.bitacora.list-bitacora',compact('activityLogs'));
    }
}
