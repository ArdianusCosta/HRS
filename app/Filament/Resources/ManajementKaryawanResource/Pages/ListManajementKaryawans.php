<?php

namespace App\Filament\Resources\ManajementKaryawanResource\Pages;

use App\Filament\Resources\ManajementKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListManajementKaryawans extends ListRecords
{
    protected static string $resource = ManajementKaryawanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
