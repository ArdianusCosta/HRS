<?php

namespace App\Filament\Resources\PengajuanCutiResource\Pages;

use Filament\Actions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PengajuanCutiResource;

class CreatePengajuanCuti extends CreateRecord
{
    protected static string $resource = PengajuanCutiResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();

        $mulai = Carbon::parse($data['mulai_hari']);
        $akhir = Carbon::parse($data['akhir_hari']);
        $data['total_hari'] = $mulai->diffInDays($akhir) + 1;

        return $data;
    }
}
