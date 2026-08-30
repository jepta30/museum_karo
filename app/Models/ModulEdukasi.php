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

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class, 'koleksi_id');
    }

    public function galeri()
    {
        return $this->hasMany(GaleriModul::class, 'modul_edukasi_id');
    }
}
