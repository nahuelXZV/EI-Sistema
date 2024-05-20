<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;
    protected $table = 'support_request';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
