<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessDone extends Model
{
    use HasFactory;
    protected $table = 'process_done';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function moduleProcess()
    {
        return $this->belongsTo(ModuleProcess::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
