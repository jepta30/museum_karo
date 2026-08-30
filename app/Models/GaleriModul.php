<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriModul extends Model
{
    protected $guarded = ['id'];

    public function modul()
    {
        return $this->belongsTo(ModulEdukasi::class, 'modul_edukasi_id');
    }
}
