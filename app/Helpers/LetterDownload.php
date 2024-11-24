<?php

namespace App\Helpers;

use App\Constants\LettersTemplate;
use App\Letters\Teachers\ComunicacionInterna;
use App\Letters\Teachers\InformeCalificacion;
use App\Letters\Teachers\MemorandumDesignacion;
use App\Letters\Teachers\MemorandumDesignacionCalificacion;
use App\Letters\Teachers\NotificacionAdjudicacion;
use App\Letters\Teachers\PropuestaConsultor;
use App\Letters\Teachers\RequerimientoPropuesta;
use App\Letters\Teachers\SolicitudContratacion;
use App\Letters\Teachers\TerminoReferencia;

class LetterDownload
{
    public function download($letterId, $typeLetter)
    {
        // Seleccionar la clase según el tipo de carta
        $letterClass = $this->selectType($typeLetter);
        // Crear una instancia de la clase seleccionada
        $letterSelected = new $letterClass();
        // Retornar la respuesta
        return $letterSelected->download($letterId);
    }

    private function selectType($typeLetter)
    {
        $class = [
            LettersTemplate::TERMINOREFERENCIA => TerminoReferencia::class,
            LettersTemplate::SOLICITUDCONTRATACION => SolicitudContratacion::class,
            LettersTemplate::REQUERIMIENTOPROPUESTA => RequerimientoPropuesta::class,
            LettersTemplate::MEMORANDUMDESIGNACIONCALIFICACION => MemorandumDesignacionCalificacion::class,
            LettersTemplate::PROPUESTACONSULTOR => PropuestaConsultor::class,
            LettersTemplate::INFORMECALIFICACION => InformeCalificacion::class,
            LettersTemplate::NOTIFICACIONADJUDICACION => NotificacionAdjudicacion::class,
            LettersTemplate::MEMORANDUMDESIGNACIONRECEPCION => MemorandumDesignacion::class,
            LettersTemplate::COMUNICACIONINTERNA => ComunicacionInterna::class,
            // Agrega más tipos y clases según sea necesario
        ];
        // Verificar si existe el tipo de carta, de lo contrario, lanzar una excepción
        if (!array_key_exists($typeLetter, $class)) {
            abort(400, "Tipo de carta no válido.");
        }
        return $class[$typeLetter];
    }
}
