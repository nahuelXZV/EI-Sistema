<?php

namespace App\Livewire\Academic\Contract\Letters;

use App\Constants\LettersTemplate;
use App\Services\Academic\ContractService;
use App\Services\Academic\LetterService;
use App\Services\Academic\TeacherService;
use Livewire\Component;

class PropuestaConsultor extends Component
{
    public $breadcrumbs;
    public $letter;

    public $parameters;
    public $dateLetter;
    public $letterUpdate;

    public $validate = [
        'dateLetter' => 'required|date',
    ];

    public $message = [
        'dateLetter.required' => 'La fecha de la carta es requerida',
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
            ['title' => LettersTemplate::PROPUESTACONSULTOR, "url" => "letter.requerimiento-propuesta", "id" => $this->letter->id] // carta
        ];
        $this->dateLetter = $this->letter->fecha_carta ?? date('Y-m-d');
        $this->parameters = [];
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
        return view('livewire.academic.contract.letters.propuesta-consultor');
    }
}
