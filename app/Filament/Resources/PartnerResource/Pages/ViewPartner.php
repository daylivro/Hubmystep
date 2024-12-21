<?php

namespace App\Filament\Resources\PartnerResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use App\Filament\Resources\PartnerResource;
use App\Filament\Resources\PartnerResource\Widgets\PartnerStats;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Infolists\Components\TextEntry;

class ViewPartner extends ViewRecord
{
    protected static string $resource = PartnerResource::class;
    protected static ?string $title = 'Details du partenaire';

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function getHeaderWidgets(): array
    {
        return [PartnerStats::class];
    }


    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Informations generales')
                        ->icon('heroicon-m-building-library')
                        ->schema([
                            Section::make()
                                ->schema([
                                    TextEntry::make('created_at')->label('Date de creation')->dateTime('d/m/Y'),
                                    TextEntry::make('name')->label('Nom'),
                                    TextEntry::make('email')->label('Email'),
                                    TextEntry::make('phone')->label('Telephone'),
                                ])
                                ->columns(2),
                        ]),
                        Tab::make('Historique des visites')->icon('heroicon-m-user-group')->schema([
                            View::make('infolists.components.visitor-entry'),
                        ]),
                        Tab::make('Historiques des gains')->icon('heroicon-m-banknotes')->schema([
                            // View::make('infolists.components.participation-table'),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }
}
