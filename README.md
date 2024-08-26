Crear un comando Artisan que reciba un parámetro obligatorio.

Debe consultar a la API publica https://developers.vtex.com/docs/api-reference/search-api#get-/api/catalog_system/pub/products/search/-search- del host `newsport.vtexcommercestable.com.br`` usando el parámetro del comando como texto de búsqueda.

Luego debe almacenar el texto de búsqueda y la cantidad de resultados usando el modelo apropiado que hace juego con esta migración (solo se adjunta la parte relevante del código):

```PHP
class CreateConsultaProductosTable extends Migration
{
    public function up()
    {
        Schema::create('consulta_productos', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nombre');
            $table->integer('resultados');
        });
    }
}
```

Para finalizar debe mostrar en la consola una tabla con todas las búsquedas guardadas en la ddbb. Ejemplo:

```
+----+-----------------------------+-----------------------------+------------+------------+
| id | created_at                  | updated_at                  | nombre     | resultados |
+----+-----------------------------+-----------------------------+------------+------------+
| 1  | 2023-12-11T21:57:52.000000Z | 2023-12-11T21:57:52.000000Z | test       | 5          |
| 2  | 2023-12-11T22:00:10.000000Z | 2023-12-11T22:00:10.000000Z | tenis mesa | 0          |
+----+-----------------------------+-----------------------------+------------+------------+
