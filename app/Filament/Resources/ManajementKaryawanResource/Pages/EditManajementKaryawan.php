<?php

namespace App\Filament\Resources\ManajementKaryawanResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\ManajementKaryawanResource;

class EditManajementKaryawan extends EditRecord
{
    protected static string $resource = ManajementKaryawanResource::class;

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::geturl('index');
    }

    protected function getFormSchema(): array
    {
        return [
            Split::make([
                Section::make('Data Karyawan')
                    ->schema([
                        TextInput::make('kode_id')->required()->numeric()->placeholder('Masukan NIK karyawan...') ->label('NIK'),
                        TextInput::make('nama')
                            ->required()->placeholder('Masukan nama karyawan...')->label('Nama'),
                        TextInput::make('email')->required()->placeholder('Masukan email karyawan...')->label('Email'),
                        TextInput::make('phone')->numeric()->placeholder('Masukan nomor Handphone...')->label('No. HP'),
                        DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),
                        DatePicker::make('tanggal_masuk')->label('Tanggal Masuk Kerja'),
                        Select::make('jenis_kelamin')
                            ->required()
                            ->options([
                                'Laki-laki' => 'Laki-laki',
                                'Perempuan' => 'Perempuan',
                            ])->columnSpanFull()->label('Jenis Kelamin'),
                        FileUpload::make('foto_karyawan')->disk('public')->directory('profile-karyawan')->required()->columnSpanFull()->label('Profile Karyawan'),
                        RichEditor::make('alamat')->placeholder('Masukan alamat karyawan...')->columnSpanFull()->label('Alamat'),
                    ]),
                Section::make('Informasi')
                    ->schema([
                        Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn ($record) => $record->created_at?->diffForHumans()),
                        Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn ($record) => $record->updated_at?->diffForHumans()),
                    ])
                    ->grow(false), 
            ]),
        ];
    }
}
