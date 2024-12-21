<?php

namespace App\Filament\Resources\FaqCatalogResource\Pages;

use App\Filament\Resources\FaqCatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFaqCatalog extends EditRecord
{
    protected static string $resource = FaqCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
