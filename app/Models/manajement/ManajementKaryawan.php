<?php

namespace App\Models\manajement;

use App\Models\Absensi;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class ManajementKaryawan extends Model
{
    protected $fillable = ['uuid','kode_id','nama','email','phone','tanggal_lahir','jenis_kelamin','alamat','tanggal_masuk','foto_karyawan','manajement_departement_id','manajement_posisi_id',];

    protected static function booted()
    {
        static::creating(function ($karyawan) {
            $karyawan->uuid = Str::uuid()->toString();
        });
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function departement()
    {
        return $this->belongsToMany(ManajementDepartement::class, 'karyawan_departement', 'karyawan_id', 'departement_id')->withTimestamps();;
    }

    public function posisis(){
        return $this->belongsToMany(ManajementPosisi::class,'karyawan_posisi','karyawan_id','posisi_id')->withTimestamps();
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'karyawan_id');
    }

}
