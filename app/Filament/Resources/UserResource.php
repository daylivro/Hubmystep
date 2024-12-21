<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Services\FilamentService;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $label = 'Utilisateurs';
    protected static ?string $pluralLabel = 'Utilisateurs';
    protected static ?string $navigationGroup = 'Challenges';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                TextColumn::make('created_at')->label('Date de création')->dateTime('d/m/Y'),
                TextColumn::make('name')->searchable()->label('Nom & Prénoms'),
                TextColumn::make('email')->searchable()->label('Email'),
                TextColumn::make('phone')->label('Contact')->searchable(),
                TextColumn::make('address')->label('Adresse')->searchable(),
                TextColumn::make('id')->label('Statut')->formatStateUsing(fn($record) => $record->desabled_at ? 'Desactive' : 'Actif')->badge()->color(fn($record) => $record->desabled_at ? 'danger' : 'success'),


            ])
            ->filters([
                FilamentService::filterBetween('created_at', 'created_from', 'created_until'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->tooltip('Voir')->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->label('')->tooltip('Editer')->icon('heroicon-o-pencil'),
                Action::make('change_action')->label('')
                    ->tooltip(fn($record) => $record->desabled_at ? 'Activer' : 'Desactiver')
                    ->color(fn($record) => $record->desabled_at ? 'success' : 'danger')
                    ->modalHeading(fn($record) => $record->desabled_at ? 'Activer' : 'Desactiver')
                    ->requiresConfirmation()
                    ->modalDescription(fn($record) => $record->desabled_at ? __('Voulez-vous activer ce compte ?') : __('Voulez-vous desactiver ce compte ?'))
                    ->action(fn($record) => $record->desabled_at ? $record->update(['desabled_at' => null]) : $record->update(['desabled_at' => now()]))
                    ->icon(fn($record) => $record->desabled_at ? 'heroicon-o-check-badge' : 'heroicon-o-x-circle'),
                Tables\Actions\DeleteAction::make()
                    ->label('')->tooltip('Supprimer')->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}')
        ];
    }
}
