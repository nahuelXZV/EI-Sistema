<?php

namespace App\Livewire\Accounting\DiscountType;

use App\Services\Accounting\DiscountTypeService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class CreateDiscountType extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Tipos de descuento", "url" => "discount-type.list"], ['title' => "Crear", "url" => "discount-type.create"]];
    public $discountTypeArray = [];
    public $documento;

    public $validate = [
        'discountTypeArray.nombre' => 'required',
        'discountTypeArray.porcentaje' => 'required',
    ];

    public $message = [
        'discountTypeArray.nombre.required' => 'El nombre es requerido',
        'discountTypeArray.porcentaje.required' => 'El porcentaje es requerido',
    ];


    public function mount()
    {
        $this->discountTypeArray = [
            'nombre' => '',
            'porcentaje' => 0,
            'documento' => '',
        ];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'discountType/' . $this->discountTypeArray['nombre'];
        if ($this->documento) {
            $this->discountTypeArray['documento'] = $this->saveFile($this->documento, $path);
        }
        DiscountTypeService::create($this->discountTypeArray);
        return redirect()->route('discount-type.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire..accounting.discount-type.create-discount-type');
    }
}
