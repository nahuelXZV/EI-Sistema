<?php

namespace App\Services\Academic;

use App\Constants\ProgramPaymentStatus;
use App\Models\ProgramInscription;
use App\Services\Accounting\ProgramPaymentService;

class ProgramInscriptionService
{
    public function __construct()
    {
    }

    static public function getAllByStudent($student)
    {
        $inscriptions = ProgramInscription::where('estudiante_id', $student)->get();
        return $inscriptions;
    }

    static public function getAllByStudentPaginate($student)
    {
        $inscriptions = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('program.* as programa')
            ->where('estudiante_id', $student)->paginate(10);
        return $inscriptions;
    }

    static public function getAllStudentsInscriptions($program)
    {
        $studens = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('student.*')
            ->where('program_inscription.programa_id', $program)
            ->paginate(10);
        return $studens;
    }

    static public function getAllStudentsInscriptionsPaginate($search, $program)
    {
        $studens = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('student.*', 'program_inscription.programa_id as program_id')
            ->where('program_inscription.programa_id', $program)
            ->where('student.nombre', 'ILIKE', '%' . strtolower($search) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($search) . '%')
            ->paginate(10);
        return $studens;
    }

    static public function getAllStudentsInscriptionsByProgram($search, $program)
    {
        $studens = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('student.*', 'program_inscription.programa_id as program_id')
            ->where('program_inscription.programa_id', $program)
            ->where('student.nombre', 'ILIKE', '%' . strtolower($search) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($search) . '%')
            ->get();
        return $studens;
    }


    static public function getAllByProgram($program)
    {
        $inscriptions = ProgramInscription::where('programa_id', $program)->get();
        return $inscriptions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inscriptions = ProgramInscription::join('program', 'program.id', '=', 'program_inscription.programa_id')
            ->join('student', 'student.id', '=', 'program_inscription.estudiante_id')
            ->select('program_inscription.*', 'program.* as programa', 'student.* as estudiante')
            ->where('program.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('program.codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('program.nombre', $order)
            ->paginate($paginate);
        return $inscriptions;
    }

    static  public function getOne($id)
    {
        $inscription = ProgramInscription::find($id);
        return $inscription;
    }

    static public function getOneByStudentAndProgram($student, $program)
    {
        $inscription = ProgramInscription::where('estudiante_id', $student)->where('programa_id', $program)->first();
        return $inscription ?? false;
    }

    static public function create($data)
    {
        try {
            $hasInscription = self::hasInscription($data['estudiante_id'], $data['programa_id']);
            if ($hasInscription) return false;
            $new = ProgramInscription::create($data);
            ProgramPaymentService::create([
                'estudiante_id' => $data['estudiante_id'],
                'programa_id' => $data['programa_id'],
                'estado' => ProgramPaymentStatus::PENDING
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function hasInscription($student, $program)
    {
        $inscription = ProgramInscription::where('estudiante_id', $student)->where('programa_id', $program)->first();
        return $inscription ? true : false;
    }

    static public function update($data)
    {
        try {
            $inscription = ProgramInscription::find($data['id']);
            $inscription->estudiante_id = $data['estudiante_id'] || $inscription->estudiante_id;
            $inscription->programa_id = $data['programa_id'] || $inscription->programa_id;
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inscription = ProgramInscription::find($id);
            $inscription->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
