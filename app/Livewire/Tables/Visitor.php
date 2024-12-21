<?php

namespace App\Livewire\Tables;

use Livewire\Component;
use Filament\Tables\Table;
use App\Models\AtOurPartner;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class Visitor extends Component implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;
    public $partner;

    public function table(Table $table): Table
    {
        return $table
            ->query(AtOurPartner::query()->where('partner_id', $this->partner->id)->latest()->with('user'))
            ->columns([
                TextColumn::make('created_at')->searchable()->sortable()->dateTime('d/m/Y')->label('Date de visite'),
                TextColumn::make('user.name')->searchable()->sortable()->label('Nom complet'),
                TextColumn::make('user.email')->searchable()->sortable()->label('Email'),
                TextColumn::make('done')
                    ->badge()
                    ->color(fn($record) => $record->done ? 'success' : 'danger')
                    ->label('Visite effectuée ?')->formatStateUsing(fn($record) => $record->done ? 'Oui' : 'Non'),

            ]);
    }
    public function render()
    {
        return view('livewire.tables.visitor');
    }
}
