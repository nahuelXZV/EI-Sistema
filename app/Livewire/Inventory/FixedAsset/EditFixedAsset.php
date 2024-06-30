<?php

namespace App\Livewire\Inventory\FixedAsset;

use App\Constants\ImageDefault;
use App\Constants\StateFixedAsset;
use App\Constants\TypeFixedAsset;
use App\Services\Inventory\FixedAssetService;
use App\Services\Inventory\UnitService;
use App\Services\System\AreaService;
use App\Services\System\UserService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditFixedAsset extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Activos Fijos", "url" => "fixed_asset.list"], ['title' => "Editar", "url" => "fixed_asset.edit"]];
    public $inventoryArray = [];
    public $stateFixedAsset = [];
    public $areas = [];
    public $users = [];
    public $units = [];
    public $typeFixedAsset = [];
    public $foto;

    public $validate = [
        'inventoryArray.codigo' => 'required',
        'inventoryArray.nombre' => 'required',
        'inventoryArray.tipo' => 'required',
        'inventoryArray.cantidad' => 'required',
        'inventoryArray.estado' => 'required',
        'inventoryArray.unidad_id' => 'required',
    ];

    public $message = [
        'inventoryArray.codigo' => 'El codigo es requerido',
        'inventoryArray.nombre' => 'El nombre es requerido',
        'inventoryArray.tipo' => 'El tipo es requerido',
        'inventoryArray.cantidad' => 'La cantidad es requerida',
        'inventoryArray.estado' => 'El estado es requerido',
        'inventoryArray.unidad_id' => 'La unidad es requerida',
    ];


    public function mount($fixed_asset)
    {
        $this->inventoryArray = FixedAssetService::getOne($fixed_asset)->toArray();
        $this->stateFixedAsset = StateFixedAsset::all();
        $this->typeFixedAsset = TypeFixedAsset::all();
        $this->users = UserService::getAll();
        $this->areas = AreaService::getAll();
        $this->units = UnitService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'inventory/' . $this->inventoryArray['codigo'];
        if ($this->foto) {
            if ($path != ImageDefault::INVENTORY)
                $this->deleteFile($this->inventoryArray['foto']);
            $this->inventoryArray['foto'] = $this->saveFile($this->foto, $path);
        }
        FixedAssetService::update($this->inventoryArray);
        return redirect()->route('fixed_asset.show', $this->inventoryArray['id']);
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    private function deleteFile($path)
    {
        $pathFileOld = str_replace('storage/', '', $path);
        if (Storage::exists($pathFileOld)) Storage::disk('public')->delete($pathFileOld);
    }

    public function render()
    {
        return view('livewire.inventory.fixed-asset.edit-fixed-asset');
    }
}
