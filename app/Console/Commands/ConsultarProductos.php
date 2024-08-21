<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ConsultaProducto;

class ConsultarProductos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consultar-productos {search : parametro de busqueda}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $search = $this->argument('search');

        $url = 'https://newsport.vtexcommercestable.com.br/api/catalog_system/pub/products/search/'.$search;

        $response = Http::get($url);

        $totalItems = 0;
        if ($response->successful()) {
            $statusCode = $response->status();
            if ($statusCode == 200) {
                $results = $response->json();
                $totalItems = count($results);
            } elseif ($statusCode == 206) {
                $results = $response->json();
                $resourcesHeader = $response->header('resources');
                if ($resourcesHeader) {
                    $total = explode('/', $resourcesHeader)[1] ?? null;
                    $totalItems = (int) $total; 
                }         
            } 
            } else {
                $this->error('Error al consultar la API. Code: ' . $response->status());
        }

        ConsultaProducto::updateOrCreate(
            ['nombre' => $search],
            ['resultados' => $totalItems]
        );

        $this->info('Busquedas realizadas:');
        $this->table(
            ['id', 'created_at', 'updated_at', 'nombre', 'resultados'],
            ConsultaProducto::orderBy('updated_at', 'desc')->get(['id', 'created_at', 'updated_at', 'nombre', 'resultados'])->toArray()
        );        
        
    }
}
