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

class CreateInventory extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Inventario", "url" => "inventory.list"], ['title' => "Crear", "url" => "inventory.new"]];
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


    public function mount()
    {
        $this->inventoryArray = [
            'foto' => '',
            'codigo' => '',
            'nombre' => '',
            'tipo' => '',
            'modelo' => '',
            'cantidad' => 1,
            'estado' => '',
            'descripcion' => '',
            'unidad' => '',
            'encargado_id' => null,
            'area_id' => null,
        ];
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
            $this->inventoryArray['foto'] = $this->saveFile($this->foto, $path);
        } else {
            $this->inventoryArray['foto'] = ImageDefault::INVENTORY;
        }
        InventoryService::create($this->inventoryArray);
        return redirect()->route('inventory.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire..inventory.inventory.create-inventory');
    }
}
