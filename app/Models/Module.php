<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class Module extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'module';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function program()
    {
        return $this->belongsTo(Program::class, 'programa_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'docente_id');
    }

    public function processesDone()
    {
        return $this->hasMany(ProcessDone::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Modulo";
    }
}
