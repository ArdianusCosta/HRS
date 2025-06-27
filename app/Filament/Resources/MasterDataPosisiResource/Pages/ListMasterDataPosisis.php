<?php

namespace App\Filament\Resources\MasterDataPosisiResource\Pages;

use App\Filament\Resources\MasterDataPosisiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMasterDataPosisis extends ListRecords
{
    protected static string $resource = MasterDataPosisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
