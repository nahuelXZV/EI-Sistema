<?php

namespace App\Livewire\Accounting\DiscountType;

use App\Services\Accounting\DiscountTypeService;
use Livewire\Component;
use Livewire\WithPagination;

class ListDiscountType extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Tipos de descuento", "url" => "discount-type.list"]];
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
        if (DiscountTypeService::delete($id)) {
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
        $discount_types = DiscountTypeService::getAllPaginate($this->search, 15);
        return view('livewire..accounting.discount-type.list-discount-type', compact('discount_types'));
    }
}
