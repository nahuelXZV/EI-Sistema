<table>
    <thead>
        <tr>
            <th style="font-weight: bold; width: 25;">Honorifico</th>
            <th style="font-weight: bold; width: 50;">Nombre Completo</th>
            <th style="font-weight: bold; width: 25;">Cedula</th>
            <th style="font-weight: bold; width: 25;">Telefono</th>
            <th style="font-weight: bold; width: 50;">Correo</th>
            <th style="font-weight: bold; width: 25;">Deuda</th>
            @if ($hasdebt)
                <th style="font-weight: bold; width: 25;">Programas con deuda</th>
                <th style="font-weight: bold; width: 25;"> Total deudas</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($students as $student)
            <tr>
                <td>{{ $student->honorifico }}</td>
                <td>{{ $student->nombre . ' ' . $student->apellido }}</td>
                <td>{{ $student->cedula . ' ' . $student->expedicion }}</td>
                <td>{{ $student->telefono }}</td>
                <td>{{ $student->correo }}</td>
                <td>
                    @if ($student->tiene_deuda)
                        Con Deuda
                    @else
                        Sin Deuda
                    @endif
                </td>
                @if ($hasdebt)
                    <td>{{ $student->programas_con_deuda }}</td>
                    <td>{{ $student->total_deudas }}</td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
