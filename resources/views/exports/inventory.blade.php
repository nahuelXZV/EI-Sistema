<table>
    <thead>
        <tr>
            <th style="font-weight: bold; width: 25;">Codigo Partida</th>
            <th style="font-weight: bold; width: 50;">Codigo Catalogo</th>
            <th style="font-weight: bold; width: 25;">Nombre</th>
            <th style="font-weight: bold; width: 25;">Descripcion</th>
            <th style="font-weight: bold; width: 50;">Tipo</th>
            <th style="font-weight: bold; width: 25;">Descripcion</th>
            <th style="font-weight: bold; width: 25;">Cantidad Contenedores</th>
            <th style="font-weight: bold; width: 25;">Unidad por contenedores</th>
            <th style="font-weight: bold; width: 25;">Total unidades</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($inventories as $inventory)
            <tr>
                <td>{{ $inventory->codigo_partida }}</td>
                <td>{{ $inventory->codigo_catalogo }}</td>
                <td>{{ $inventory->nombre }}</td>
                <td>{{ $inventory->descripcion }}</td>
                <td>{{ $inventory->tipo }}</td>
                <td>{{ $inventory->descripcion }}</td>
                <td>{{ $inventory->cantidad_contenedor }}</td>
                <td>{{ $inventory->unidades_contenedor }}</td>
                <td>{{ $inventory->total_unidades }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
