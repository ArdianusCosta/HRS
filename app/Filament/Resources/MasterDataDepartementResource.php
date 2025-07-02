<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Traits\ShieldableResource;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Models\manajement\ManajementDepartement;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterDataDepartementResource\Pages;
use App\Filament\Resources\MasterDataDepartementResource\RelationManagers;

class MasterDataDepartementResource extends Resource
{
    use ShieldableResource;

    protected static ?string $model = ManajementDepartement::class;

    public static function getSlug(): string
    {
        return 'master::data::departement';
    }

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $label = 'Manajement Departement';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('departement')->placeholder('Masukan departement Karyawan...')->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('departement')->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListMasterDataDepartements::route('/'),
            'create' => Pages\CreateMasterDataDepartement::route('/create'),
            'edit' => Pages\EditMasterDataDepartement::route('/{record}/edit'),
        ];
    }
}   
