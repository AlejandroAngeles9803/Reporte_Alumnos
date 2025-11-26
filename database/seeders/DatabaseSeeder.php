<?php

namespace Database\Seeders;

use App\Models\Grupo;
use App\Models\Alumno;
use App\Models\Reporte;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Limpiar tablas
        Reporte::query()->delete();
        Alumno::query()->delete();
        Grupo::query()->delete();
        User::query()->delete();

        $this->command->info('🎯 Creando administradores...');

        // Crear administradores
        User::create([
            'name' => 'Administrador Mañana',
            'email' => 'manana@escuela.com',
            'password' => Hash::make('password123'),
            'turno' => 'mañana',
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Administrador Tarde', 
            'email' => 'tarde@escuela.com',
            'password' => Hash::make('password123'),
            'turno' => 'tarde',
            'role' => 'admin'
        ]);

        $this->command->info('👥 Creando grupos...');

        // Crear grupos
        $gruposData = [
            ['nombre' => '1A', 'turno' => 'mañana'],
            ['nombre' => '2A', 'turno' => 'mañana'],
            ['nombre' => '3A', 'turno' => 'mañana'],
            ['nombre' => '1B', 'turno' => 'tarde'],
            ['nombre' => '2B', 'turno' => 'tarde'],
            ['nombre' => '3B', 'turno' => 'tarde'],
        ];

        foreach ($gruposData as $grupoData) {
            Grupo::create($grupoData);
        }

        $this->command->info('👨‍🎓 Creando alumnos y usuarios alumnos...');

        // Crear alumnos y sus usuarios
        $alumnosData = [
            // Turno mañana - Grupo 1A
            ['nombre' => 'Juan Pérez Hernández', 'matricula' => '2024001', 'grupo_id' => 1, 'turno' => 'mañana'],
            ['nombre' => 'María García López', 'matricula' => '2024002', 'grupo_id' => 1, 'turno' => 'mañana'],
            ['nombre' => 'Carlos Rodríguez Martínez', 'matricula' => '2024003', 'grupo_id' => 1, 'turno' => 'mañana'],
            
            // Turno mañana - Grupo 2A
            ['nombre' => 'Ana Martínez Sánchez', 'matricula' => '2024004', 'grupo_id' => 2, 'turno' => 'mañana'],
            ['nombre' => 'Roberto Jiménez Díaz', 'matricula' => '2024005', 'grupo_id' => 2, 'turno' => 'mañana'],
            
            // Turno tarde - Grupo 1B
            ['nombre' => 'Pedro Ramírez Torres', 'matricula' => '2024006', 'grupo_id' => 4, 'turno' => 'tarde'],
            ['nombre' => 'Lucía Herrera Flores', 'matricula' => '2024007', 'grupo_id' => 4, 'turno' => 'tarde'],
            ['nombre' => 'Diego Ortega Cruz', 'matricula' => '2024008', 'grupo_id' => 4, 'turno' => 'tarde'],
            
            // Turno tarde - Grupo 2B
            ['nombre' => 'Elena Vargas Mora', 'matricula' => '2024009', 'grupo_id' => 5, 'turno' => 'tarde'],
            ['nombre' => 'Javier Ríos Paredes', 'matricula' => '2024010', 'grupo_id' => 5, 'turno' => 'tarde'],
        ];

        foreach ($alumnosData as $alumnoData) {
            $alumno = Alumno::create($alumnoData);
            
            // Crear usuario para el alumno
            User::create([
                'name' => $alumnoData['nombre'],
                'email' => $alumnoData['matricula'] . '@escuela.com',
                'password' => Hash::make('password123'),
                'turno' => $alumnoData['turno'],
                'role' => 'alumno'
            ]);
        }

        $this->command->info('📊 Creando reportes de ejemplo...');

        // Crear reportes de ejemplo
        $reportesData = [
            // Reportes turno mañana
            ['alumno_id' => 1, 'tipo' => 'credencial', 'descripcion' => 'No portaba la credencial escolar', 'horas_sentencia' => 2, 'fecha_reporte' => now()->subDays(5)],
            ['alumno_id' => 2, 'tipo' => 'uniforme', 'descripcion' => 'Uniforme incompleto - sin corbata', 'horas_sentencia' => 1, 'fecha_reporte' => now()->subDays(3)],
            ['alumno_id' => 4, 'tipo' => 'cabello', 'descripcion' => 'Corte de cabello no reglamentario', 'horas_sentencia' => 3, 'fecha_reporte' => now()->subDays(2)],
            
            // Reportes turno tarde
            ['alumno_id' => 6, 'tipo' => 'uniforme', 'descripcion' => 'Sin playera oficial', 'horas_sentencia' => 1, 'fecha_reporte' => now()->subDays(4)],
            ['alumno_id' => 7, 'tipo' => 'cabello', 'descripcion' => 'Tinte no permitido', 'horas_sentencia' => 3, 'fecha_reporte' => now()->subDays(2)],
            ['alumno_id' => 9, 'tipo' => 'credencial', 'descripcion' => 'Credencial en mal estado', 'horas_sentencia' => 2, 'fecha_reporte' => now()->subDays(1)],
        ];

        foreach ($reportesData as $reporteData) {
            Reporte::create($reporteData);
        }

        $this->command->info('✅ ¡Base de datos poblada exitosamente!');
        $this->command->info('');
        $this->command->info('🔐 CREDENCIALES DE ACCESO:');
        $this->command->info('   👨‍💼 ADMINISTRADORES:');
        $this->command->info('      🌅 Turno Mañana: manana@escuela.com / password123');
        $this->command->info('      🌇 Turno Tarde:  tarde@escuela.com  / password123');
        $this->command->info('');
        $this->command->info('   👨‍🎓 ALUMNOS:');
        $this->command->info('      👨‍🎓 Juan Pérez: 2024001@escuela.com / password123');
        $this->command->info('      👩‍🎓 María García: 2024002@escuela.com / password123');
        $this->command->info('      👨‍🎓 Carlos Rodríguez: 2024003@escuela.com / password123');
        $this->command->info('');
        $this->command->info('📈 ESTADÍSTICAS CREADAS:');
        $this->command->info('   👤 Usuarios: ' . User::count());
        $this->command->info('   👥 Grupos: ' . Grupo::count());
        $this->command->info('   👨‍🎓 Alumnos: ' . Alumno::count());
        $this->command->info('   📝 Reportes: ' . Reporte::count());
    }
}