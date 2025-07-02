<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
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
                TextColumn::make('kode_id')->label('NIK')->searchable()->sortable()->toggleable(),
                TextColumn::make('nama')->label('Nama')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable(),
                TextColumn::make('phone')->label('No. HP'),
                TextColumn::make('jenis_kelamin')->label('Gender'),
                TextColumn::make('tanggal_lahir')->label('Tanggal Lahir')->date('d M Y'),
                TextColumn::make('tanggal_masuk')->label('Tanggal Masuk')->date('d M Y'),
                ImageColumn::make('foto_karyawan')->label('Foto')->disk('public'),
                TextColumn::make('alamat')->label('Alamat')->limit(30)->toggleable(true),
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
        ];
    }
}
