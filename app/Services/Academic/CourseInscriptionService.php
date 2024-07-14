<?php

namespace App\Services\Academic;

use App\Constants\PaymentStatus;
use App\Constants\ProgramPaymentStatus;
use App\Models\CourseInscription;
use App\Services\Accounting\CoursePaymentService;

class CourseInscriptionService
{
    public function __construct()
    {
    }

    static public function getAllByStudentAndCourse($student, $course)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('course_inscription.*', 'course.* as curso')
            ->where('estudiante_id', $student)
            ->where('curso_id', $course)
            ->get();
        return $inscriptions;
    }

    static public function getAllByStudent($student)
    {
        $inscriptions = CourseInscription::where('estudiante_id', $student)->get();
        return $inscriptions;
    }

    static public function getAllByStudentPaginate($student)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('course.* as curso')
            ->where('estudiante_id', $student)->paginate(10);
        return $inscriptions;
    }

    static public function getAllByCoursePaginate($course)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('student.*', 'course_inscription.nota as nota', 'course_inscription.observacion as observacion')
            ->where('curso_id', $course)
            ->paginate(10);
        return $inscriptions;
    }

    static public function getAllStudentAndGradeByCourse($course)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('student.*', 'course_inscription.nota as nota', 'course_inscription.observacion as observacion')
            ->where('curso_id', $course)
            ->get();
        return $inscriptions;
    }


    static public function getAllByCourse($course)
    {
        $inscriptions = CourseInscription::where('curso_id', $course)->get();
        return $inscriptions;
    }

    static public function getAllPaginate($attribute, $paginate, $order = "desc")
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('course_inscription.*', 'course.* as curso', 'student.* as estudiante')
            ->where('course.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('course.codigo', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.nombre', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.apellido', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orWhere('student.cedula', 'ILIKE', '%' . strtolower($attribute) . '%')
            ->orderBy('course.nombre', $order)
            ->paginate($paginate);
        return $inscriptions;
    }

    static  public function getOne($id)
    {
        $inscription = CourseInscription::find($id);
        return $inscription;
    }

    static public function getOneByStudentAndCourse($student, $course)
    {
        $inscription = CourseInscription::where('estudiante_id', $student)->where('curso_id', $course)->first();
        return $inscription ?? false;
    }

    static public function create($data)
    {
        try {
            $hasInscription = self::hasInscription($data['estudiante_id'], $data['curso_id']);
            if ($hasInscription) return false;
            $new = CourseInscription::create($data);
            CoursePaymentService::create([
                'estudiante_id' => $data['estudiante_id'],
                'curso_id' => $data['curso_id'],
                'estado' => PaymentStatus::PENDING
            ]);
            return $new;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function hasInscription($student, $curso)
    {
        $inscription = CourseInscription::where('estudiante_id', $student)->where('curso_id', $curso)->first();
        return $inscription ? true : false;
    }

    static public function update($data)
    {
        try {
            $inscription = CourseInscription::find($data['id']);
            $inscription->estudiante_id = $data['estudiante_id'] || $inscription->estudiante_id;
            $inscription->curso_id = $data['curso_id'] || $inscription->curso_id;
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function updateGrade($data)
    {
        try {
            $inscription = CourseInscription::find($data['id']);
            $inscription->nota = $data['nota'];
            $inscription->observacion = $data['observacion'];
            $inscription->save();
            return $inscription;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static  public function delete($id)
    {
        try {
            $inscription = CourseInscription::find($id);
            $inscription->delete();
            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    static public function getAllByStudentInscription($student)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('course_inscription.*', 'course.*')
            ->where('estudiante_id', $student)
            ->paginate(10);
        return $inscriptions;
    }

    static public function getAllByStudentInscriptionPaginate($student)
    {
        $inscriptions = CourseInscription::join('course', 'course.id', '=', 'course_inscription.curso_id')
            ->join('student', 'student.id', '=', 'course_inscription.estudiante_id')
            ->select('course_inscription.*', 'course.*')
            ->where('estudiante_id', $student)
            ->paginate(10, pageName: "coursesPage");
        return $inscriptions;
    }
};
