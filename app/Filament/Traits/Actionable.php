<?php
namespace App\Filament\Traits;

use Filament\Actions;

trait Actionable
{
    /**
     * Create a new CreateAction instance.
     */
    public static function create()
    {
        return Actions\CreateAction::make()->label('Nouveau')->icon('heroicon-o-plus-circle');
    }


}
