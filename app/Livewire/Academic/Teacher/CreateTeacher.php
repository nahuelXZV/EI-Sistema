<?php

namespace App\Livewire\Academic\Teacher;

use App\Constants\Expedition;
use App\Constants\Honorifics;
use App\Constants\ImageDefault;
use App\Services\Academic\CareerService;
use App\Services\Academic\TeacherService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateTeacher extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Docentes", "url" => "teacher.list"], ['title' => "Crear", "url" => "teacher.create"]];
    public $teacherArray = [];
    public $honorifics = [];
    public $expeditions = [];
    public $carreers = [];
    public $foto;
    public $cv;

    public $validate = [
        'teacherArray.honorifico' => 'required|string|max:50',
        'teacherArray.nombre' => 'required|string|max:50',
        'teacherArray.apellido' => 'required|string|max:50',
        'foto' => 'nullable|image',
        'cv' => 'nullable|file',
        'teacherArray.cedula' => 'required|string|max:20',
        'teacherArray.expedicion' => 'required|string|max:3',
        'teacherArray.telefono' => 'string|max:20',
        'teacherArray.correo' => 'email',
        'teacherArray.factura' => 'boolean',
        'teacherArray.carrera_id' => 'nullable|integer',
    ];

    public $message = [
        'teacherArray.honorifico.required' => 'El honorifico es requerido',
        'teacherArray.honorifico.string' => 'El honorifico debe ser un texto',
        'teacherArray.honorifico.max' => 'El honorifico debe tener máximo 50 caracteres',
        'teacherArray.nombre.required' => 'El nombre es requerido',
        'teacherArray.nombre.string' => 'El nombre debe ser un texto',
        'teacherArray.nombre.max' => 'El nombre debe tener máximo 50 caracteres',
        'teacherArray.apellido.required' => 'El apellido es requerido',
        'teacherArray.apellido.string' => 'El apellido debe ser un texto',
        'teacherArray.apellido.max' => 'El apellido debe tener máximo 50 caracteres',
        'teacherArray.cedula.required' => 'La cédula es requerida',
        'teacherArray.cedula.string' => 'La cédula debe ser un texto',
        'teacherArray.cedula.max' => 'La cédula debe tener máximo 20 caracteres',
        'teacherArray.expedicion.required' => 'La expedición es requerida',
        'teacherArray.expedicion.string' => 'La expedición debe ser un texto',
        'teacherArray.expedicion.max' => 'La expedición debe tener máximo 3 caracteres',
        'teacherArray.telefono.string' => 'El teléfono debe ser un texto',
        'teacherArray.telefono.max' => 'El teléfono debe tener máximo 20 caracteres',
        'teacherArray.correo.email' => 'El correo debe ser un email',
        'teacherArray.factura.boolean' => 'La factura debe ser un booleano',
        'teacherArray.carrera_id.integer' => 'La carrera debe ser un número entero',
        'foto.image' => 'La foto debe ser una imagen',
        'foto.max' => 'La foto debe tener máximo 1024 kilobytes',
        'cv.file' => 'El cv debe ser un archivo',
        'cv.max' => 'El cv debe tener máximo 1024 kilobytes',
    ];

    public function mount()
    {
        $this->teacherArray = [
            'honorifico' => '',
            'nombre' => '',
            'apellido' => '',
            'foto' => '',
            'cv' => '',
            'cedula' => '',
            'expedicion' => '',
            'telefono' => '',
            'correo' => '',
            'factura' => false,
            'carrera_id' => null,
        ];
        $this->honorifics = Honorifics::all();
        $this->expeditions = Expedition::all();
        $this->carreers = CareerService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'teachers/' . $this->teacherArray['cedula'];
        if ($this->foto) $this->teacherArray['foto'] = $this->saveFile($this->foto, $path);
        else $this->teacherArray['foto'] = ImageDefault::USER;
        if ($this->cv) $this->teacherArray['cv'] = $this->saveFile($this->cv, $path);;
        TeacherService::create($this->teacherArray);
        return redirect()->route('teacher.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.academic.teacher.create-teacher');
    }
}
