<?php

namespace App\Services\System;

use Spatie\Activitylog\Models\Activity;

class BitacoraService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $activity = Activity::all();
        return $activity;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $attribute = strtolower($attribute);
        $mapeoEventos = [
            'creado' => 'created',
            'eliminado' => 'deleted',
            'actualizado' => 'updated',
        ];

        $activities = Activity::join('users', 'users.id', '=', 'activity_log.causer_id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('activity_log.id as activity_id','activity_log.created_at as date', 'activity_log.*', 'users.*', 'roles.name as nombre_rol')
            ->where(function ($query) use ($attribute,  $mapeoEventos) {
                // Verificar si el attribute es un evento ingles
                if (isset($mapeoEventos[$attribute])) {
                    $query->where('activity_log.event', '=', $mapeoEventos[strtolower($attribute)])
                        ->orWhere('activity_log.event', 'ILIKE', '%' . strtolower($attribute) . '%');
                } else {
                    $query->where('users.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('users.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('activity_log.description', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('roles.name', 'ILIKE', '%' . strtolower($attribute) . '%')
                        ->orWhere('activity_log.event', 'ILIKE', '%' . $attribute . '%');
                }
            })
            ->orderBy('activity_log.id', $order)
            ->paginate($paginate);

        return $activities;
    }

    static public function getlastMonth()
    {
        $activities = Activity::whereMonth('activity_log.created_at', now()->subMonthNoOverflow()->month)
            ->join('users', 'users.id', '=', 'activity_log.causer_id')
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('activity_log.id as activity_id','activity_log.created_at as date', 'activity_log.*', 'users.*', 'roles.name as nombre_rol')->get();
        return $activities;
    }
};
