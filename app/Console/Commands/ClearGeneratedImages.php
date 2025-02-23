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
        $folder = $this->argument('folder') ?? 'products';

        $directory = $folder;

        if (Storage::disk('public')->exists($directory)) {

            $files = Storage::disk('public')->allFiles($directory);

            Storage::disk('public')->delete($files);

            $this->info("Las imágenes en /storage/app/public/$directory han sido eliminadas.");
        } else {
            $this->info("El directorio /storage/app/public/$directory no existe.");
        }
    }
}
