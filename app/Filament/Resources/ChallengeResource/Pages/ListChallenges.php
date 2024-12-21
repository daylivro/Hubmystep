<?php

namespace App\Filament\Resources\ChallengeResource\Pages;

use App\Filament\Resources\ChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\TextInput;

class ListChallenges extends ListRecords
{
    use \App\Filament\Traits\Actionable;

    protected static string $resource = ChallengeResource::class;
    protected static ?string $title = 'Liste des challenges';

    protected function getHeaderActions(): array
    {
        return [
            self::create()
        ];
    }
}
