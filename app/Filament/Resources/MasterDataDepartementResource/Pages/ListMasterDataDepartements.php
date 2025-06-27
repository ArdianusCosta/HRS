<?php

namespace App\Filament\Resources\MasterDataDepartementResource\Pages;

use App\Filament\Resources\MasterDataDepartementResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterDataDepartements extends ListRecords
{
    protected static string $resource = MasterDataDepartementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
