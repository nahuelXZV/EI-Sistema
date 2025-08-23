<?php

namespace App\Livewire\Marketing\Program;

use App\Constants\Expedition;
use App\Constants\Honorifics;
use App\Constants\ImageDefault;
use App\Constants\StateStudent;
use App\Models\Program;
use App\Services\Academic\CareerService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Academic\UniversityService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\PaymentTypeService;
use App\Services\Marketing\PreRegistrationService;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePreRegistration extends Component
{
    use WithFileUploads;
    public $program;
    public $breadcrumbs = [];
    public $preRegistrationArray = [];
    public $stateStudents = [];
    public $honorifics = [];
    public $expeditions = [];
    public $universities = [];
    public $careers = [];
    public $programs = [];
    public $discounts = [];
    public $paymentTypes = [];
    public $foto;
    public $voucher;

    public $validate = [
        'preRegistrationArray.honorifico' => 'required',
        'preRegistrationArray.nombre' => 'required',
        'preRegistrationArray.apellido' => 'required',
        'preRegistrationArray.cedula' => 'required|unique:student,cedula',
        'preRegistrationArray.correo' => 'required|email|unique:student,correo',
        'preRegistrationArray.nacionalidad' => 'required',
        'preRegistrationArray.sexo' => 'required',
        'preRegistrationArray.carrera_id' => 'required',
        'preRegistrationArray.universidad_id' => 'required',
        'preRegistrationArray.programa_id' => 'required',
        'preRegistrationArray.monto' => 'required|numeric|min:1',
        'preRegistrationArray.tipo_pago_id' => 'required',
    ];

    public $message = [
        'preRegistrationArray.honorifico.required' => 'El honorifico es requerido',
        'preRegistrationArray.nombre.required' => 'El nombre es requerido',
        'preRegistrationArray.apellido.required' => 'El apellido es requerido',
        'preRegistrationArray.cedula.required' => 'La cedula es requerida',
        'preRegistrationArray.cedula.unique' => 'La cedula ya existe',
        'preRegistrationArray.correo.required' => 'El correo es requerido',
        'preRegistrationArray.correo.email' => 'El correo no es valido',
        'preRegistrationArray.correo.unique' => 'El correo ya existe',
        'preRegistrationArray.nacionalidad.required' => 'La nacionalidad es requerida',
        'preRegistrationArray.sexo.required' => 'El sexo es requerido',
        'preRegistrationArray.carrera_id.required' => 'La carrera es requerida',
        'preRegistrationArray.universidad_id.required' => 'La universidad es requerida',
        'preRegistrationArray.monto.required' => 'El monto es requerido',
        'preRegistrationArray.monto.numeric' => 'El monto debe ser un número',
        'preRegistrationArray.monto.min' => 'El monto debe ser al menos 1',
        'preRegistrationArray.tipo_pago_id.required' => 'El tipo de pago es requerido',
    ];

    public function mount($program)
    {
        $this->preRegistrationArray = [
            'honorifico' => '',
            'nombre' => '',
            'apellido' => '',
            'foto' => '',
            'cedula' => '',
            'expedicion' => '',
            'telefono' => '',
            'correo' => '',
            'nro_registro' => '',
            'nacionalidad' => '',
            'sexo' => '',
            'carrera_id' => '',
            'universidad_id' => '',
            'programa_id' => $program,
            'descuento_id' => null,
            'comprobante_pago' => '',
            'monto' => 0,
            'tipo_pago_id' => null
        ];
        $this->stateStudents = StateStudent::all();
        $this->honorifics = Honorifics::all();
        $this->expeditions = Expedition::all();
        $this->universities = UniversityService::getAll();
        $this->careers = CareerService::getAll();
        $this->programs = ProgramService::getAll();
        $this->discounts = DiscountTypeService::getAll();
        $this->program = ProgramService::getOne($program);
        $this->paymentTypes = PaymentTypeService::getAll();
        $this->breadcrumbs = [['title' => "Programas en oferta", "url" => "program-offer.list"], ['title' => "Ver", "url" => "program-offer.show", "id" => $program], ['title' => "Crear", "url" => "program-offer.create", "id" => $program]];
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $path = 'students/' . $this->preRegistrationArray['cedula'];
        if ($this->foto) {
            $this->preRegistrationArray['foto'] = $this->saveFile($this->foto, $path);
        } else {
            $this->preRegistrationArray['foto'] = ImageDefault::USER;
        }
        if ($this->voucher) {
            $this->preRegistrationArray['comprobante_pago'] = $this->saveFile($this->voucher, 'voucher');
        } else {
            $this->preRegistrationArray['comprobante_pago'] = null;
        }
        PreRegistrationService::create($this->preRegistrationArray);
        return redirect()->route('program-offer.show', $this->program->id);
    }

    private function saveFile($file, $path)
    {
        return 'storage/' . Storage::disk('public')->put($path, $file);
    }

    public function render()
    {
        return view('livewire.marketing.program.create-pre-registration');
    }
}
