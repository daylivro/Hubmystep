<?php

namespace App\Filament\Resources\ChallengeUserResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\View;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\ChallengeUserResource;

class ViewChallengeUser extends ViewRecord
{
    protected static string $resource = ChallengeUserResource::class;
    protected static ?string $title = 'Utilisateurs d\'un Challenge';

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('Tabs')->tabs([
                Tabs\Tab::make('Participant du Challenge')->icon('heroicon-m-user')->schema([
                    Section::make()->schema([
                        TextEntry::make('created_at')->label('Date d\'inscripition au Challenge')->dateTime('d/m/Y'),
                        TextEntry::make('id')->label('Nom & Prénoms')
                            ->formatStateUsing(function ($record) {
                                return $record->user->name;
                            }),
                        TextEntry::make('id')->label('Email')
                            ->formatStateUsing(function ($record) {
                                return $record->user->email;
                            }),
                        TextEntry::make('id')->label('Miles')
                            ->formatStateUsing(function ($record) {
                                return $record->user->userMile->miles ?? 0;
                            }),
                    ])->columns(2),



                ]),
                Tabs\Tab::make('Informations du Challenge')->icon('heroicon-m-bookmark')->schema([
                    Section::make()->schema([
                        TextEntry::make('id')->label('Date debut du Challenge')
                            ->formatStateUsing(function ($record) {
                                return $record->start_at->format('d/m/Y');
                            }),
                            TextEntry::make('id')->label('Date debut du Challenge')
                            ->formatStateUsing(function ($record) {
                                return $record->start_at->addDay($record->duration)->format('d/m/Y');
                            }),
                        TextEntry::make('id')
                            ->formatStateUsing(function ($record) {
                                return $record->remainingDays($record->user);
                            })->label('Durée restante'),
                        TextEntry::make('id')->formatStateUsing(function ($record) {
                            return $record->currentParts($record->user);
                        })->label('Parts reussies'),
                        TextEntry::make('id')->formatStateUsing(function ($record) {
                            return $record->challenge->number_of_parts;
                        })->label('Parts totales'),
                        TextEntry::make('id')->formatStateUsing(function ($record) {
                            return $record->challenge->duration . ' jours';
                        })->label('Durée du Challenge'),
                        TextEntry::make('state')->formatStateUsing(function ($record) {
                           return $record->state->description();
                        })->badge()->color(fn($record) => $record->state->color())
                         ->label('Statut du Challenge'),
                        TextEntry::make('id')->formatStateUsing(function ($record) {
                            return $record->challenge->amount . ' Dirham';
                        })->label('Montant de participation'),
                    ])->columns(2),
                ]),

            ])->columnSpanFull(),
        ]);
    }
}
