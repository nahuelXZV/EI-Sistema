<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class RequirementDone extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'requirement_done';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function requirementRegister()
    {
        return $this->belongsTo(RegistrationRequirement::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Requisito Realizado";
    }
}
