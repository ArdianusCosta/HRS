<?php

namespace App\Filament\Resources\ManajementKaryawanResource\Pages;

use App\Filament\Resources\ManajementKaryawanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateManajementKaryawan extends CreateRecord
{
    protected static string $resource = ManajementKaryawanResource::class;

   protected function getRedirectUrl(): string
   {
    return $this->getResource()::getUrl('index');
   }
}
