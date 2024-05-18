<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedAsset extends Model
{
    use HasFactory;
    protected $table = 'fixed_asset';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
