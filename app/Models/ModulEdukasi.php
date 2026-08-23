<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModulEdukasi extends Model
{
    use HasFactory;
    
    protected $guarded = ['id'];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'penulis_id');
    }
}
