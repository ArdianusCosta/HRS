<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\manajement\ManajementKaryawan;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'kode_id' => 'required|string',
        ]);

        $karyawan = ManajementKaryawan::where('kode_id', $request->kode_id)->first();

        if(!$karyawan){
            return response()->json([
                'message' => 'NIK Tidak ditemukan',
            ], 404);
        }

        $sudahAbsen = Absensi::where('karyawan_id', $karyawan->id)
        ->whereDate('tanggal', now()->toDateString())
        ->exists();

        if($sudahAbsen){
            return response()->json([
                'message' => 'Karyawan sudah Absen hari ini',
            ],400);
        }

        $absensi = Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'status' => 'hadir',
        ]);

        return response()->json([
            'message' => 'Berhasil Absen',
            'data' => $absensi,
        ]);
    }
}
