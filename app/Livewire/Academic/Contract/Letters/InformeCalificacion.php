<?php

namespace App\Livewire\Academic\Contract\Letters;

use App\Constants\LettersTemplate;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class InformeCalificacion extends Component
{
    public $breadcrumbs;
    public $letter;

    public $parameters;
    public $dateLetter;
    public $letterUpdate;

    public $validate = [
        'parameters.codigo' => 'required',
        'parameters.fecha_inicio' => 'required|date',
        'parameters.fecha_fin' => 'required|date',
        'dateLetter' => 'required|date'
    ];

    public $message = [
        'parameters.codigo.required' => 'El código es requerido',
        'parameters.fecha_inicio.required' => 'La fecha de inicio es requerida',
        'parameters.fecha_fin.required' => 'La fecha de fin es requerida',
        'dateLetter.required' => 'La fecha de la carta es requerida'
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
            ['title' => LettersTemplate::INFORMECALIFICACION, "url" => "letter.termino-referencia", "id" => $this->letter->id] // carta
        ];
        $this->dateLetter = $this->letter->fecha_carta ?? date('Y-m-d');
        $this->parameters = [
            "codigo" => "",
            "fecha_inicio" => "",
            "fecha_fin" => "",
        ];
        if ($this->letter->parametros) $this->parameters = json_decode($this->letter->parametros, true);
    }

    public function save()
    {
        $this->validate($this->validate, $this->message);
        $this->letterUpdate->parametros = json_encode($this->parameters);
        $this->letterUpdate->fecha_carta = $this->dateLetter;
        LetterService::update($this->letterUpdate->toArray());
        return redirect()->route('contract.show', $this->letterUpdate->contrato_id);
    }
    public function render()
    {
        return view('livewire.academic.contract.letters.informe-calificacion');
    }
}
