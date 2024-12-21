<?php

namespace App\Filament\Resources\PartnerResource\Widgets;

use App\Models\AtOurPartner;
use Illuminate\Support\Facades\Route;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PartnerStats extends BaseWidget
{
    public $record;

    public function __construct($record = null)
    {
        $this->record = $record;
    }
    protected function getStats(): array
    {
        $visitors = AtOurPartner::where('partner_id', $this->record->id)->get();
        return [
            Stat::make('Visites', $visitors->count()),
            Stat::make('Visites effectuees', $visitors->where('done', true)->count()),
            Stat::make('Visites abandonnees', $visitors->where('done', false)->count()),
        ];
    }
}
