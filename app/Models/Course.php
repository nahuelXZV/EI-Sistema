<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\LogOptions;

class Course extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $table = 'course';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'docente_id');
    }

    public function courseInscriptions()
    {
        return $this->hasMany(CourseInscription::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function tapActivity(Activity $activity)
    {
        $activity->description = "Curso";
    }
}
