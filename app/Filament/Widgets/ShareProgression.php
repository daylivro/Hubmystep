<?php

namespace App\Filament\Widgets;

use App\Models\DailyShare;
use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class ShareProgression extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'shareProgression';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Evolution mensuelle des marches';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        $monthlyShares = DailyShare::select(DB::raw('DATE_FORMAT(date, "%Y-%m") as month'), DB::raw('SUM(shares) as total_shares'))->groupBy('month')->orderBy('month')->get();

        // Initialiser les données pour le graphique
        $sharesData = [];
        $monthsData = [];

        // Remplir les données
        foreach ($monthlyShares as $share) {
            $sharesData[] = $share->total_shares;
            $monthsData[] = $share->month; // On pourrait aussi utiliser une représentation plus lisible des mois
        }

        // Convertir les mois en format plus lisible (ex: "2024-09" -> "Sep 2024")
        $formattedMonths = array_map(function ($month) {
            return date('M Y', strtotime($month));
        }, $monthsData);

        // Préparer les données pour le graphique
        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'ShareProgression',
                    'data' => $sharesData, // Utiliser les données des shares
                ],
            ],
            'xaxis' => [
                'categories' => $formattedMonths, // Utiliser les mois formatés
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
