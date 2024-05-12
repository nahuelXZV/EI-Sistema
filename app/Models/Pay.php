<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Pay extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'pay';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Pagos";
    }
}
