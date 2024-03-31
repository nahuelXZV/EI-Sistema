<?php

namespace App\Livewire\Academic\Teacher;

use App\Constants\Expedition;
use App\Constants\Honorifics;
use App\Services\Academic\CareerService;
use App\Services\Academic\TeacherService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditTeacher extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Docentes", "url" => "teacher.list"], ['title' => "Editar", "url" => "teacher.edit"]];
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

    public function mount($teacher)
    {
        $teacher = TeacherService::getOne($teacher);
        $this->teacherArray = [
            'id' => $teacher->id,
            'honorifico' => $teacher->honorifico,
            'nombre' => $teacher->nombre,
            'apellido' => $teacher->apellido,
            'foto' => '',
            'cv' => '',
            'cedula' => $teacher->cedula,
            'expedicion' => $teacher->expedicion,
            'telefono' =>  $teacher->telefono,
            'correo' => $teacher->correo,
            'factura' => $teacher->factura,
            'carrera_id' => $teacher->carrera_id,
        ];
        $this->honorifics = Honorifics::all();
        $this->expeditions = Expedition::all();
        $this->carreers = CareerService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'teachers/' . $this->teacherArray['cedula'];
        if ($this->foto) {
            $this->deleteFile($this->teacherArray['foto']);
            $this->teacherArray['foto'] = $this->saveFile($this->foto, $path);
        }
        if ($this->cv) {
            $this->deleteFile($this->teacherArray['cv']);
            $this->teacherArray['cv'] = $this->saveFile($this->cv, $path);
        }
        TeacherService::create($this->teacherArray);
        return redirect()->route('teacher.list');
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
        return view('livewire.academic.teacher.edit-teacher');
    }
}
