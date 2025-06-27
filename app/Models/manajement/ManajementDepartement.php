<?php

namespace App\Models\manajement;

use Illuminate\Database\Eloquent\Model;

class ManajementDepartement extends Model
{
    protected $fillable = ['departement'];

    public function manajementkaryawan()
    {
        return $this->belongsToMany(ManajementKaryawan::class, 'karyawan_departement', 'departement_id', 'karyawan_id')->withTimestamps();
    }    
}
