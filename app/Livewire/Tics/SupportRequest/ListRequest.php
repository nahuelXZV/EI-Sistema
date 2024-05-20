<?php

namespace App\Livewire\Tics\SupportRequest;

use App\Services\TICs\SupportService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ListRequest extends Component
{
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Soporte", "url" => "support.list"]];
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
        if (SupportService::delete($id)) {
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
        $requests = SupportService::getAllPaginate($this->search, 15);
        $requestsUser = SupportService::getAllPaginateForUser(Auth::id(), $this->search, 15);
        return view('livewire..tics.support-request.list-request', compact('requests', 'requestsUser'));
    }
}
