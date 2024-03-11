<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $table = 'university';
    protected $guarded = ['id', 'created_at', 'updated_at'];

}
