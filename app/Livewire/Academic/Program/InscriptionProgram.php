<?php

namespace App\Livewire\Academic\Program;

use App\Models\DiscountType;
use App\Services\Academic\ProgramInscriptionService;
use App\Services\Academic\ProgramService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\DiscountTypeService;
use App\Services\Accounting\ProgramPaymentService;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionProgram extends Component
{
    use WithPagination;
    public $breadcrumbs;
    public $program;
    public $search = '';
    public $listStudent = [];
    public $discountArray = [];
    public $studentDiscounts = [];         // estudiante_id => descuento_id

    public function updatingAttribute()
    {
        $this->resetPage();
    }

    public function mount($program)
    {
        $this->program = ProgramService::getOne($program);
        $this->breadcrumbs = [
            ['title' => "Programas", "url" => "program.list"],
            ['title' => $this->program->sigla, "url" => "program.show", "id" => $this->program->id],
            ['title' => "Inscribir", "url" => "program.inscription", "id" => $this->program->id]
        ];
        $this->discountArray = DiscountTypeService::getAll();
        $listInscription = ProgramInscriptionService::getAllByProgram($this->program->id);
        $programsPayments = ProgramPaymentService::getStudentsByProgram($this->program->id);
        foreach ($listInscription as $inscrito) {
            array_push($this->listStudent, $inscrito->estudiante_id);
            $this->studentDiscounts[$inscrito->estudiante_id] = $programsPayments->firstWhere('id', $inscrito->estudiante_id)->tipo_descuento_id ?? null;
        }
    }

    public function save()
    {
        foreach ($this->listStudent as $estudiante) {
            $exist = ProgramInscriptionService::getOneByStudentAndProgram($estudiante, $this->program->id);
            if (!$exist) {
                ProgramInscriptionService::create([
                    'fecha' => date('Y-m-d'),
                    'estudiante_id' => $estudiante,
                    'programa_id' => $this->program->id,
                    'tipo_descuento_id' => $this->studentDiscounts[$estudiante] ?? null,
                ]);
            }
        }
        $studentsInscriptions = ProgramInscriptionService::getAllByProgram($this->program->id);
        foreach ($studentsInscriptions as $inscrito) {
            if (!in_array($inscrito->estudiante_id, $this->listStudent)) {
                ProgramInscriptionService::delete($inscrito->id);
            }
        }
        return redirect()->route('program.show', $this->program->id);
    }

    public function add($student)
    {
        // esta el valor de estudiante en el array
        if (in_array($student, $this->listStudent)) {
            // eliminar el valor del array
            $this->listStudent = array_diff($this->listStudent, [$student]);
        } else {
            // agregar el valor al array
            array_push($this->listStudent, $student);
        }
    }


    public function render()
    {
        $students = StudentService::getAllPaginateActive($this->search, 15);
        // falta restringir si tiene deudas o no
        return view('livewire.academic.program.inscription-program', compact('students'));
    }
}
