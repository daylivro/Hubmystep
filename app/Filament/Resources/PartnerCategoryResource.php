<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\PartnerCategory;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PartnerCategoryResource\Pages;
use App\Filament\Resources\PartnerCategoryResource\RelationManagers;

class PartnerCategoryResource extends Resource
{
    protected static ?string $model = PartnerCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $label = 'Types partenaires';
    protected static ?string $navigationGroup = 'Configuration';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')->label('Date de création')->dateTime('d/m/Y'),
                ImageColumn::make('image')->label('Image'),
                TextColumn::make('name')->label('Nom')->searchable(),
                TextColumn::make('description')->label('Description')->wrap(),
                TextColumn::make('partners_count')->label('Partenaires'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->icon('heroicon-o-eye')->tooltip('Consulter'),
                Tables\Actions\EditAction::make()->label('')->icon('heroicon-o-pencil')->tooltip('Editer')->form([
                    Forms\Components\TextInput::make('name')->label('Nom')->required(),
                    Forms\Components\Textarea::make('description')->label('Description')->columnSpan(2),
                    FileUpload::make('image')->label('Image')->columnSpan(2),
                ]),
                Tables\Actions\DeleteAction::make()->label('')->icon('heroicon-o-trash')->tooltip('Supprimer'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withCount('partners')->latest();
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
            'index' => Pages\ListPartnerCategories::route('/'),
            // 'create' => Pages\CreatePartnerCategory::route('/create'),
            'view' => Pages\ViewPartnerCategory::route('/{record}'),
            // 'edit' => Pages\EditPartnerCategory::route('/{record}/edit'),
        ];
    }
}
