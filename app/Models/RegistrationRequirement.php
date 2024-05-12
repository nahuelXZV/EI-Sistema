<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class RegistrationRequirement extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'registration_requirement';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function requirementDone()
    {
        return $this->hasMany(RequirementDone::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Registro de Requisitos";
    }
}
