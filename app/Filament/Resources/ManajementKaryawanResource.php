<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Traits\ShieldableResource;
use Filament\Forms\Components\Card;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\CheckboxList;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ManajementKaryawanResource\Pages;
use App\Filament\Resources\ManajementKaryawanResource\RelationManagers;
use App\Models\manajement\ManajementKaryawan as ManajementManajementKaryawan;

class ManajementKaryawanResource extends Resource
{
    use ShieldableResource;

    protected static ?string $model = ManajementManajementKaryawan::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function getSlug(): string
    {
        return 'manajement::karyawan';
    }

    protected static ?string $navigationGroup = 'Manajement Karyawan';

    protected static ?string $label = 'Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('kode_id')->required()->numeric()->placeholder('Masukan NIK karyawan...')->label('NIK'),
                    TextInput::make('nama')->required()->placeholder('Masukan nama karyawan...')->label('Nama'),
                    TextInput::make('email')->required()->placeholder('Masukan email karyawan...')->label('Email'),
                    TextInput::make('phone')->numeric()->placeholder('Masukan nomor Handphone karyawan...')->label('No. HP'),
                    DatePicker::make('tanggal_lahir')->label('Tanggal Lahir'),
                    DatePicker::make('tanggal_masuk')->label('Tanggal Masuk Kerja'),
                    Select::make('jenis_kelamin')->required()->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ])->columnSpanFull()->label('Jenis Kelamin'),
                    FileUpload::make('foto_karyawan')->disk('public')->directory('profile-karyawan')->required()->columnSpanFull()->label('Profile Karyawan'),
                    RichEditor::make('alamat')->placeholder('Masukan alamat karyawan...')->columnSpanFull()->label('Alamat'),
                ])
                ->columns(2),
                Card::make()
                ->schema([
                    Placeholder::make('Master Data Karyawan')
                        ->columnSpanFull(),
                    Card::make()
                        ->schema([
                            Select::make('departements')
                                ->label('Departemen')
                                ->relationship('departement', 'departement')
                                ->required()
                                ->searchable(),
                            Select::make('posisis') 
                                ->label('Posisi')
                                ->searchable()
                                ->relationship('posisis', 'posisi')
                                ->required(),                    
                        ])
                        ->columns(2),
                ])                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
           ->columns([
                ImageColumn::make('foto_karyawan')
                ->label('Profile')
                ->disk('public')
                ->toggleable(isToggledHiddenByDefault: true)
                ->getStateUsing(fn ($record) => $record->foto_karyawan ? asset('storage/' . $record->foto_karyawan) : null)
                ->circular()
                ->size(40),
                TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')->label('No. HP'),
                TextColumn::make('jenis_kelamin')->label('Gender'),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date('d M Y'),
                TextColumn::make('tanggal_masuk')->label('Tanggal Masuk')->date('d M Y'),
           ])
            ->filters([
                SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'Laki-laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Filter::make('tahun_masuk')
                    ->form([
                        Select::make('year')
                            ->label('Tahun Masuk Kerja')
                            ->options(
                                collect(range(1900, now()->year))
                                    ->mapWithKeys(fn ($year) => [$year => $year])
                                    ->toArray()
                            )
                    ])
                    ->indicateUsing(function (array $data): ?string {
                        return $data['year'] ? 'Tahun Masuk: ' . $data['year'] : null;
                    })
                    ->query(fn ($query, $data) =>
                        $query->when($data['year'], fn ($q) =>
                            $q->whereYear('tanggal_masuk', $data['year'])
                        )
                    )                
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([
            \Filament\Infolists\Components\Section::make('Detail Karyawan')
            ->schema([
                \Filament\Infolists\Components\Grid::make(2)
                ->schema([
                    TextEntry::make('kode_id')->label('NIK'),
                    TextEntry::make('nama')->label('Nama Lengkap'),
                    TextEntry::make('email')->label('Email'),
                    TextEntry::make('phone')->label('Nomor HandPhone'),
                    TextEntry::make('tanggal_lahir')->label('Tanggal Lahir'),
                    TextEntry::make('tanggal_masuk')->label('Tanggal Masuk'),
                    TextEntry::make('jenis_kelamin')->label('Jenis Kelamin'),
                    TextEntry::make('tanggal_masuk')->label('Tanggal Masuk'),
                    \Filament\Infolists\Components\Grid::make(1)
                    ->schema([
                    ImageEntry::make('foto_karyawan')
                    ->label('Foto Karyawan')
                    ->getStateUsing(fn ($record) => $record->foto_karyawan ? asset('storage/' . $record->foto_karyawan) : null)
                    ->height(120)
                    ->width(120)
                    ]),
                    \Filament\Infolists\Components\Grid::make(1)
                    ->schema([
                    TextEntry::make('alamat')->label('Alamat')->columnSpanFull()->html(),
                    ]),
                    TextEntry::make('departement.departement')->label('Departemen Karyawan'),
                    TextEntry::make('posisis.posisi')->label('Posisi Karyawan'),
                    TextEntry::make('created_at')->label('Dibuat_at'),
                    TextEntry::make('updated_at')->label('Diperbarui_at'),
                ]),
            ])
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListManajementKaryawans::route('/'),
            'create' => Pages\CreateManajementKaryawan::route('/create'),
            'edit' => Pages\EditManajementKaryawan::route('/{record}/edit'),
            'view' => Pages\ViewManajementKaryawan::route('/{record}/view'),
        ];
    }
}
