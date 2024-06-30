<?php

namespace App\Livewire\Inventory\Unit;

use App\Services\Inventory\UnitService;
use Livewire\Component;
use Livewire\WithPagination;

class ListUnit extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Unidades", "url" => "unit.list"]];
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
        if (UnitService::delete($id)) {
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
        $units = UnitService::getAllPaginate($this->search, 15);
        return view('livewire.inventory.unit.list-unit', compact('units'));
    }
}
