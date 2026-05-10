<x-filament-panels::page>
    <div class="space-y-6">
        <x-filament::section>
            <x-slot name="heading">Información del Respaldo Automático</x-slot>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Frecuencia</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">Diario a las 2:00 AM</p>
                </div>
                <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">Solo Base de Datos</p>
                </div>
                <div class="rounded-lg bg-gray-50 dark:bg-gray-900 p-4">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Ubicación</p>
                    <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">storage/app/{{ config('app.name') }}/</p>
                </div>
            </div>

            <x-filament::callout color="warning" icon="heroicon-o-exclamation-triangle" class="mt-4">
                Para que el respaldo automático funcione, el servidor debe tener configurado el cron de Laravel:
                <br>
                <code class="text-xs font-mono bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded mt-1 inline-block">
                    * * * * * cd /ruta-del-proyecto && php artisan schedule:run >> /dev/null 2>&1
                </code>
            </x-filament::callout>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Archivos de Respaldo</x-slot>
            <x-slot name="description">Respaldos almacenados en el servidor</x-slot>

            @php
                $backups = $this->getBackupFiles();
            @endphp

            @if(empty($backups))
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <x-filament::icon icon="heroicon-o-archive-box-x-mark" class="mx-auto h-12 w-12 opacity-50" />
                    <p class="mt-2 text-sm">No hay respaldos disponibles todavía.</p>
                    <p class="text-xs">Usa el botón "Ejecutar Respaldo Ahora" para crear el primero.</p>
                </div>
            @else
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Archivo</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Tamaño</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($backups as $backup)
                                <tr>
                                    <td class="px-4 py-3 text-sm font-mono text-gray-900 dark:text-white">{{ $backup['name'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $backup['size'] }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500 dark:text-gray-400">{{ $backup['date'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </x-filament::section>
    </div>
</x-filament-panels::page>
