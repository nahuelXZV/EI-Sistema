<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class FixedAsset extends Model
{
    use HasFactory;
    use LogsActivity;
    protected $table = 'fixed_asset';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Activo Fijos";
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'encargado_id', 'id');
    }

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unidad_id', 'id');
    }
}
