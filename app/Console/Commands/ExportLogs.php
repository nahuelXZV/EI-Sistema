<?php

namespace App\Console\Commands;

use App\Services\System\BitacoraService;
use App\Services\System\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Exporta registros de bitácora al inicio de cada mes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastMonthLogs = BitacoraService::getlastMonth();

        // Encabezado del archivo
        $contents = "Registro de Actividades del Mes Anterior\n";
        $contents .= "Fecha de Descarga: " . now()->format('d/m/Y') . "\n\n";
        $contents .= str_pad("ID", 5, ' ') . " | " . str_pad("Usuario", 20, ' ') . " | " . str_pad("Rol", 20, ' ') . " | " . str_pad("Tipo", 20, ' ') . " | " . str_pad("Acción", 20, ' ') . " | " . str_pad("Fecha/Hora", 20, ' ') . "\n";
        $contents .= str_repeat("-", 5) . " | " . str_repeat("-", 20) . " | " . str_repeat("-", 20) . " | " . str_repeat("-", 20) . " | " . str_repeat("-", 20) . " | " . str_repeat("-", 20) . "\n";

        // Lógica para escribir los registros en un archivo TXT
        foreach ($lastMonthLogs as $log) {
            $event = $this->event($log);
            $user = $log->nombre . ' ' . $log->apellido;
            $contents .= str_pad($log->activity_id, 5, ' ') . " | " . str_pad($user, 20, ' ') . " | " . str_pad($log->nombre_rol, 20, ' ') . " | " . str_pad($log->description, 20, ' ') . " | " . str_pad($event, 20, ' ') . " | " . str_pad($log->date, 20, ' ') . "\n";
        }

        // Almacenar el archivo
        $path = 'bitacora/' . now()->subMonth()->format('Y-m') . '/logs_' . now()->format('Y-m-d_H-i-s') . '.txt';
        Storage::disk('public')->put($path, $contents);

        $this->info('Archivo de registros de bitácora generado y descargado con éxito.');
    }

    private function event($log)
    {
        switch ($log->event) {
            case 'created':
                return 'Creado';
            case 'deleted':
                return 'Eliminado';
            case 'updated':
                return 'Actualizado';
            default:
                return $log->event;
        }
    }
}
