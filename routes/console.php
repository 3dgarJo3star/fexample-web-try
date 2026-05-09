<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('backup:run --only-db')
    ->dailyAt('02:00')
    ->name('backup-diario-db')
    ->withoutOverlapping();

Schedule::command('backup:clean')
    ->dailyAt('01:00')
    ->name('backup-limpieza');

Schedule::command('activitylog:clean --days=90')
    ->monthlyOn(1, '03:00')
    ->name('limpiar-historial-antiguo');
