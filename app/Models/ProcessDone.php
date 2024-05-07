<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class ProcessDone extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'process_done';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function moduleProcess()
    {
        return $this->belongsTo(ModuleProcess::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Proceso Realizado";
    }
}
