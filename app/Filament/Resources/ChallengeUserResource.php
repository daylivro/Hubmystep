<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ChallengeUser;
use Filament\Resources\Resource;
use App\Services\FilamentService;
use App\States\Challenge\Pending;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ChallengeUserResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Resources\ChallengeUserResource\RelationManagers;

class ChallengeUserResource extends Resource
{
    protected static ?string $model = ChallengeUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Challenges';
    protected static ?string $label = 'Participation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Date d\'inscripition')->dateTime('d/m/Y'),
                TextColumn::make('user.name')->label('Nom complet'),
                TextColumn::make('challenge.title')->label('Challenge'),
                TextColumn::make('challenge.number_of_parts')->label('Parts'),
                TextColumn::make('id')->label('Parts actuels')->formatStateUsing(fn($record) => $record->currentParts($record->user)),
                TextColumn::make('challenge_id')->label('Parts restants')->formatStateUsing(fn($record) => $record->remainingParts($record->user)),
                TextColumn::make('state')->label('Statut')->formatStateUsing(fn($record) => $record->state->description())
                    ->color(fn($record) => $record->state->color())
                    ->badge(),
            ])
            ->filters([
                SelectFilter::make('state')
                    ->label('Statut')
                    ->options([
                        "App\States\Challenge\Pending" => 'En attente de paiement',
                        "App\States\Challenge\Cancelled" => 'Annulé',
                        "App\States\Challenge\InProgress" => 'En cours',
                        "App\States\Challenge\Completed" => 'Terminé',
                    ]),
                    FilamentService::filterBetween('created_at', 'created_from', 'created_until')

            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->icon('heroicon-o-eye')->tooltip('Consulter'),
                // Tables\Actions\EditAction::make()->label('')->icon('heroicon-o-pencil')->tooltip('Editer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()->label('Exporter')
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChallengeUsers::route('/'),
            'create' => Pages\CreateChallengeUser::route('/create'),
            'view' => Pages\ViewChallengeUser::route('/{record}'),
            'edit' => Pages\EditChallengeUser::route('/{record}/edit'),
        ];
    }
}
