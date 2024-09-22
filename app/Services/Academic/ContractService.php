<?php

namespace App\Services\Academic;

use App\Models\Contract;

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
            $contract = Contract::create($data);
            return $contract;
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
