<?php

namespace App\Filament\Resources\FaqCatalogResource\Pages;

use App\Filament\Resources\FaqCatalogResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFaqCatalog extends ViewRecord
{
    protected static string $resource = FaqCatalogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
