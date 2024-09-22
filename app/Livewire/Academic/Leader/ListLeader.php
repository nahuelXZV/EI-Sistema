<?php

namespace App\Livewire\Academic\Leader;

use App\Services\Academic\LeaderService;
use Livewire\Component;
use Livewire\WithPagination;

class ListLeader extends Component
{
    use WithPagination;
    protected $listeners = ['cleanerNotificacion'];

    public $breadcrumbs = [['title' => "Directivos", "url" => "leader.list"]];
    public $search = '';
    public $notificacion = false;
    public $type = '';
    public $message = '';

    public function mount() {}

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
        if (LeaderService::delete($id)) {
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
        $leaders = LeaderService::getAllPaginate($this->search, 15);
        return view('livewire.academic.leader.list-leader', compact('leaders'));
    }
}
