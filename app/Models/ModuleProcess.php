<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleProcess extends Model
{
    use HasFactory;
    protected $table = 'module_process';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
