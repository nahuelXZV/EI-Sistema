<?php

namespace App\Livewire\Inventory\InventoryRequest;

use App\Constants\StateInventoryRequest;
use App\Services\Inventory\InventoryRequestService;
use App\Services\Inventory\InventoryService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateInventoryRequest extends Component
{
    public $breadcrumbs = [['title' => "Solicitudes", "url" => "inventory-request.list"], ['title' => "Crear", "url" => "inventory-request.new"]];
    public $requestArray = [];
    public $requestDetailArray = [];

    public $detailTemp = [];
    public $statesInventoryRequest = [];
    public $search = '';
    public $arrayIdInventoriesExcept = [];

    public $messageError = "";
    public $showMessage = false;

    public $validate = [
        'requestArray.fecha' => 'required',
        'requestArray.hora' => 'required',
        'requestDetailArray' => 'array|min:1',
    ];

    public $message = [
        'requestArray.fecha' => 'La fecha es requerida',
        'requestArray.hora' => 'La hora es requerida',
        'requestDetailArray' => 'Debe agregar al menos un producto',
    ];

    public function mount()
    {
        $this->requestArray = [
            'fecha' => now()->format('Y-m-d'),
            'hora' => now()->format('H:i'),
            'estado' => StateInventoryRequest::PENDIENTE,
            'user_id' => Auth::id(),
        ];
        $this->detailTemp = [
            'inventario_id' => '',
            'cantidad' => '',
            'nombre' => '',
            'codigo_partida' => '',
        ];
        $this->statesInventoryRequest = StateInventoryRequest::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        InventoryRequestService::create($this->requestArray, $this->requestDetailArray);
        return redirect()->route('inventory-request.list');
    }

    public function addInventory()
    {
        if (empty($this->detailTemp['inventario_id']) || empty($this->detailTemp['cantidad'])) {
            $this->showMessage = true;
            $this->messageError = "Debe seleccionar un producto y agregar una cantidad";
            return;
        }
        $producto = InventoryService::getOne($this->detailTemp['inventario_id']);
        if ($producto->total_unidades < $this->detailTemp['cantidad']) {
            $this->showMessage = true;
            $this->messageError = "La cantidad solicitada es mayor a la cantidad en inventario";
            return;
        }
        $this->detailTemp['nombre'] = $producto->nombre;
        $this->detailTemp['codigo_partida'] = $producto->codigo_partida;
        $this->requestDetailArray[] = $this->detailTemp;
        $this->arrayIdInventoriesExcept[] = $this->detailTemp['inventario_id'];
        $this->clean();
    }

    private function clean()
    {
        $this->detailTemp = [
            'inventario_id' => '',
            'cantidad' => '',
            'nombre' => '',
            'codigo_partida' => '',
        ];
        $this->showMessage = false;
        $this->messageError = "";
    }

    public function removeInventory($id)
    {
        $this->requestDetailArray = array_filter($this->requestDetailArray, function ($item) use ($id) {
            return $item['inventario_id'] != $id;
        });
        $this->arrayIdInventoriesExcept = array_filter($this->arrayIdInventoriesExcept, function ($item) use ($id) {
            return $item != $id;
        });
    }

    public function render()
    {
        $inventories = InventoryService::geAllQuantitiesGreaterZero($this->search, $this->arrayIdInventoriesExcept);
        return view('livewire.inventory.inventory-request.create-inventory-request', compact('inventories'));
    }
}
