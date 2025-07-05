<?php

namespace App\Filament\Resources;

use App\Models\Absensi;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Traits\ShieldableResource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\AbsensiResource\Pages;

class AbsensiResource extends Resource
{
    use ShieldableResource;

    protected static ?string $model = Absensi::class;

    public static function getSlug(): string
    {
        return 'absensi';
    }

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('karyawan_id')
                ->relationship('karyawan', 'nama')
                ->searchable()
                ->required()
                ->label('Nama Karyawan'),

            DatePicker::make('tanggal_masuk')->required(),

            TimePicker::make('jam_masuk')->label('Jam Masuk'),
            TimePicker::make('jam_pulang')->label('Jam Pulang'),

            Select::make('status')
                ->options([
                    'hadir' => 'Hadir',
                    'izin' => 'Izin',
                    'sakit' => 'Sakit',
                    'cuti' => 'Cuti',
                ])
                ->required(),

            Textarea::make('lokasi')->rows(2),
            Textarea::make('catatan')->label('Catatan Tambahan')->rows(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('karyawan.nama')->label('Karyawan')->searchable(),
            TextColumn::make('tanggal_masuk')->date(),
            TextColumn::make('jam_masuk'),
            TextColumn::make('jam_pulang'),
            TextColumn::make('status')->badge()->color(fn (string $state) => match ($state) {
                'Hadir' => 'success',
                'Izin' => 'warning',
                'Sakit' => 'danger',
                'Cuti' => 'gray',
            }),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make()
        ])
        ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsensis::route('/'),
            'create' => Pages\CreateAbsensi::route('/create'),
            'edit' => Pages\EditAbsensi::route('/{record}/edit'),
            'scan' => Pages\ScanAbsensi::route('/scan'),
        ];
    }
}
