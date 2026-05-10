<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Client;
use App\Models\User;
use App\Models\Operator;
use App\Models\Crane;
use App\Models\Zone;
use App\Models\RentalOrder;
use App\Models\RentalOrderCost;
use App\Models\MaintenanceRecord;
use App\Models\CraneStatusLog;

// Clientes
$client2 = Client::firstOrCreate(
    ['email' => 'maria@norte.com'],
    [
        'company_name' => 'Constructora del Norte',
        'contact_name' => 'María López',
        'phone' => '8181234567',
        'address' => 'Av. Constitución 100',
        'rfc' => 'CNO980101ABC',
        'notes' => 'Cliente VIP con descuento del 10%'
    ]
);

$client3 = Client::firstOrCreate(
    ['email' => 'juan@modernas.com'],
    [
        'company_name' => 'Edificaciones Modernas',
        'contact_name' => 'Juan Pérez',
        'phone' => '3331234567',
        'address' => 'Calle 5 de Mayo 200',
        'rfc' => 'EDM950505XYZ'
    ]
);

$client4 = Client::firstOrCreate(
    ['email' => 'pedro@obras.com'],
    [
        'company_name' => 'Obras y Proyectos SA',
        'contact_name' => 'Pedro García',
        'phone' => '5551234567',
        'address' => 'Blvd. Independencia 300',
        'rfc' => 'OPR910202DEF',
        'notes' => 'Solicita factura inmediata'
    ]
);

echo "✓ Clientes creados\n";

// Usuarios tipo cliente
User::firstOrCreate(
    ['email' => 'maria@cliente.com'],
    [
        'name' => 'María López',
        'password' => bcrypt('password'),
        'role' => 'client',
        'client_id' => $client2->id,
        'phone' => '8181234567'
    ]
);

User::firstOrCreate(
    ['email' => 'juan@cliente.com'],
    [
        'name' => 'Juan Pérez',
        'password' => bcrypt('password'),
        'role' => 'client',
        'client_id' => $client3->id,
        'phone' => '3331234567'
    ]
);

echo "✓ Usuarios cliente creados\n";

// Operadores
$op2 = Operator::firstOrCreate(
    ['license_number' => 'GRU-2019-002'],
    [
        'user_id' => 1,
        'name' => 'Carlos Ramírez',
        'phone' => '6641234567',
        'is_active' => true
    ]
);

$op3 = Operator::firstOrCreate(
    ['license_number' => 'GRU-2020-003'],
    [
        'user_id' => 1,
        'name' => 'Roberto Sánchez',
        'phone' => '6642345678',
        'is_active' => true
    ]
);

$op4 = Operator::firstOrCreate(
    ['license_number' => 'GRU-2021-004'],
    [
        'user_id' => 1,
        'name' => 'Luis Martínez',
        'phone' => '6643456789',
        'is_active' => false
    ]
);

echo "✓ Operadores creados\n";

// Grúas
$crane2 = Crane::firstOrCreate(
    ['serial_number' => 'KOM-2020-001'],
    [
        'name' => 'Komatsu PC200',
    'brand' => 'Komatsu',
    'year' => 2020,
    'capacity_tons' => 20.00,
    'status' => 'available',
    'current_location' => 'Almacén Central',
    'diesel_level' => 85.50,
    'total_hours' => 1200.00,
    'last_maintenance_hours' => 1150.00,
    'is_active' => true,
    'notes' => 'Recién revisada'
    ]
);

$crane3 = Crane::firstOrCreate(
    ['serial_number' => 'VOL-2019-002'],
    [
        'name' => 'Volvo EC210',
        'brand' => 'Volvo',
        'year' => 2019,
        'capacity_tons' => 21.00,
        'status' => 'maintenance',
        'current_location' => 'Taller',
        'diesel_level' => 45.00,
        'total_hours' => 2500.00,
        'last_maintenance_hours' => 2300.00,
        'is_active' => true,
        'notes' => 'En mantenimiento preventivo'
    ]
);

$crane4 = Crane::firstOrCreate(
    ['serial_number' => 'HIT-2018-003'],
    [
        'name' => 'Hitachi ZX200',
        'brand' => 'Hitachi',
        'year' => 2018,
        'capacity_tons' => 20.50,
        'status' => 'working',
        'current_location' => 'Zona Industrial Norte',
        'diesel_level' => 25.00,
        'total_hours' => 3200.00,
        'last_maintenance_hours' => 3000.00,
        'is_active' => true,
        'notes' => 'Bajo en diesel, actualmente rentada'
    ]
);

$crane5 = Crane::firstOrCreate(
    ['serial_number' => 'CAT-2015-004'],
    [
        'name' => 'CAT 320D (Inactiva)',
        'brand' => 'Caterpillar',
        'year' => 2015,
        'capacity_tons' => 20.00,
        'status' => 'inactive',
        'current_location' => 'Almacén',
        'diesel_level' => 0.00,
        'total_hours' => 5000.00,
        'last_maintenance_hours' => 4500.00,
        'is_active' => false,
        'notes' => 'Fuera de servicio por falla en motor'
    ]
);

echo "✓ Grúas creadas\n";

// Limpiar datos anteriores para recrear con datos frescos
RentalOrderCost::query()->delete();
RentalOrder::query()->whereNotIn('id', [1])->delete();
MaintenanceRecord::query()->whereNotIn('id', [1])->delete();
CraneStatusLog::query()->whereNotIn('id', [1])->delete();

// Órdenes de renta
$order2 = RentalOrder::create([
    'crane_id' => $crane2->id,
    'operator_id' => $op2->id,
    'client_id' => $client2->id,
    'zone_id' => 2,
    'service_location' => 'Construcción Plaza Norte',
    'start_date' => now()->subDays(5)->format('Y-m-d'),
    'arrival_time' => '08:00:00',
    'start_time' => '08:30:00',
    'end_time' => '17:00:00',
    'departure_time' => '17:30:00',
    'status' => 'completed',
    'payment_method' => 'cash',
    'authorized_by_name' => 'Ing. López',
    'authorized_by_phone' => '8181111111',
    'client_signature' => true,
    'internal_notes' => 'Cliente muy satisfecho'
]);

$order3 = RentalOrder::create([
    'crane_id' => $crane3->id,
    'operator_id' => $op3->id,
    'client_id' => $client3->id,
    'zone_id' => 3,
    'service_location' => 'Obra Residencial Centro',
    'start_date' => now()->subDays(2)->format('Y-m-d'),
    'arrival_time' => '07:00:00',
    'start_time' => '07:30:00',
    'status' => 'pending',
    'payment_method' => 'cash',
    'authorized_by_name' => 'Arq. Pérez',
    'authorized_by_phone' => '3331111111',
    'client_signature' => false,
    'internal_notes' => 'Pendiente confirmación'
]);

$order4 = RentalOrder::create([
    'crane_id' => $crane4->id,
    'operator_id' => $op2->id,
    'client_id' => $client4->id,
    'zone_id' => 5,
    'service_location' => 'Parque Industrial',
    'start_date' => now()->format('Y-m-d'),
    'arrival_time' => '09:00:00',
    'start_time' => '09:30:00',
    'status' => 'active',
    'payment_method' => 'credit',
    'authorized_by_name' => 'Ing. García',
    'authorized_by_phone' => '5551111111',
    'client_signature' => true,
    'internal_notes' => 'En proceso'
]);

$order5 = RentalOrder::create([
    'crane_id' => $crane2->id,
    'operator_id' => $op3->id,
    'client_id' => $client2->id,
    'zone_id' => 1,
    'service_location' => 'Bodega Industrial',
    'start_date' => now()->addDays(3)->format('Y-m-d'),
    'arrival_time' => '10:00:00',
    'status' => 'cancelled',
    'payment_method' => 'credit',
    'authorized_by_name' => 'Ing. López',
    'authorized_by_phone' => '8181111111',
    'client_signature' => false,
    'internal_notes' => 'Cancelada por cliente'
]);

echo "✓ Órdenes de renta creadas\n";

// Costos de órdenes
RentalOrderCost::create([
    'rental_order_id' => $order2->id,
    'description' => 'Renta de grúa 8 horas',
    'amount' => 4500.00,
    'notes' => 'Tarifa estándar'
]);

RentalOrderCost::create([
    'rental_order_id' => $order2->id,
    'description' => 'Transporte ida y vuelta',
    'amount' => 800.00,
    'notes' => 'Distancia 50km'
]);

RentalOrderCost::create([
    'rental_order_id' => $order2->id,
    'description' => 'Tiempo extra (2 horas)',
    'amount' => 1200.00,
    'notes' => 'Sobrepasó horario'
]);

RentalOrderCost::create([
    'rental_order_id' => $order4->id,
    'description' => 'Renta de grúa 6 horas',
    'amount' => 3500.00
]);

RentalOrderCost::create([
    'rental_order_id' => $order4->id,
    'description' => 'Transporte',
    'amount' => 600.00
]);

echo "✓ Costos de órdenes creados\n";

// Mantenimientos
MaintenanceRecord::create([
    'crane_id' => $crane2->id,
    'type' => 'preventive',
    'hours_at_maintenance' => 1150.00,
    'next_maintenance_hours' => 1350.00,
    'scheduled_date' => now()->subDays(10)->format('Y-m-d'),
    'completed_date' => now()->subDays(8)->format('Y-m-d'),
    'description' => 'Cambio de aceite y filtros',
    'cost' => 2500.00,
    'status' => 'completed'
]);

MaintenanceRecord::create([
    'crane_id' => $crane3->id,
    'type' => 'preventive',
    'hours_at_maintenance' => 2300.00,
    'next_maintenance_hours' => 2500.00,
    'scheduled_date' => now()->format('Y-m-d'),
    'description' => 'Revisión general programada',
    'cost' => 3500.00,
    'status' => 'pending'
]);

MaintenanceRecord::create([
    'crane_id' => $crane4->id,
    'type' => 'inspection',
    'hours_at_maintenance' => 3000.00,
    'next_maintenance_hours' => 3200.00,
    'scheduled_date' => now()->addDays(15)->format('Y-m-d'),
    'description' => 'Inspección anual obligatoria',
    'status' => 'pending'
]);

MaintenanceRecord::create([
    'crane_id' => $crane5->id,
    'type' => 'corrective',
    'hours_at_maintenance' => 4500.00,
    'next_maintenance_hours' => 4700.00,
    'scheduled_date' => now()->subDays(30)->format('Y-m-d'),
    'description' => 'Reparación de motor',
    'cost' => 15000.00,
    'status' => 'completed'
]);

echo "✓ Mantenimientos creados\n";

// Bitácoras de estado
CraneStatusLog::create([
    'crane_id' => $crane2->id,
    'operator_id' => $op2->id,
    'is_on' => true,
    'is_working' => true,
    'location' => 'Construcción Plaza Norte',
    'diesel_level' => 90.00,
    'hours_reading' => 1180.00,
    'notes' => 'Operación normal',
    'logged_at' => now()->subDays(5)
]);

CraneStatusLog::create([
    'crane_id' => $crane3->id,
    'operator_id' => $op3->id,
    'is_on' => false,
    'is_working' => false,
    'location' => 'Taller',
    'diesel_level' => 45.00,
    'hours_reading' => 2500.00,
    'notes' => 'En mantenimiento',
    'logged_at' => now()->subDays(3)
]);

CraneStatusLog::create([
    'crane_id' => $crane4->id,
    'operator_id' => $op2->id,
    'is_on' => true,
    'is_working' => true,
    'location' => 'Parque Industrial',
    'diesel_level' => 25.00,
    'hours_reading' => 3205.00,
    'notes' => 'Necesita recarga de diesel pronto',
    'logged_at' => now()
]);

CraneStatusLog::create([
    'crane_id' => $crane2->id,
    'operator_id' => $op3->id,
    'is_on' => false,
    'is_working' => false,
    'location' => 'Almacén Central',
    'diesel_level' => 85.50,
    'hours_reading' => 1200.00,
    'notes' => 'Apagada en almacén',
    'logged_at' => now()->subHours(2)
]);

echo "✓ Bitácoras de estado creadas\n\n";
echo "========================================\n";
echo "RESUMEN DE DATOS CREADOS\n";
echo "========================================\n";
echo "Clientes: ".Client::count()."\n";
echo "Usuarios: ".User::count()."\n";
echo "Operadores: ".Operator::count()."\n";
echo "Grúas: ".Crane::count()."\n";
echo "Órdenes: ".RentalOrder::count()."\n";
echo "Costos: ".RentalOrderCost::count()."\n";
echo "Mantenimientos: ".MaintenanceRecord::count()."\n";
echo "Bitácoras: ".CraneStatusLog::count()."\n";
echo "========================================\n";
