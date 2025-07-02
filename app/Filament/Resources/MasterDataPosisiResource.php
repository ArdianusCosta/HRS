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
use App\Models\manajement\ManajementPosisi;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MasterDataPosisiResource\Pages;
use App\Filament\Resources\MasterDataPosisiResource\RelationManagers;

class MasterDataPosisiResource extends Resource
{
    use ShieldableResource;

    protected static ?string $model = ManajementPosisi::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getSlug(): string
    {
        return 'master::data::posisi';
    }

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $label = 'Manajement Posisi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    TextInput::make('posisi')->placeholder('Masukan posisi Karyawan...')->columnSpanFull(),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('posisi')->searchable(),
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
            'index' => Pages\ListMasterDataPosisis::route('/'),
            'create' => Pages\CreateMasterDataPosisi::route('/create'),
            'edit' => Pages\EditMasterDataPosisi::route('/{record}/edit'),
        ];
    }
}
