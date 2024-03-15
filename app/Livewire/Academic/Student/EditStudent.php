<?php

namespace App\Livewire\Academic\Student;

use App\Constants\Expedition;
use App\Constants\Honorifics;
use App\Constants\StateStudent;
use App\Services\Academic\CareerService;
use App\Services\Academic\StudentService;
use App\Services\Academic\UniversityService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditStudent extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"], ['title' => "Editar", "url" => "student.edit"]];
    public $studentArray = [];
    public $stateStudents = [];
    public $honorifics = [];
    public $expeditions = [];
    public $universities = [];
    public $careers = [];
    public $foto;

    public $message = [
        'studentArray.honorifico.required' => 'El honorifico es requerido',
        'studentArray.nombre.required' => 'El nombre es requerido',
        'studentArray.apellido.required' => 'El apellido es requerido',
        'studentArray.cedula.required' => 'La cedula es requerida',
        'studentArray.cedula.unique' => 'La cedula ya existe',
        'studentArray.correo.required' => 'El correo es requerido',
        'studentArray.correo.email' => 'El correo no es valido',
        'studentArray.correo.unique' => 'El correo ya existe',
        'studentArray.nacionalidad.required' => 'La nacionalidad es requerida',
        'studentArray.sexo.required' => 'El sexo es requerido',
        'studentArray.carrera_id.required' => 'La carrera es requerida',
        'studentArray.universidad_id.required' => 'La universidad es requerida',
    ];

    public function mount($student)
    {
        $this->studentArray = StudentService::getOne($student)->toArray();
        $this->stateStudents = StateStudent::all();
        $this->honorifics = Honorifics::all();
        $this->expeditions = Expedition::all();
        $this->universities = UniversityService::getAll();
        $this->careers = CareerService::getAll();
    }

    public function save()
    {
        $this->validate([
            'studentArray.honorifico' => 'required',
            'studentArray.nombre' => 'required',
            'studentArray.apellido' => 'required',
            'studentArray.cedula' => 'required|unique:student,cedula,' . $this->studentArray['id'],
            'studentArray.correo' => 'required|email|unique:student,correo,' . $this->studentArray['id'],
            'studentArray.nacionalidad' => 'required',
            'studentArray.sexo' => 'required',
            'studentArray.carrera_id' => 'required',
            'studentArray.universidad_id' => 'required',
        ], $this->message);
        $path = 'students/' . $this->studentArray['cedula'];
        if ($this->foto) {
            $this->deleteFile($this->studentArray['foto']);
            $this->studentArray['foto'] = $this->saveFile($this->foto, $path);
        }
        StudentService::update($this->studentArray);
        return redirect()->route('student.show', $this->studentArray['id']);
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
        return view('livewire.academic.student.edit-student');
    }
}
