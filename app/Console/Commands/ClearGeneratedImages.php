<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearGeneratedImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Elimina todas las imágenes generadas en el directorio public/products';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Ruta del directorio donde se almacenan las imágenes generadas
        $directory = storage_path('app/public/products');

        // Verificar si el directorio existe
        if (File::exists($directory)) {
            // Obtener todos los archivos en el directorio
            $files = File::allFiles($directory);

            // Borrar todos los archivos
            foreach ($files as $file) {
                File::delete($file);
            }

            $this->info('Las imágenes generadas han sido eliminadas.');
        } else {
            $this->info('El directorio de imágenes no existe.');
        }
    }
}
