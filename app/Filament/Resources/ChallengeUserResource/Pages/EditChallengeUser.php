<?php

namespace App\Filament\Resources\ChallengeUserResource\Pages;

use App\Filament\Resources\ChallengeUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChallengeUser extends EditRecord
{
    protected static string $resource = ChallengeUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
