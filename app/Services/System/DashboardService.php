<?php

namespace App\Services\System;

use App\Constants\ProgramsTypes;
use App\Models\Program;
use App\Models\Student;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DashboardService
{
    public function __construct()
    {
    }

    static public function getUsersByRole()
    {
        try {
            $roles = Role::orderBy('id', 'desc')->take(5)->get();
            $cantidadUsuariosPorRol = [];

            foreach ($roles as $rol) {
                $cantidadUsuarios = User::whereHas('roles', function ($query) use ($rol) {
                    $query->where('role_id', $rol->id);
                })->count();

                $cantidadUsuariosPorRol[] = [
                    'rol' => $rol->name,
                    'cantidad_usuarios' => $cantidadUsuarios,
                    'porcentaje_usuarios' => 0,
                ];
            }

            $totalUsuarios = User::count();
            foreach ($cantidadUsuariosPorRol as &$rol) {
                $rol['porcentaje_usuarios'] = ($rol['cantidad_usuarios'] / $totalUsuarios) * 100;
            }

            return $cantidadUsuariosPorRol;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getProgramTypes($programTypes)
    {
        try {
            $cantProgramTypes = [];
            foreach ($programTypes as $programType) {
                $cantProgramTypes[$programType] = Program::where('tipo', $programType)->count();
            }
            return $cantProgramTypes;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getStateTypes($stateStudents)
    {
        try {
            $cantStateStudents = [];
            foreach ($stateStudents as $stateStudent) {
                $cantStateStudents[$stateStudent] = Student::where('estado', $stateStudent)->count();
            }
            return $cantStateStudents;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
