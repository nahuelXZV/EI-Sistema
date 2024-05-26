<?php

namespace App\Livewire\Tics\SupportRequest;

use App\Constants\StateSupportRequest;
use App\Services\TICs\SupportService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditRequest extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Soporte", "url" => "support.list"], ['title' => "Editar", "url" => "support.edit"]];
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


    public function mount($support)
    {
        $this->requestArray = SupportService::getOne($support)->toArray();
        $this->stateSupportRequest = StateSupportRequest::all();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'support/' . $this->requestArray['user_id'];
        if ($this->recurso) {
            $this->deleteFile($this->requestArray['recurso']);
            $this->requestArray['recurso'] = $this->saveFile($this->recurso, $path);
        }
        SupportService::update($this->requestArray);
        return redirect()->route('support.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    private function deleteFile($path)
    {
        $pathFileOld = str_replace('storage/', '', $path);
        if (Storage::exists($pathFileOld)) Storage::disk('public')->delete($pathFileOld);
    }

    public function render()
    {
        return view('livewire.tics.support-request.edit-request');
    }
}
