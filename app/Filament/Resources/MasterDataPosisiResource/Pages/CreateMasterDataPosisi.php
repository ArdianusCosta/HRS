<?php

namespace App\Filament\Resources\MasterDataPosisiResource\Pages;

use App\Filament\Resources\MasterDataPosisiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterDataPosisi extends CreateRecord
{
    protected static string $resource = MasterDataPosisiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
