<?php

namespace App\Filament\Resources\ChallengeUserResource\Pages;

use Filament\Actions;
use App\Models\ChallengeUser;
use App\Livewire\Tables\Challenge;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ChallengeUserResource;
use App\Filament\Resources\ChallengeUserResource\Widgets\ChallengeUserStats;

class ListChallengeUsers extends ListRecords
{
    protected static string $resource = ChallengeUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [ChallengeUserStats::class];
    }
}
