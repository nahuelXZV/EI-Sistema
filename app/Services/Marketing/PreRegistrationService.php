<?php

namespace App\Services\Marketing;

use App\Constants\StateStudent;
use App\Models\Pay;
use App\Models\PreRegistration;
use App\Services\Academic\ProgramInscriptionService;
use App\Services\Academic\StudentService;
use App\Services\Accounting\PaymentTypeService;
use App\Services\Accounting\PayService;
use App\Services\Accounting\ProgramPaymentService;
use Illuminate\Support\Facades\DB;

class PreRegistrationService
{
    public function __construct() {}

    static public function getAll()
    {
        $pre_registrations = PreRegistration::all();
        return $pre_registrations;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $pre_registrations = PreRegistration::where('nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->where('eliminado', false)
            ->orderBy('id', $order)
            ->paginate($paginate);
        return $pre_registrations;
    }

    static public function getAllByProgramPaginate($programId)
    {
        $pre_registrations = PreRegistration::where('programa_id', $programId)
            ->where('eliminado', false)
            ->paginate(5, pageName: 'preRegistration');
        return $pre_registrations;
    }

    static  public function getOne($id)
    {
        $pre_registration = PreRegistration::find($id);
        return $pre_registration;
    }

    static public function create($data)
    {
        try {
            $new = PreRegistration::create($data);
            return $new;
        } catch (\Throwable $th) {
            dd($th->getMessage());
            return false;
        }
    }

    static public function update($data)
    {
        try {
            $pre_registration = PreRegistration::find($data['id']);
            $pre_registration->honorifico = $data['honorifico'] ?? $pre_registration->honorifico;
            $pre_registration->nombre = $data['nombre'] ?? $pre_registration->nombre;
            $pre_registration->apellido = $data['apellido'] ?? $pre_registration->apellido;
            $pre_registration->foto = $data['foto'] ?? $pre_registration->foto;
            $pre_registration->cedula = $data['cedula'] ?? $pre_registration->cedula;
            $pre_registration->expedicion = $data['expedicion'] ?? $pre_registration->expedicion;
            $pre_registration->telefono = $data['telefono'] ?? $pre_registration->telefono;
            $pre_registration->correo = $data['correo'] ?? $pre_registration->correo;
            $pre_registration->estado = $data['estado'] ?? $pre_registration->estado;
            $pre_registration->fecha_inactividad = $data['fecha_inactividad'] ?? $pre_registration->fecha_inactividad;
            $pre_registration->nro_registro = $data['nro_registro'] ?? $pre_registration->nro_registro;
            $pre_registration->nacionalidad = $data['nacionalidad'] ?? $pre_registration->nacionalidad;
            $pre_registration->sexo = $data['sexo'] ?? $pre_registration->sexo;
            $pre_registration->carrera_id = $data['carrera_id'] ?? $pre_registration->carrera_id;
            $pre_registration->universidad_id = $data['universidad_id'] ?? $pre_registration->universidad_id;
            $pre_registration->save();
            return $pre_registration;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $pre_registration = PreRegistration::find($id);
            $pre_registration->eliminado = true;
            $pre_registration->save();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }


    static public function approvePreRegistration($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $pre_registration = PreRegistration::find($id);
                // Crear estudiante
                $dataStudent = [
                    'honorifico' => $pre_registration->honorifico,
                    'nombre' => $pre_registration->nombre,
                    'apellido' => $pre_registration->apellido,
                    'foto' => $pre_registration->foto,
                    'cedula' => $pre_registration->cedula,
                    'expedicion' => $pre_registration->expedicion,
                    'telefono' => $pre_registration->telefono,
                    'correo' => $pre_registration->correo,
                    'estado' => StateStudent::ACTIVE,
                    'nro_registro' => $pre_registration->nro_registro,
                    'nacionalidad' => $pre_registration->nacionalidad,
                    'sexo' => $pre_registration->sexo,
                    'carrera_id' => $pre_registration->carrera_id,
                    'universidad_id' => $pre_registration->universidad_id,
                ];
                $student = StudentService::create($dataStudent);
                if ($student == null || $student == false) {
                    throw new \Exception("Error al crear estudiante");
                }
                // Crear inscripción
                $dataInscription = [
                    'fecha' => date('Y-m-d'),
                    'estudiante_id' => $student->id,
                    'programa_id' => $pre_registration->programa_id,
                    'tipo_descuento_id' => $pre_registration->descuento_id ?? null
                ];
                $inscription = ProgramInscriptionService::create($dataInscription);

                if ($inscription == null || $inscription == false) {
                    throw new \Exception("Error al crear inscripción");
                }

                // Crear pago
                $programaPayment = ProgramPaymentService::getOneByStudentAndProgram($pre_registration->programa_id, $student->id);
                if ($programaPayment == null || $programaPayment == false) {
                    throw new \Exception("Error al crear pago");
                }

                $dataPay = [
                    "monto" => $pre_registration->monto,
                    "fecha" => now()->format('Y-m-d'),
                    "hora" => now()->format('H:i'),
                    "comprobante" => $pre_registration->comprobante_pago,
                    "observacion" => "Pago de preinscripción",
                    "programa_pago_id" => $programaPayment->id,
                    "curso_pago_id" => null,
                    "tipo_pago_id" => $pre_registration->tipo_pago_id
                ];
                $pay = PayService::create($dataPay);
                if ($pay == null || $pay == false) {
                    throw new \Exception("Error al crear pago");
                }

                // Eliminar preRegistro
                $pre_registration->eliminado = true;
                $pre_registration->save();

                return $student->id;
            });
        } catch (\Throwable $th) {
            return 0;
        }
    }
};
