<?php

namespace App\Services\Academic;

use App\Models\AreaTeacher;

class AreaTeacherService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $area_teacher = AreaTeacher::all();
        return $area_teacher;
    }

    static  public function getOne($id)
    {
        $area = AreaTeacher::find($id);
        return $area;
    }

    static public function create($data)
    {
        try {
            $new = AreaTeacher::create([
                'docente_id' => $data['docente_id'],
                'area_id' => $data['area_id'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $area = AreaTeacher::find($data['id']);
            $area->docente_id = $data['docente_id'];
            $area->area_id = $data['area_id'];
            $area->save();
            return $area;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $area = AreaTeacher::find($id);
            $area->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
