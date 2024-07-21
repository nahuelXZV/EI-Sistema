<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryRequestDetail extends Model
{
    use HasFactory;

    protected $table = 'inventory_request_details';
    protected $guarded = ['id', 'created_at', 'updated_at'];
}
