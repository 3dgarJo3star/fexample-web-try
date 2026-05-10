<?php

namespace App\Filament\Widgets;

use App\Enums\CraneStatus;
use App\Models\Crane;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CraneFleetWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $total = Crane::where('is_active', true)->count();
        $available = Crane::where('status', CraneStatus::Available)->count();
        $working = Crane::where('status', CraneStatus::Working)->count();
        $maintenance = Crane::where('status', CraneStatus::Maintenance)->count();

        return [
            Stat::make('Grúas Totales', $total)
                ->description('Grúas activas en flota')
                ->color('info')
                ->icon('heroicon-o-wrench-screwdriver'),

            Stat::make('Disponibles', $available)
                ->description('Listas para operar')
                ->color('success')
                ->icon('heroicon-o-check-circle'),

            Stat::make('En Operación', $working)
                ->description('Trabajando actualmente')
                ->color('warning')
                ->icon('heroicon-o-cog-6-tooth'),

            Stat::make('En Mantenimiento', $maintenance)
                ->description('Fuera de servicio')
                ->color('danger')
                ->icon('heroicon-o-wrench'),
        ];
    }
}
