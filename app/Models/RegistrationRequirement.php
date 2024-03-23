<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationRequirement extends Model
{
    use HasFactory;
    protected $table = 'registration_requirement';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function requirementDone()
    {
        return $this->hasMany(RequirementDone::class);
    }
}
