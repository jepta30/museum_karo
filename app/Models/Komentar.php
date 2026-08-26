<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Komentar extends Model
{
    use HasFactory;

    protected $fillable = ['koleksi_id', 'nama', 'email', 'isi_komentar', 'status'];

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class);
    }
}
