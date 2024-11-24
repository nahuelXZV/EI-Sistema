<?php

namespace App\Helpers;

use App\Constants\Institutions;
use App\Constants\LettersTemplate;
use App\Constants\Position;
use App\Models\Leader;
use App\Models\LetterLeader;

class LetterLeaderHandler
{
    public static function associateLeaders($letterId, $typeLetter)
    {
        switch ($typeLetter) {
            case LettersTemplate::TERMINOREFERENCIA:
                self::associateTerminoReferencia($letterId);
                break;
            case LettersTemplate::SOLICITUDCONTRATACION:
                self::associateSolicitudContratacion($letterId);
                break;
            case LettersTemplate::REQUERIMIENTOPROPUESTA:
                self::associateRequerimientoPropuesta($letterId);
                break;
            case LettersTemplate::MEMORANDUMDESIGNACIONCALIFICACION;
                self::associateMemorandumDesignacionCalificacion($letterId);
                break;
            case LettersTemplate::PROPUESTACONSULTOR:
                self::associatePropuestaConsultor($letterId);
                break;
            case LettersTemplate::INFORMECALIFICACION:
                self::associateInformeCalificacion($letterId);
                break;
            case LettersTemplate::COMUNICACIONINTERNA:
                self::associateComunicacionInternas($letterId);
                break;
            case LettersTemplate::MEMORANDUMDESIGNACIONRECEPCION:
                self::associateMemorandumDesignacion($letterId);
                break;
                // Agrega más tipos de carta según sea necesario
        }
    }

    private static function associateTerminoReferencia($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateSolicitudContratacion($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);

        $leader = Leader::where('cargo', Position::DECANOFCET)
            ->where('institucion', Institutions::FCET)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);

        $leader = Leader::where('cargo', Position::RESPONSABLECONTRATACIONJAF)
            ->where('institucion', Institutions::JAF)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);

        $leader = Leader::where('cargo', Position::DIRECTOREI)
            ->where('institucion', Institutions::ESCUELAINGENIERIAFCET)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateRequerimientoPropuesta($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associatePropuestaConsultor($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateInformeCalificacion($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::ENCARGADOPLAFORMAVIRTUAL)
            ->where('institucion', Institutions::FCET)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::RESPONSABLECONTRATACIONJAF)
            ->where('institucion', Institutions::JAF)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateMemorandumDesignacion($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::RESPONSABLECONTRATACIONJAF)
            ->where('institucion', Institutions::JAF)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateMemorandumDesignacionCalificacion($letterId)
    {
        $leader = Leader::where('cargo', Position::COORDINADORACADEMICO)
            ->where('institucion', Institutions::ESCUELAINGENIERIA)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::RESPONSABLECONTRATACIONJAF)
            ->where('institucion', Institutions::JAF)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::ENCARGADOPLAFORMAVIRTUAL)
            ->where('institucion', Institutions::FCET)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }

    private static function associateComunicacionInternas($letterId)
    {
        $leader = Leader::where('cargo', Position::ASESORLEGAL)
            ->where('institucion', Institutions::UAGRM)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::RESPONSABLECONTRATACIONJAF)
            ->where('institucion', Institutions::JAF)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
        $leader = Leader::where('cargo', Position::DIRECTOREI)
            ->where('institucion', Institutions::ESCUELAINGENIERIAFCET)
            ->where('activo', true)
            ->first();
        LetterLeader::create([
            'letter_id' => $letterId,
            'leader_id' => $leader->id
        ]);
    }
}
