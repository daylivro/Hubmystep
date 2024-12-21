<?php
namespace App\Services;

use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class FilamentService
{
    public static function apply($column, $period, $query)
    {
        switch ($period) {
            case 'today':
                return $query->whereDate($column, now());
            case 'yesterday':
                return $query->whereDate($column, now()->subDay());
            case 'last_7_days':
                return $query->whereBetween($column, [now()->subDays(7), now()]);
            case 'last_30_days':
                return $query->whereBetween($column, [now()->subDays(30), now()]);
            case 'this_month':
                return $query->whereMonth($column, now()->month);
            case 'last_month':
                return $query->whereMonth($column, now()->subMonth()->month);
        }
    }

    public static function filterBetween($column, $from, $to) : Filter
    {
        return Filter::make($column)
            ->form([DatePicker::make('created_from')->label('De'), DatePicker::make('created_until')->label('Jusqu\'à')])
            ->query(function (Builder $query, array $data) use ($from, $to, $column) {
                return $query->when($data[$from], fn(Builder $query, $date): Builder => $query->whereDate($column, '>=', $date))->when($data[$to], fn(Builder $query, $date): Builder => $query->whereDate($column, '<=', $date));
            });
    }
}
