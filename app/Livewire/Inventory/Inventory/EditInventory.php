<?php

namespace App\Livewire\Inventory\Inventory;

use App\Constants\ImageDefault;
use App\Constants\StateFixedAsset;
use App\Constants\TypeFixedAsset;
use App\Services\Inventory\InventoryService;
use App\Services\System\AreaService;
use App\Services\System\UserService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditInventory extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Inventario", "url" => "inventory.list"], ['title' => "Editar", "url" => "inventory.edit"]];
    public $inventoryArray = [];
    public $stateFixedAsset = [];
    public $areas = [];
    public $users = [];
    public $typeFixedAsset = [];
    public $foto;

    public $validate = [
        'inventoryArray.codigo' => 'required',
        'inventoryArray.nombre' => 'required',
        'inventoryArray.tipo' => 'required',
        'inventoryArray.cantidad' => 'required',
        'inventoryArray.estado' => 'required',
    ];

    public $message = [
        'inventoryArray.codigo' => 'El codigo es requerido',
        'inventoryArray.nombre' => 'El nombre es requerido',
        'inventoryArray.tipo' => 'El tipo es requerido',
        'inventoryArray.cantidad' => 'La cantidad es requerida',
        'inventoryArray.estado' => 'El estado es requerido',
    ];


    public function mount($inventory)
    {
        $this->inventoryArray = InventoryService::getOne($inventory)->toArray();
        $this->stateFixedAsset = StateFixedAsset::all();
        $this->typeFixedAsset = TypeFixedAsset::all();
        $this->users = UserService::getAll();
        $this->areas = AreaService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'inventory/' . $this->inventoryArray['codigo'];
        if ($this->foto) {
            $this->deleteFile($this->inventoryArray['foto']);
            $this->inventoryArray['foto'] = $this->saveFile($this->foto, $path);
        }
        InventoryService::update($this->inventoryArray);
        return redirect()->route('inventory.show', $this->inventoryArray['id']);
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
        return view('livewire.inventory.inventory.edit-inventory');
    }
}
