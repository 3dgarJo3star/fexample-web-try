<?php

namespace App\Filament\Widgets;

use App\Models\Crane;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MaintenanceAlertsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $cranes = Crane::where('is_active', true)->get();

        $overdue = $cranes->filter(fn ($c) => $c->needsMaintenance())->count();
        $approaching = $cranes->filter(fn ($c) => $c->approachingMaintenance())->count();
        $ok = $cranes->filter(fn ($c) => !$c->needsMaintenance() && !$c->approachingMaintenance())->count();

        return [
            Stat::make('Mantenimiento Vencido', $overdue)
                ->description('Superaron las 400 hrs sin mantenimiento')
                ->color($overdue > 0 ? 'danger' : 'success')
                ->icon('heroicon-o-exclamation-triangle'),

            Stat::make('Próximo Mantenimiento', $approaching)
                ->description('Entre 350-400 hrs desde último mantenimiento')
                ->color($approaching > 0 ? 'warning' : 'success')
                ->icon('heroicon-o-clock'),

            Stat::make('Operación Normal', $ok)
                ->description('Sin alerta de mantenimiento')
                ->color('success')
                ->icon('heroicon-o-shield-check'),
        ];
    }
}
