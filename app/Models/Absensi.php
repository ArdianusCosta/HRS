<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\manajement\ManajementKaryawan;

class Absensi extends Model
{
    protected $fillable = ['karyawan_id','tanggal_masuk','jam_masuk','jam_pulang','status','lokasi','catatan'];

    public function karyawan()
    {
        return $this->belongsTo(ManajementKaryawan::class, 'karyawan_id');
    }

}
