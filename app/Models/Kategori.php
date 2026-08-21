<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';
    protected $fillable = ['nama', 'kode'];

    public function koleksi()
    {
        return $this->hasMany(Koleksi::class, 'kategori_id');
    }
}
