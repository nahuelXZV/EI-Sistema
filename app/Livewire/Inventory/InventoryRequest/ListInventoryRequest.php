<?php

namespace App\Livewire\Inventory\InventoryRequest;

use App\Services\Inventory\InventoryRequestService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListInventoryRequest extends Component
{
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Solicitudes", "url" => "inventory-request.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount()
    {
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->search = '';
        $this->type = '';
    }

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        if (InventoryRequestService::delete($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }

    public function render()
    {
        if (Auth::user()->can('solicitudes.index'))
            $requests = InventoryRequestService::getAllPaginate($this->search, 15);
        else
            $requests = InventoryRequestService::getAllPaginateForUser(Auth::id(), $this->search, 15);
        return view('livewire.inventory.inventory-request.list-inventory-request', compact('requests'));
    }
}
