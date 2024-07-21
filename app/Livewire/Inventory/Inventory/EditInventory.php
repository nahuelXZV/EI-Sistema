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
        'inventoryArray.codigo_partida' => 'required',
        'inventoryArray.codigo_catalogo' => 'required',
        'inventoryArray.nombre' => 'required',
        'inventoryArray.tipo' => 'required',
        'inventoryArray.cantidad_contenedor' => 'required',
        'inventoryArray.unidades_contenedor' => 'required',
        'inventoryArray.total_unidades' => 'required',
        'inventoryArray.estado' => 'required',
        'foto' => 'nullable|image',
    ];

    public $message = [
        'inventoryArray.codigo_partida' => 'El codigo de partida es requerido',
        'inventoryArray.codigo_catalogo' => 'El codigo de catalogo es requerido',
        'inventoryArray.nombre' => 'El nombre es requerido',
        'inventoryArray.tipo' => 'El tipo es requerido',
        'inventoryArray.estado' => 'El estado es requerido',
        'inventoryArray.cantidad_contenedor' => 'La cantidad de contenedor es requerido',
        'inventoryArray.unidades_contenedor' => 'Las unidades de contenedor es requerido',
        'inventoryArray.total_unidades' => 'El total de unidades es requerido',
        'foto' => 'La foto debe ser una imagen',
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
        $path = 'inventory/' . $this->inventoryArray['codigo_partida'];
        if ($this->foto) {
            if ($path != ImageDefault::INVENTORY)
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
        $this->inventoryArray['total_unidades'] = (int)$this->inventoryArray['cantidad_contenedor'] * (int)$this->inventoryArray['unidades_contenedor'];
        return view('livewire.inventory.inventory.edit-inventory');
    }
}
