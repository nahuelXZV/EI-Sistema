<?php

namespace App\Livewire\Academic\Contract\Letters;

use App\Constants\LettersTemplate;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class NotificacionAdjudicacion extends Component
{
    public $breadcrumbs;
    public $letter;

    public $parameters;
    public $dateLetter;
    public $administrativeCode;
    public $letterUpdate;

    public $validate = [
        'parameters.resolucion_rectoral' => 'required',
        'parameters.nro_preventiva' => 'required',
        'dateLetter' => 'required|date',
        'administrativeCode' => 'required'
    ];

    public $message = [
        'parameters.resolucion_rectoral.required' => 'La resolución rectoral es requerida',
        'parameters.nro_preventiva.required' => 'El número de preventiva es requerido',
        'dateLetter.required' => 'La fecha de la carta es requerida',
        'administrativeCode.required' => 'El código administrativo es requerido'
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
            ['title' => LettersTemplate::NOTIFICACIONADJUDICACION, "url" => "letter.termino-referencia", "id" => $this->letter->id] // carta
        ];
        $this->dateLetter = $this->letter->fecha_carta ?? date('Y-m-d');
        $this->parameters = [
            "resolucion_rectoral" => "",
            "nro_preventiva" => "",
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
        return view('livewire.academic.contract.letters.notificacion-adjudicacion');
    }
}
