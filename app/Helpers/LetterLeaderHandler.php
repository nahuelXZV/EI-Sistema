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
            case LettersTemplate::SOLICITUDCONTRATACION:
                self::associateSolicitudContratacion($letterId);
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
}
