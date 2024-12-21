<?php

namespace App\Filament\Resources\ChallengeResource\Pages;

use Filament\Actions;
use App\Models\RewardCategory;
use Filament\Infolists\Infolist;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ChallengeResource;
use Filament\Infolists\Components\RepeatableEntry;

class ViewChallenge extends ViewRecord
{
    protected static string $resource = ChallengeResource::class;
    protected static ?string $title = 'Details du Challenge';

    protected function getHeaderActions(): array
    {
        return [Actions\EditAction::make()];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('Tabs')
                ->tabs([
                    Tabs\Tab::make('Information du challenge')->schema([
                        Section::make()
                            ->schema([TextEntry::make('created_at')->label('Date de création')->dateTime('d/m/Y'), TextEntry::make('title')->label('Libellé'), TextEntry::make('amount')->label('Montant de participation'), TextEntry::make('duration')->label('Duree'), TextEntry::make('number_of_parts')->label('Nombre de parts'), TextEntry::make('description')->label('Description')])
                            ->columns(2),

                        Section::make()
                            ->schema([
                                RepeatableEntry::make('rewards')
                                    ->label('Recompenses')
                                    ->schema([
                                        TextEntry::make('created_at')
                                            ->label('Type de recompense')
                                            ->formatStateUsing(function ($record) {
                                                return $record->category->name;
                                            }),
                                        TextEntry::make('value')->label('Recompense'),
                                    ])
                                    ->columnSpanFull()
                                    ->columns(2),
                            ])
                            ->columns(2),
                    ]),
                    Tabs\Tab::make('Participation')->schema([
                        View::make('infolists.components.participation-table'),
                    ]),
                ])
                ->columnSpanFull(),
        ]);
    }
}
