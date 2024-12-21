<?php
namespace App\Services;

class DateTimeHelper
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
}
