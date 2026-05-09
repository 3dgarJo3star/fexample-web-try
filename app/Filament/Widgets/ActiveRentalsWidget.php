<?php

namespace App\Filament\Widgets;

use App\Enums\RentalOrderStatus;
use App\Models\RentalOrder;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ActiveRentalsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected function getStats(): array
    {
        $active = RentalOrder::where('status', RentalOrderStatus::Active)->count();
        $pending = RentalOrder::where('status', RentalOrderStatus::Pending)->count();
        $completedMonth = RentalOrder::where('status', RentalOrderStatus::Completed)
            ->whereMonth('start_date', now()->month)
            ->whereYear('start_date', now()->year)
            ->count();

        return [
            Stat::make('Órdenes Activas', $active)
                ->description('En operación ahora')
                ->color('warning')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Órdenes Pendientes', $pending)
                ->description('Por iniciar')
                ->color('info')
                ->icon('heroicon-o-clock'),

            Stat::make('Completadas este Mes', $completedMonth)
                ->description('Servicios terminados en ' . now()->locale('es')->monthName)
                ->color('success')
                ->icon('heroicon-o-check-badge'),
        ];
    }
}
