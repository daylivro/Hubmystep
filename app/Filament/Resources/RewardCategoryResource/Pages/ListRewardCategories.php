<?php

namespace App\Filament\Resources\RewardCategoryResource\Pages;

use Filament\Actions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\RewardCategoryResource;

class ListRewardCategories extends ListRecords
{
    protected static string $resource = RewardCategoryResource::class;
    protected static ?string $title = 'Catégories de récompenses';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nouveau')->icon('heroicon-o-plus-circle')
            ->form([
                TextInput::make('name')->label('Libellé')->required()->placeholder(''),
                Textarea::make('description')->label('Description')->placeholder(''),
            ])
        ];
    }
}
