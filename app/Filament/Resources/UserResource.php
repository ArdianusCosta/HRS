<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use App\Traits\ShieldableResource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;
use Filament\Forms\Components\Card;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class UserResource extends Resource
{
    use ShieldableResource;

    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Pengguna';

    protected static ?string $label = 'Pengguna';

    // public static function getSlug(): string
    // {
    //     return 'user';
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('Nama Pengguna')
                    ->maxLength(255)
                    ->placeholder('Masukan nama Pengguna...'),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('Email')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukan email Pengguna...'),
                Select::make('roles')
                    ->label('Peran')
                    ->relationship('roles','name')
                    ->placeholder('Pilih role Pengguna'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->label('Kata Sandi')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Masukan Kata Sandi Pengguna...'),
                ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Pengguna'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('Email'),
               TextColumn::make('roles.name')
                    ->label('Peran')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn ($state): string => Str::headline($state)),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
                    TextEntry::make('name')->label('Nama Pengguna'),
                    TextEntry::make('email')->label('Email'),
                    \Filament\Infolists\Components\Grid::make(1)
                    ->schema([
                    TextEntry::make('roles.name')->label('Peran'),
                    ]),
                    TextEntry::make('created_at')->label('Dibuat_at'),
                    TextEntry::make('updated_at')->label('Diperbarui_at'),
                ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUsers::route('/{record}/view'),
        ];
    }
}
