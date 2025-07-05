<?php

namespace App\Filament\Resources\ManajementKaryawanResource\Pages;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Resources\ManajementKaryawanResource;

class ViewManajementKaryawan extends ViewRecord
{
    protected static string $resource = ManajementKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('gray')
                ->icon('heroicon-m-arrow-left')
                ->url($this->getResource()::getUrl('index'))
        ];
    }
}
