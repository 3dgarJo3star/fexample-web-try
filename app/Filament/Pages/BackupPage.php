<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-archive-box';

    protected string $view = 'filament.pages.backup-page';

    protected static ?string $navigationLabel = 'Respaldos';

    protected static ?string $title = 'Respaldos de Base de Datos';

    protected static ?int $navigationSort = 9;

    public static function getNavigationGroup(): string|null
    {
        return 'Configuración';
    }

    public function getBackupFiles(): array
    {
        $disk = Storage::disk('local');
        $appName = config('app.name', 'Laravel');
        $backupPath = $appName;

        if (!$disk->exists($backupPath)) {
            return [];
        }

        $files = collect($disk->files($backupPath))
            ->filter(fn ($file) => str_ends_with($file, '.zip'))
            ->map(function ($file) use ($disk) {
                return [
                    'name' => basename($file),
                    'path' => $file,
                    'size' => $this->formatBytes($disk->size($file)),
                    'date' => date('d/m/Y H:i', $disk->lastModified($file)),
                ];
            })
            ->sortByDesc('date')
            ->values()
            ->toArray();

        return $files;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('run_backup')
                ->label('Ejecutar Respaldo Ahora')
                ->icon('heroicon-o-play')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Ejecutar Respaldo Manual')
                ->modalDescription('Esto creará un respaldo de la base de datos ahora. Puede tomar unos segundos.')
                ->action(function () {
                    try {
                        Artisan::call('backup:run --only-db');
                        Notification::make()
                            ->title('Respaldo completado')
                            ->body('La base de datos fue respaldada exitosamente.')
                            ->success()
                            ->send();
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title('Error en el respaldo')
                            ->body($e->getMessage())
                            ->danger()
                            ->send();
                    }
                }),
        ];
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
