<?php

namespace App\Livewire\Inventory\FixedAsset;

use App\Services\Inventory\FixedAssetService;
use App\Services\Inventory\InventoryService;
use Livewire\Component;
use Livewire\WithPagination;

class ListFixedAsset extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Activos Fijos", "url" => "fixed_asset.list"]];
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
        if (FixedAssetService::delete($id)) {
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
        $inventories = FixedAssetService::getAllPaginate($this->search, 15);
        return view('livewire.inventory.fixed-asset.list-fixed-asset', compact('inventories'));
    }
}
