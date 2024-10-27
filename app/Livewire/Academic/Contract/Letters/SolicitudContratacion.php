<?php

namespace App\Livewire\Academic\Contract\Letters;

use App\Constants\LettersTemplate;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class SolicitudContratacion extends Component
{
    public $breadcrumbs;
    public $letter;
    public $administrativeCode;

    public $parameters;
    public $dateLetter;
    public $letterUpdate;

    public $validate = [
        'dateLetter' => 'required|date',
        'administrativeCode' => 'required',
        'parameters.codigo_catalogo' => 'required',
        'parameters.ent' => 'required',
        'parameters.da' => 'required',
        'parameters.ue' => 'required',
        'parameters.categoria_prog' => 'required',
        'parameters.fuente' => 'required',
        'parameters.org' => 'required',
        'parameters.part' => 'required',
        'parameters.descripcion' => 'required',
        'parameters.importe' => 'required',
    ];

    public $message = [
        'dateLetter.required' => 'La fecha de la carta es requerida',
        'administrativeCode.required' => 'El código es requerido',
        'parameters.codigo_catalogo.required' => 'El código de catálogo es requerido',
        'parameters.ent.required' => 'El campo es requerido',
        'parameters.da.required' => 'El campo es requerido',
        'parameters.ue.required' => 'El campo es requerido',
        'parameters.categoria_prog.required' => 'La categoría programática es requerida',
        'parameters.fuente.required' => 'La fuente es requerida',
        'parameters.org.required' => 'La organización es requerida',
        'parameters.part.required' => 'La partida es requerida',
        'parameters.descripcion.required' => 'La descripción es requerida',
        'parameters.importe.required' => 'El importe es requerido',
    ];

    public function mount($letter)
    {
        $this->letter = LetterService::getOne($letter);
        $this->letterUpdate = $this->letter;
        $contract = ContractService::getOne($this->letter->contrato_id);
        $teacher = TeacherService::getOne($contract->docente_id);
        $nameTeacher = $teacher->nombre . ' ' . $teacher->apellido;
        $this->breadcrumbs = [
            ['title' => "Docentes", "url" => "teacher.list"], // docente
            ['title' => $nameTeacher, "url" => "teacher.show", "id" => $teacher->id], // docente
            ['title' => "Contrato", "url" => "contract.show", "id" => $contract->id], // contrato
            ['title' => "Ver", "url" => "contract.show", "id" => $contract->id], // contrato
            ['title' => "Carta", "url" => "contract.show", "id" => $contract->id], // carta
            ['title' => LettersTemplate::SOLICITUDCONTRATACION, "url" => "letter.solicitud-contratacion", "id" => $this->letter->id] // carta
        ];
        $this->dateLetter = $this->letter->fecha_carta ?? date('Y-m-d');
        $this->administrativeCode = $this->letter->codigo_administrativo ?? "";
        $this->parameters = [
            "codigo_catalogo" => "",
            "ent" => "",
            "da" => "",
            "ue" => "",
            "categoria_prog" => "",
            "fuente" => "",
            "org" => "",
            "part" => "",
            "descripcion" => "",
            "importe" => "",
        ];
        if ($this->letter->parametros) $this->parameters = json_decode($this->letter->parametros, true);
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $this->letterUpdate->parametros = json_encode($this->parameters);
        $this->letterUpdate->fecha_carta = $this->dateLetter;
        $this->letterUpdate->codigo_administrativo = $this->administrativeCode;
        LetterService::update($this->letterUpdate->toArray());
        return redirect()->route('contract.show', $this->letterUpdate->contrato_id);
    }

    public function render()
    {
        return view('livewire.academic.contract.letters.solicitud-contratacion');
    }
}
