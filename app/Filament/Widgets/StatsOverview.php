<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Partner;
use App\Models\Challenge;
use App\Models\ChallengeUser;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Utilisateurs', User::count())
            ->progressBarColor('success')
            ->iconBackgroundColor('success')
            ->chartColor('success')
            ->icon('heroicon-o-user-group')
            ->iconPosition('start')
            ->descriptionColor('success')
            ->iconColor('success'),
            Stat::make('Challenges', Challenge::count())
            ->iconColor('warning')
            ->iconPosition('start')
            ->iconBackgroundColor('warning')
                ->icon('heroicon-o-user-group'),
            Stat::make('Participation', ChallengeUser::count())
                ->iconColor('info')
                ->iconPosition('start')
                ->iconBackgroundColor('info')
                ->icon('heroicon-o-user-group'),
            Stat::make('Partenaires', Partner::count())
                ->iconColor('secondary')
                ->iconPosition('start')
                ->iconBackgroundColor('gray')
                ->icon('heroicon-o-shopping-bag'),
        ];
    }
}
