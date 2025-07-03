<?php

namespace App\Filament\Resources\MenusResource\Pages;

use App\Filament\Resources\MenusResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMenus extends CreateRecord
{
    protected static string $resource = MenusResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
