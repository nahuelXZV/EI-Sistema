<?php

namespace App\Livewire\Tics\SupportRequest;

use App\Constants\StateSupportRequest;
use App\Services\TICs\SupportService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateRequest extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Soporte", "url" => "support.list"], ['title' => "Crear", "url" => "support.new"]];
    public $requestArray = [];
    public $stateSupportRequest = [];
    public $recurso;

    public $validate = [
        'requestArray.motivo' => 'required',
        'requestArray.fecha' => 'required',
        'requestArray.hora' => 'required',
        'requestArray.descripcion' => 'required',
    ];

    public $message = [
        'requestArray.motivo' => 'El motivo es requerido',
        'requestArray.fecha' => 'La fecha es requerida',
        'requestArray.hora' => 'La hora es requerida',
        'requestArray.descripcion' => 'La descripción es requerida',
    ];

    public function mount()
    {
        $this->requestArray = [
            'motivo' => '',
            'fecha' => now()->format('Y-m-d'),
            'hora' => now()->format('H:i'),
            'estado' => StateSupportRequest::PENDIENTE,
            'descripcion' => '',
            'recurso' => null,
            'fecha_visita' => null,
            'user_id' => Auth::id(),
        ];
        $this->stateSupportRequest = stateSupportRequest::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'support/' . $this->requestArray['user_id'];
        if ($this->recurso) {
            $this->requestArray['recurso'] = $this->saveFile($this->recurso, $path);
        }
        SupportService::create($this->requestArray);
        return redirect()->route('support.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.tics.support-request.create-request');
    }
}
