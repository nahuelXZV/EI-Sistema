<?php

namespace App\Livewire\Academic\Student;

use App\Constants\Expedition;
use App\Constants\Honorifics;
use App\Constants\ImageDefault;
use App\Constants\StateStudent;
use App\Services\Academic\CareerService;
use App\Services\Academic\StudentService;
use App\Services\Academic\UniversityService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStudent extends Component
{
    use WithFileUploads;
    public $breadcrumbs = [['title' => "Estudiantes", "url" => "student.list"], ['title' => "Crear", "url" => "student.create"]];
    public $studentArray = [];
    public $stateStudents = [];
    public $honorifics = [];
    public $expeditions = [];
    public $universities = [];
    public $careers = [];
    public $foto;

    public $validate = [
        'studentArray.honorifico' => 'required',
        'studentArray.nombre' => 'required',
        'studentArray.apellido' => 'required',
        'studentArray.cedula' => 'required|unique:student,cedula',
        'studentArray.correo' => 'required|email|unique:student,correo',
        'studentArray.nacionalidad' => 'required',
        'studentArray.sexo' => 'required',
        'studentArray.carrera_id' => 'required',
        'studentArray.universidad_id' => 'required',
    ];

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


    public function mount()
    {
        $this->studentArray = [
            'honorifico' => '',
            'nombre' => '',
            'apellido' => '',
            'foto' => '',
            'cedula' => '',
            'expedicion' => '',
            'telefono' => '',
            'correo' => '',
            'estado' => StateStudent::ACTIVE,
            'nro_registro' => '',
            'nacionalidad' => '',
            'sexo' => '',
            'carrera_id' => '',
            'universidad_id' => '',
        ];
        $this->stateStudents = StateStudent::all();
        $this->honorifics = Honorifics::all();
        $this->expeditions = Expedition::all();
        $this->universities = UniversityService::getAll();
        $this->careers = CareerService::getAll();
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'students/' . $this->studentArray['cedula'];
        if ($this->foto) {
            $this->studentArray['foto'] = $this->saveFile($this->foto, $path);
        } else {
            $this->studentArray['foto'] = ImageDefault::USER;
        }
        StudentService::create($this->studentArray);
        return redirect()->route('student.list');
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.academic.student.create-student');
    }
}
