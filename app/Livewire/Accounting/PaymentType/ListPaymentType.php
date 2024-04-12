<?php

namespace App\Livewire\Accounting\PaymentType;

use App\Services\Accounting\PaymentTypeService;
use Livewire\Component;
use Livewire\WithPagination;

class ListPaymentType extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Tipos de Pago", "url" => "payment-type.list"]];
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
        if (PaymentTypeService::delete($id)) {
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
        $payment_types = PaymentTypeService::getAllPaginate($this->search, 15);
        return view('livewire..accounting.payment-type.list-payment-type',compact('payment_types'));
    }
}
