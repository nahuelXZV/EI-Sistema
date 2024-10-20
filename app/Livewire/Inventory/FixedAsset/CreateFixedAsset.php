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

class CreateFixedAsset extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Activos Fijos", "url" => "fixed_asset.list"], ['title' => "Crear", "url" => "fixed_asset.new"]];
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
            'unidad_id' => '',
            'encargado_id' => null,
            'area_id' => null,
        ];
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
            $this->inventoryArray['foto'] = $this->saveFile($this->foto, $path);
        } else {
            $this->inventoryArray['foto'] = ImageDefault::INVENTORY;
        }
        FixedAssetService::create($this->inventoryArray);
        return redirect()->route('fixed_asset.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.inventory.fixed-asset.create-fixed-asset');
    }
}
