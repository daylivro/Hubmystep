<?php

namespace App\Filament\Resources\PartnerCategoryResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PartnerCategoryResource;

class ListPartnerCategories extends ListRecords
{
    use \App\Filament\Traits\Actionable;

    protected static string $resource = PartnerCategoryResource::class;
    protected static ?string $title = 'Liste des catégories de partenaires';

    protected function getHeaderActions(): array
    {
        return [
                self::create()
                ->form([
                    TextInput::make('name')
                        ->label('Nom')
                        ->placeholder('Nom de la catégorie')
                        ->required(),
                    Textarea::make('description')
                        ->label('Description')
                        ->placeholder('Description de la catégorie')
                        ->required(),
                    FileUpload::make('image')->label('Icone')->required(),
                ])
        ];
    }
}
