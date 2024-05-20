<?php

namespace App\Services\TICs;

use App\Models\SupportRequest;

class SupportService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $requests = SupportRequest::all();
        return $requests;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $requests = SupportRequest::where('motivo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('estado', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $requests;
    }

    static public function getAllPaginateForUser($userId, $attribute, $paginate, $order = "desc")
    {
        $requests = SupportRequest::where(function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->where(function ($query) use ($attribute) {
                $query->where('motivo', 'ILIKE', '%' . strtolower($attribute) . '%')
                    ->orWhere('estado', 'ILIKE', '%' . strtolower($attribute) . '%');
            })
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $requests;
    }


    static  public function getOne($id)
    {
        $request = SupportRequest::find($id);
        return $request;
    }

    static public function getOneAll($id)
    {
        $request = SupportRequest::leftJoin('users', 'users.id', '=', 'support_request.user_id')
            ->select('support_request.*', 'users.nombre as name_user', 'users.apellido as lastname_user')
            ->where('support_request.id', $id)
            ->first();

        return $request;
    }

    static public function create($data)
    {
        try {
            $new = SupportRequest::create($data);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $request = SupportRequest::find($data['id']);
            $request->motivo = $data['motivo'] ?? $request->motivo;
            $request->fecha = $data['fecha'] ?? $request->fecha;
            $request->hora = $data['hora'] ?? $request->hora;
            $request->estado = $data['estado'] ?? $request->estado;
            $request->descripcion = $data['descripcion'] ?? $request->descripcion;
            $request->recurso = $data['recurso'] ?? $request->recurso;
            $request->fecha_visita = $data['fecha_visita'] ?? $request->fecha_visita;
            $request->user_id = $data['user_id'] ?? $request->user_id;
            $request->save();
            return $request;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $request = SupportRequest::find($id);
            $request->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
