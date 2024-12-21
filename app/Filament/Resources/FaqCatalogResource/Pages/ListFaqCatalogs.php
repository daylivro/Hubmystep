<?php

namespace App\Filament\Resources\FaqCatalogResource\Pages;

use Filament\Actions;
use App\Filament\Traits\Actionable;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\FaqCatalogResource;

class ListFaqCatalogs extends ListRecords
{
    use Actionable;

    protected static string $resource = FaqCatalogResource::class;
    protected static ?string $title = 'Liste des catalogues de FAQ';

    protected function getHeaderActions(): array
    {
        return [
                self::create()
                ->form([
                    TextInput::make('title')->label('Libellé')->required()->placeholder(''),
                    Textarea::make('description')->label('Reponse')->required()
                ])
        ];
    }
}
