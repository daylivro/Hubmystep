<?php

namespace App\Filament\Resources\ChallengeUserResource\Widgets;

use App\Models\ChallengeUser;
use App\States\Challenge\Pending;
use App\States\Challenge\Completed;
use App\States\Challenge\InProgress;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ChallengeUserStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Participants', ChallengeUser::count()),
            Stat::make('En attente', ChallengeUser::whereState('state', Pending::class)->count()),
            Stat::make('En cours', ChallengeUser::whereState('state', InProgress::class)->count()),
            Stat::make('Terminés', ChallengeUser::whereState('state', Completed::class)->count()),
        ];
    }
}
