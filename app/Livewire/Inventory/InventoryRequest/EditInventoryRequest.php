<?php

namespace App\Livewire\Inventory\InventoryRequest;

use App\Constants\StateInventoryRequest;
use App\Services\Inventory\InventoryRequestService;
use Livewire\Component;

class EditInventoryRequest extends Component
{
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs;
    public $motivo = '';

    public $request;

    public function mount($request)
    {
        $this->request = InventoryRequestService::getOne($request);
        $this->breadcrumbs = [
            ['title' => "Solicitudes", "url" => "inventory-request.list"],
            ['title' => "Ver", "url" => "inventory-request.show", "id" => $this->request->id],
            ['title' => "Rechazar", "url" => "inventory-request.new"]
        ];
    }

    public function save()
    {
        $note = [
            'id' => $this->request->id,
            'estado' => StateInventoryRequest::RECHAZADO,
            'motivo_rechazo' => $this->motivo
        ];
        InventoryRequestService::update($note);
        return redirect()->route('inventory-request.show', $this->request->id);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-request.edit-inventory-request');
    }
}
