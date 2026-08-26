<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KunjunganWebsite extends Model
{
    protected $fillable = ['ip_address', 'device_type', 'url', 'koleksi_id'];

    public function koleksi()
    {
        return $this->belongsTo(Koleksi::class);
    }
}
