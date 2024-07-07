<?php

namespace App\Livewire\Inventory\FixedAsset;

use App\Constants\StateFixedAsset;
use App\Exports\FixedAssetExport;
use App\Services\Inventory\FixedAssetService;
use App\Services\Inventory\UnitService;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class ListFixedAsset extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Activos Fijos", "url" => "fixed_asset.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public $state = "";
    public $unit = 0;

    public $states = [];
    public $units = [];

    public function mount()
    {
        $this->states = StateFixedAsset::all();
        $this->units = UnitService::getAll();
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

    public function downloadExcel()
    {
        return Excel::download(new FixedAssetExport($this->state, $this->unit), 'activos-fijos.xlsx');
    }

    public function render()
    {
        $inventories = FixedAssetService::getAllPaginate($this->search, 15, $this->state, $this->unit);
        return view('livewire.inventory.fixed-asset.list-fixed-asset', compact('inventories'));
    }
}
