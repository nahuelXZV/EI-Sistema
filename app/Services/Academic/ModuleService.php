<?php

namespace App\Services\Academic;

use App\Models\Module;

class ModuleService
{
    public function __construct()
    {
    }
    static public function getAll()
    {
        $modules = Module::all();
        return $modules;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $modules = Module::where('module.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('module.codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('module.modalidad', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('module.nombre', $order)
            ->paginate($paginate);
        return $modules;
    }

    static  public function getOne($id)
    {
        $module = Module::find($id);
        return $module;
    }

    static public function create($data)
    {
        try {
            $new = Module::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th);
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $module = Module::find($data['id']);
            $module->nombre = $data['nombre'] ?? $module->nombre;
            $module->codigo = $data['codigo'] ?? $module->codigo;
            $module->sigla = $data['sigla'] ?? $module->sigla;
            $module->version = $data['version'] ?? $module->version;
            $module->edicion = $data['edicion'] ?? $module->edicion;
            $module->modalidad = $data['modalidad'] ?? $module->modalidad;
            $module->estado = $data['estado'] ?? $module->estado;
            $module->costo = $data['costo'] ?? $module->costo;
            $module->hrs_academicas = $data['hrs_academicas'] ?? $module->hrs_academicas;
            $module->fecha_inicio = $data['fecha_inicio'] ?? $module->fecha_inicio;
            $module->fecha_final = $data['fecha_final'] ?? $module->fecha_final;
            $module->contenido = $data['contenido'] ?? $module->contenido;
            $module->calificacion_docente = $data['calificacion_docente'] ?? $module->calificacion_docente;
            $module->programa_id = $data['programa_id'] ?? $module->programa_id;
            $module->docente_id = $data['docente_id'] ?? $module->docente_id;
            $module->save();
            return $module;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $module = Module::find($id);
            $module->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};