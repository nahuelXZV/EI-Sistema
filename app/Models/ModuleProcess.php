<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class ModuleProcess extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'module_process';
    protected $guarded = ['id', 'created_at', 'updated_at'];

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
        $activity->description = "Proceso de Modulo";
    }
}
