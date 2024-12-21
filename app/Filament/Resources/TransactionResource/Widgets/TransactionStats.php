<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TransactionStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Transactions', Transaction::count()),
            Stat::make('En attente', Transaction::whereState('state', 'pending')->count()),
            Stat::make('En cours', Transaction::whereState('state', 'complete')->count()),
        ];
    }
}
