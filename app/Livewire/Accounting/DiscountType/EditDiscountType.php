<?php

namespace App\Livewire\Accounting\DiscountType;

use App\Services\Accounting\DiscountTypeService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class EditDiscountType extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Tipos de descuento", "url" => "discount-type.list"], ['title' => "Editar", "url" => "discount-type.edit"]];
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


    public function mount($discount_type)
    {
        $this->discountTypeArray = DiscountTypeService::getOne($discount_type)->toArray();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'discountType/' . $this->discountTypeArray['nombre'];
        if ($this->documento) {
            $this->deleteFile($this->discountTypeArray['nombre']);
            $this->discountTypeArray['documento'] = $this->saveFile($this->documento, $path);
        }
        DiscountTypeService::update($this->discountTypeArray);
        return redirect()->route('discount-type.list');
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
        return view('livewire..accounting.discount-type.edit-discount-type');
    }
}
