<?php

namespace App\Services\Academic;

use App\Models\RegistrationRequirement;
use App\Models\RequirementDone;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class RegistrationRequirementService
{
    public function __construct()
    {
    }

    static public function getAll()
    {
        $requirement = RegistrationRequirement::all();
        return $requirement;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $requirement = RegistrationRequirement::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $requirement;
    }

    static  public function getOne($id)
    {
        $requirement = RegistrationRequirement::find($id);
        return $requirement;
    }

    static public function create($data)
    {
        try {
            $new = RegistrationRequirement::create([
                'nombre' => $data['nombre'],
                'importancia' => $data['importancia'],
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $requirement = RegistrationRequirement::find($data['id']);
            $requirement->nombre = $data['nombre'];
            $requirement->importancia = $data['importancia'];
            $requirement->save();
            return $requirement;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $requirement = RegistrationRequirement::find($id);
            $requirement->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getRequirementsDone($student)
    {
        try {
            $requirementsDone = RequirementDone::where('estudiante_id', $student->id)->get();
            $requirementsWithNames = [];

            foreach ($requirementsDone as $requirementDone) {
                $requisito = RegistrationRequirementService::getOne($requirementDone->requisito_registro_id);
                if ($requisito) {
                    $requirementsWithNames[] = [
                        'id' => $requirementDone->id,
                        'nombre' => $requisito->nombre,
                        'documento' => $requirementDone->nombre,
                        'dir'=> $requirementDone->documento,
                        'importancia' => $requisito->importancia,
                        'fecha' => $requirementDone->fecha,
                    ];
                }
            }

            return $requirementsWithNames;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getRequirementsNotDone($student)
    {
        try {
            $allRequirements = RegistrationRequirement::all();
            $requirementsDone = RequirementDone::where('estudiante_id', $student->id)->get();
            $requirementsNotDone = $allRequirements->filter(function ($requirement) use ($requirementsDone) {
                foreach ($requirementsDone as $done) {
                    if ($requirement->id == $done->requisito_registro_id) {
                        return false;
                    }
                }
                return true;
            });

            return $requirementsNotDone;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function deleteRequirement($id)
    {
        try {
            $requirement = RequirementDone::find($id);
            $requirement->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function saveDocuments($documents, $student)
    {
        try {
            $requisitos = RegistrationRequirementService::getAll();
            $path = 'students/' . $student->id;
            foreach ($requisitos as $requisito) {
                if (array_key_exists($requisito->id, $documents)) {
                    $archivo = $documents[$requisito->id];
                    $filename = $archivo->getClientOriginalName();
                    $dir = 'storage/' . Storage::disk('public')->put($path, $archivo);
                    RequirementDone::create([
                        'nombre' => $filename,
                        'documento' => $dir,
                        'fecha' => Carbon::now(),
                        'estudiante_id' => $student->id,
                        'requisito_registro_id' => $requisito->id,
                    ]);
                }
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
};
