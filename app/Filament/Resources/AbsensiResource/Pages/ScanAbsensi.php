<?php

namespace App\Filament\Resources\AbsensiResource\Pages;

use App\Models\Absensi;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use App\Filament\Resources\AbsensiResource;
use App\Models\manajement\ManajementKaryawan;

class ScanAbsensi extends Page
{
    protected static string $resource = AbsensiResource::class;

    protected static string $view = 'filament.resources.absensi-resource.pages.scan-absensi';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_id')
                ->label('Kode ID Karyawan')
                ->disabled(),            
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $karyawan = ManajementKaryawan::where('kode_id', $data['kode_id'])->first();

        if (! $karyawan) {
            Notification::make()
                ->title('Karyawan tidak ditemukan')
                ->danger()
                ->send();
            return;
        }

        $sudahAbsen = Absensi::where('karyawan_id', $karyawan->id)
            ->whereDate('tanggal_masuk', now()->toDateString())
            ->exists();

        if ($sudahAbsen) {
            Notification::make()
                ->title("Sudah absen hari ini")
                ->danger()
                ->body("Karyawan {$karyawan->nama} telah absen hari ini.")
                ->send();
            return;
        }

        Absensi::create([
            'karyawan_id' => $karyawan->id,
            'tanggal_masuk' => now()->toDateString(),
            'jam_masuk' => now()->toTimeString(),
            'status' => 'hadir',
        ]);

        Notification::make()
            ->title("Absensi berhasil")
            ->success()
            ->body("Karyawan {$karyawan->nama} berhasil absen.")
            ->send();

        $this->form->fill(); // reset input
    }
}
