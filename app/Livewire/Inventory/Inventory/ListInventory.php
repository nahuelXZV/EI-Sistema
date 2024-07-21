<?php

namespace App\Livewire\Inventory\Inventory;

use App\Constants\InventoryFilter;
use App\Exports\InventoryExport;
use App\Services\Inventory\InventoryService;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ListInventory extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Inventario", "url" => "inventory.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';
    public $filters = [];
    public $filter;

    public function mount()
    {
        $this->filters = InventoryFilter::all();
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
        if (InventoryService::delete($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
    }

    public function downloadExcel()
    {
        return Excel::download(new InventoryExport($this->filter), 'inventario.xlsx');
    }

    public function render()
    {
        $inventories = InventoryService::getAllPaginate($this->search, 15, $this->filter);
        return view('livewire.inventory.inventory.list-inventory', compact('inventories'));
    }
}
