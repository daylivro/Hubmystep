<?php

namespace App\Filament\Resources\RewardCategoryResource\Pages;

use App\Filament\Resources\RewardCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRewardCategory extends ViewRecord
{
    protected static string $resource = RewardCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
