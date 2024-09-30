<?php

namespace App\Services\Academic;

use App\Constants\LettersTemplate;
use App\Models\Contract;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;

class ContractService
{
    public function __construct() {}

    static public function getAll()
    {
        $contracts = Contract::all();
        return $contracts;
    }

    static public function getAllByTeacher($teacher)
    {
        $contract = Contract::join('teacher', 'teacher.id', '=', 'contracts.docente_id')
            ->leftjoin('module', 'module.id', '=', 'contracts.modulo_id')
            ->leftjoin('course', 'course.id', '=', 'contracts.curso_id')
            ->select('contracts.*', 'teacher.nombre as docente', 'module.nombre as modulo', 'course.nombre as curso')
            ->where('teacher.id', $teacher)
            ->orderBy('id', 'desc')
            ->paginate(15);
        return $contract;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $contract = Contract::join('teacher', 'teacher.id', '=', 'contracts.docente_id')
            ->join('module', 'module.id', '=', 'contracts.modulo_id')
            ->join('course', 'course.id', '=', 'contracts.curso_id')
            ->select('contracts.*', 'teacher.nombre as docente', 'module.nombre as modulo', 'course.nombre as curso')
            ->where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $contract;
    }

    static  public function getOne($id)
    {
        $contract = Contract::find($id);
        return $contract;
    }

    static public function create($data)
    {
        try {
            return DB::transaction(function () use ($data) {
                $contract = Contract::create($data);
                $letterTemplates = LettersTemplate::getTemplateLettersTeachers();
                foreach ($letterTemplates as $template) {
                    Letter::create([
                        'nombre' => $template['title'],
                        'ruta' => $template['route'],
                        'contrato_id' => $contract->id
                    ]);
                }
                return true;
            });
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $contract = Contract::find($data['id']);
            $contract->update($data);
            return $contract;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $contract = Contract::find($id);
            $contract->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
