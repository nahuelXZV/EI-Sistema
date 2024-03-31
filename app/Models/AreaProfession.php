<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaProfession extends Model
{
    use HasFactory;
    protected $table = 'area_profession';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
