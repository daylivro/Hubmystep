<?php

namespace App\Filament\Resources\RewardCategoryResource\Pages;

use App\Filament\Resources\RewardCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRewardCategory extends EditRecord
{
    protected static string $resource = RewardCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
