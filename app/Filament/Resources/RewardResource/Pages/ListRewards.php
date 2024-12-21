<?php

namespace App\Filament\Resources\RewardResource\Pages;

use Filament\Actions;
use App\Models\RewardCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\RewardResource;

class ListRewards extends ListRecords
{
    use \App\Filament\Traits\Actionable;
    protected static string $resource = RewardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            self::create()->form([
                Select::make('reward_category_id')
                    ->label('Catégorie')
                    ->options(RewardCategory::pluck('name', 'id'))
                    ->required(),
                TextInput::make('value')
                    ->label('La valeur')
                    ->required(),
            ])
        ];
    }
}
