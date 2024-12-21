<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RewardCategory;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RewardCategoryResource\Pages;
use App\Filament\Resources\RewardCategoryResource\RelationManagers;

class RewardCategoryResource extends Resource
{
    protected static ?string $model = RewardCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';
    protected static bool $softDelete = true;
    protected static ?string $label = 'Catégories recompenses';
    protected static ?string $navigationGroup = 'Configuration';

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
                TextColumn::make('created_at')->sortable()->searchable()->datetime('Y-m-d'),
                TextColumn::make('name')->sortable()->searchable()->label('Libelle'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->tooltip('Consulter'),
                Tables\Actions\EditAction::make()->label('')->tooltip('Editer'),
                Tables\Actions\DeleteAction::make()->label('')->tooltip('Supprimer'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRewardCategories::route('/'),
            // 'create' => Pages\CreateRewardCategory::route('/create'),
            'view' => Pages\ViewRewardCategory::route('/{record}'),
            'edit' => Pages\EditRewardCategory::route('/{record}/edit'),
        ];
    }
}
