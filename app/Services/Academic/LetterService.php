<?php

namespace App\Services\Academic;

use App\Helpers\LetterLeaderHandler;
use App\Models\Letter;

class LetterService
{
    public function __construct() {}

    static public function createTemplate($contract) {}

    static public function getAllByContract($contractId)
    {
        $letters = Letter::where('contrato_id',  $contractId)
            ->orderBy('id', 'desc')
            ->get();
        return $letters;
    }

    static  public function getOne($id)
    {
        $letter = Letter::find($id);
        return $letter;
    }

    static public function create($data)
    {
        try {
            $new = Letter::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $letter = Letter::find($data['id']);
            $letter->update($data);
            if (!$data['fecha_carta']) LetterLeaderHandler::associateLeaders($data['id'], $data['nombre']);
            return $letter;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $letter = Letter::find($id);
            $letter->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
