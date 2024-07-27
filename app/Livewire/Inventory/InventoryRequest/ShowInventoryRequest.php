<?php

namespace App\Livewire\Inventory\InventoryRequest;

use App\Constants\StateInventoryRequest;
use App\Services\Inventory\InventoryRequestService;
use Livewire\Component;

class ShowInventoryRequest extends Component
{
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs;
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public $request;
    public $details;

    public function mount($request)
    {
        $this->request = InventoryRequestService::getOne($request);
        $this->details = InventoryRequestService::getDetail($this->request->id);
        $this->breadcrumbs = [['title' => "Solicitudes", "url" => "inventory-request.list"], ['title' => "Ver", "url" => "inventory-request.new"]];
    }

    public function cleanerNotificacion()
    {
        $this->notificacion = null;
        $this->type = '';
        $this->message = '';
        $this->refresh();
    }

    public function delete($id)
    {
        if (InventoryRequestService::deleteDetail($id)) {
            $this->message = 'Eliminado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al eliminar';
            $this->type = 'error';
        }
        $this->notificacion = true;
        $this->refresh();
    }

    public function updateState()
    {
        $note = [
            'id' => $this->request->id,
            'estado' => StateInventoryRequest::APROBADO,
            'motivo_rechazo' => ""
        ];
        if (InventoryRequestService::update($note)) {
            $this->message = 'Actualizado correctamente';
            $this->type = 'success';
        } else {
            $this->message = 'Error al actualizar, Verifique que la cantidad solicitada no sea mayor al stock';
            $this->type = 'error';
        }
        $this->notificacion = true;
        $this->refresh();
    }

    public function refresh()
    {
        $this->request = InventoryRequestService::getOne($this->request->id);
        $this->details = InventoryRequestService::getDetail($this->request->id);
    }

    public function render()
    {
        return view('livewire.inventory.inventory-request.show-inventory-request');
    }
}
