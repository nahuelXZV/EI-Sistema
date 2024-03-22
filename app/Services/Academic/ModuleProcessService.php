<?php

namespace App\Services\Academic;

use App\Models\ModuleProcess;
use App\Models\ProcessDone;
use Carbon\Carbon;

class ModuleProcessService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $processes = ModuleProcess::all();
        return $processes;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "asc")
    {
        $processes = ModuleProcess::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('orden', $order)
            ->paginate($paginate);
        return $processes;
    }

    static  public function getOne($id)
    {
        $process = ModuleProcess::find($id);
        return $process;
    }

    static public function create($data)
    {
        $last_process = ModuleProcess::orderBy('orden', 'desc')->first();
        $lastPosition = 0;
        $last_process ? $lastPosition = $last_process->orden : $lastPosition = 0;
        try {
            $new = ModuleProcess::create([
                'orden' => $lastPosition + 1,
                'nombre' => $data['nombre'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $process = ModuleProcess::find($data['id']);
            $process->nombre = $data['nombre'];
            $process->save();
            return $process;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $process = ModuleProcess::find($id);
            $process->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function level_up($id)
    {
        try {
            $process = ModuleProcess::find($id);
            if ($process->orden != 1) {
                $antprocess = ModuleProcess::where('orden', $process->orden - 1)->first();
                $process->orden = $process->orden - 1;
                $process->save();
                $antprocess->orden = $antprocess->orden + 1;
                $antprocess->save();
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function level_down($id)
    {
        try {
            $process = ModuleProcess::find($id);
            $last_process = ModuleProcess::orderBy('orden', 'desc')->first();
            if ($process->orden != $last_process->orden) {
                $next_process = ModuleProcess::where('orden', $process->orden + 1)->first();
                $process->orden = $process->orden + 1;
                $process->save();
                $next_process->orden = $next_process->orden - 1;
                $next_process->save();
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getProcesses($module)
    {
        try {
            $procesos = ModuleProcess::orderBy('orden', 'asc')->get();
            $procesoModulo = ProcessDone::where('modulo_id', $module->id)->get();

            // Filtrar los procesos realizados por módulo
            $procesosRealizadosModulo = $procesoModulo->filter(function ($procesoRealizado) use ($module) {
                return $procesoRealizado->modulo_id == $module->id;
            });

            // Crear lista de procesos con estado de realización
            $listaProceso = $procesos->map(function ($proceso) use ($procesosRealizadosModulo) {
                $realizado = $procesosRealizadosModulo->contains('proceso_modulo_id', $proceso->id);
                $fecha = $realizado ? $procesosRealizadosModulo->where('proceso_modulo_id', $proceso->id)->first()->fecha : null;

                return [
                    'id' => $proceso->id,
                    'nombre' => $proceso->nombre,
                    'estado' => $realizado,
                    'fecha' => $fecha,
                ];
            });
            return $listaProceso;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function processDone($module, $procesoId)
    {
        try {
            $new = ProcessDone::create([
                'modulo_id' => $module->id,
                'proceso_modulo_id' => $procesoId,
                'fecha' => Carbon::now()
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
