<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequirementDone extends Model
{
    use HasFactory;
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
}
