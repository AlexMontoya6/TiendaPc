<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearGeneratedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear {folder?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas las imágenes generadas en una carpeta específica.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Obtener el argumento opcional
        $folder = $this->argument('folder') ?? 'products';

        // Definir ruta del directorio a borrar
        $directory = $folder;

        // Verificar si el directorio existe
        if (Storage::disk('public')->exists($directory)) {
            // Obtener todos los archivos en el directorio
            $files = Storage::disk('public')->allFiles($directory);

            // Borrar todos los archivos
            Storage::disk('public')->delete($files);

            $this->info("Las imágenes en /storage/app/public/$directory han sido eliminadas.");
        } else {
            $this->info("El directorio /storage/app/public/$directory no existe.");
        }
    }
}

