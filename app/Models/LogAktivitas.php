<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $fillable = ['user_id', 'nama_pengguna', 'aksi', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
