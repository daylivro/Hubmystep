<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\FaqCatalog;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\FaqCatalogResource\Pages;
use App\Filament\Resources\FaqCatalogResource\RelationManagers;

class FaqCatalogResource extends Resource
{
    protected static ?string $model = FaqCatalog::class;

    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static bool $softDelete = true;
    protected static ?string $singularLabel = 'Faq';
    protected static ?string $pluralLabel = 'Faqs';
    protected static ?string $navigationGroup = 'Challenges';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')->sortable()->searchable()->datetime('Y-m-d')->label('Date de création'),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('description')->searchable()->wrap(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('')->icon('heroicon-o-eye'),
                Tables\Actions\EditAction::make()->label('')->icon('heroicon-o-pencil')
                    ->form([
                        TextInput::make('title')->label('Libellé')->required()->placeholder(''),
                        Textarea::make('description')->label('Reponse')->required()
                    ]),
                Tables\Actions\DeleteAction::make()->label('')->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFaqCatalogs::route('/'),
            'view' => Pages\ViewFaqCatalog::route('/{record}'),
            // 'edit' => Pages\EditFaqCatalog::route('/{record}/edit'),
        ];
    }
}
