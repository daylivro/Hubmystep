<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use App\Filament\Resources\PartnerCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPartnerCategory extends EditRecord
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
