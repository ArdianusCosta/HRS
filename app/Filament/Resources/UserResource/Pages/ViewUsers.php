<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions\Action;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;

class ViewUsers extends ViewRecord
{
    protected static string $resource = UserResource::class;

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
