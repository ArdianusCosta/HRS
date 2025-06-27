<?php

namespace App\Filament\Resources\MasterDataDepartementResource\Pages;

use App\Filament\Resources\MasterDataDepartementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMasterDataDepartement extends EditRecord
{
    protected static string $resource = MasterDataDepartementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
