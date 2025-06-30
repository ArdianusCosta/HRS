<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PengejuanCuti;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PengajuanCutiResource\Pages;
use App\Filament\Resources\PengajuanCutiResource\RelationManagers;

class PengajuanCutiResource extends Resource
{
    protected static ?string $model = PengejuanCuti::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                ->schema([
                    Select::make('jenis_type')
                        ->label('Jenis Cuti')
                        ->options([
                            'tahunan' => 'Cuti Tahunan',
                            'sakit' => 'Cuti Sakit',
                            'pribadi' => 'Izin Pribadi',
                        ])
                        ->required(),

                    DatePicker::make('mulai_hari')->required(),
                    DatePicker::make('akhir_hari')
                        ->afterOrEqual('mulai_hari')
                        ->required()
                        ->afterStateUpdated(function (callable $set, $state, $get) {
                            $start = \Carbon\Carbon::parse($get('mulai_hari'));
                            $end = \Carbon\Carbon::parse($state);
                            $total = $start->diffInDays($end) + 1;
                            $set('total_hari', $total);
                        }),
                    TextInput::make('total_hari')->disabled(),
                    Textarea::make('alasan')->label('Alasan'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('status')->badge()
                ->colors([
                    'primary' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                    Action::make('approve')
                    ->label('Setujui')
                    ->action(fn ($record) => $record->approve(auth()->user()))
                    ->visible(fn ($record) => $record->canBeApprovedBy(auth()->user())),

                    Action::make('reject')
                    ->label('Tolak')
                    ->action(fn ($record) => $record->reject(auth()->user()))
                    ->visible(fn ($record) => $record->canBeRejectedBy(auth()->user())),         
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
            'index' => Pages\ListPengajuanCutis::route('/'),
            'create' => Pages\CreatePengajuanCuti::route('/create'),
            'edit' => Pages\EditPengajuanCuti::route('/{record}/edit'),
            // 'approval' => \EightyNine\Approvals\Pages\ApprovalPage::route('/{record}/approval'),
        ];
    }
}
