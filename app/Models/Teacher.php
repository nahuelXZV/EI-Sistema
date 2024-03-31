<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teacher';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class, 'carrera_id');
    }
}
