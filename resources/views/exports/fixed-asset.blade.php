<table>
    <thead>
        <tr>
            <th style="font-weight: bold; width: 25;">Codigo</th>
            <th style="font-weight: bold; width: 50;">Nombre</th>
            <th style="font-weight: bold; width: 25;">Tipo</th>
            <th style="font-weight: bold; width: 25;">Modelo</th>
            <th style="font-weight: bold; width: 50;">Cantidad</th>
            <th style="font-weight: bold; width: 25;">Estado</th>
            <th style="font-weight: bold; width: 25;">Descripcion</th>
            <th style="font-weight: bold; width: 25;">Area</th>
            <th style="font-weight: bold; width: 25;">Encargado</th>
            <th style="font-weight: bold; width: 25;">Unidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($fixedAssets as $fixedAsset)
            <tr>
                <td>{{ $fixedAsset->codigo }}</td>
                <td>{{ $fixedAsset->nombre }}</td>
                <td>{{ $fixedAsset->tipo }}</td>
                <td>{{ $fixedAsset->modelo }}</td>
                <td>{{ $fixedAsset->cantidad }}</td>
                <td>{{ $fixedAsset->estado }}</td>
                <td>{{ $fixedAsset->descripcion }}</td>
                <td>{{ $fixedAsset->area }}</td>
                <td>{{ $fixedAsset->name_user . ' ' . $fixedAsset->lastname_user }}</td>
                <td>{{ $fixedAsset->unidad }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
