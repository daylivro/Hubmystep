<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\View;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Informations de l\'utilisateur';

    protected function getHeaderActions(): array
    {
        return [];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Tabs::make('Tabs')->tabs([
                Tabs\Tab::make('Information generale')->icon('heroicon-m-user')->schema([
                    Section::make()->schema([
                        TextEntry::make('created_at')->label('Date de création')->dateTime('d/m/Y'),
                        TextEntry::make('name')->label('Nom & Prénoms'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('address')->label('Adresse'),
                        TextEntry::make('id')->label('Miles')
                            ->formatStateUsing(function ($record) {
                                return $record->userMile->miles ?? 0;
                            })
                    ])->columns(2),

                    Section::make()->schema([
                        RepeatableEntry::make('rewards')->label('Recompenses')->schema([
                            TextEntry::make('created_at')
                                ->label('Type de recompense')
                                ->formatStateUsing(function ($record) {
                                    return $record->category->name;
                                }),
                            TextEntry::make('value')->label('Recompense'),
                        ])->columnSpanFull()->columns(2)
                    ])->columns(2),
                ]),
                Tabs\Tab::make('Challenges')->icon('heroicon-m-bookmark')->schema([
                    // ...
                    // retourner une vue personnalisé avec ViewEntry pour afficher les challenges de ce user
                    View::make('infolists.components.challenge-table'),
                ]),
                Tabs\Tab::make('Transactions')->icon('heroicon-m-credit-card')->schema([
                    // ...
                    // retourner une vue personnalisé avec ViewEntry pour afficher les transactions de ce user
                ])
            ])->columnSpanFull(),
        ]);
    }
}
