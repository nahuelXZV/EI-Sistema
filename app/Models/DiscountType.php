<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    use HasFactory;
    protected $table = 'discount_type';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
