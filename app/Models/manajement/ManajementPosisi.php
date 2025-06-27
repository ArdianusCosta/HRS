<?php

namespace App\Models\manajement;

use Illuminate\Database\Eloquent\Model;

class ManajementPosisi extends Model
{
    protected $fillable = ['posisi'];

    public function manajementkaryawan()
    {
        return $this->belongsToMany(ManajementKaryawan::class, 'karyawan_posisi','posisi_id','karyawan_id')->withTimestamps();
    }
}
