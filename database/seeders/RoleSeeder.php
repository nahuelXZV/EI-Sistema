<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        activity()->withoutLogs(function () {
            $admin = Role::create(['name' => 'Administrador']);
            $test1 = Role::create(['name' => 'Test 1']);
            $test2 = Role::create(['name' => 'Test 2']);

            //Permisos
            Permission::create(['name' => 'administrador', 'description' => 'Permiso de administrador', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'usuario.index', 'description' => 'Gestionar usuarios', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'roles.index', 'description' => 'Gestionar roles', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'area.index', 'description' => 'Gestionar areas', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'cargo.index', 'description' => 'Gestionar cargos', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'importar.index', 'description' => 'Permite importar datos', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'bitacora.index', 'description' => 'Gestionar la bitacora', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'soporte.index', 'description' => 'Permite editar las solicitudes', 'type' => 'Administrativo'])->syncRoles($admin);
            Permission::create(['name' => 'activos.index', 'description' => 'Permite gestionar los activos', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'recepcion.index', 'description' => 'Gestionar recepcion de documentos', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'movimiento.index', 'description' => 'Gestionar movimiento de la documentacion', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'contrataciones.index', 'description' => 'Gestionar contrataciones de docentes', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'administrativo.index', 'description' => 'Gestionar administrativos', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'contratacion.index', 'description' => 'Gestionar contratos de administrativos', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'marketing.index', 'description' => 'Gestionar clientes', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'documentos.index', 'description' => 'Gestionar documentos', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'inventario.index', 'description' => 'Gestionar inventario', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'tic.index', 'description' => 'Gestionar equipos TIC', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'solicitudes.index', 'description' => 'Gestionar solicitudes', 'type' => 'Administrativo'])->syncRoles($admin);
            // Permission::create(['name' => 'solicitudes.show', 'description' => 'Ver solicitudes', 'type' => 'Administrativo'])->syncRoles($admin);


            Permission::create(['name' => 'modulo.index', 'description' => 'Gestionar modulos', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'requisito.index', 'description' => 'Gestionar requisitos', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'estudiante.index', 'description' => 'Gestionar estudiantes', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'programa.index', 'description' => 'Gestionar programas', 'type' => 'Académico'])->syncRoles($admin);
            // Permission::create(['name' => 'eventos.index', 'description' => 'Gestionar eventos', 'type' => 'Académico'])->syncRoles($admin);
            // Permission::create(['name' => 'calendario.index', 'description' => 'Ver calendario de programas', 'type' => 'Académico'])->syncRoles($admin);
            // Permission::create(['name' => 'unidad.index', 'description' => 'Gestionar unidad organizacional', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'docentes.index', 'description' => 'Gestionar docentes', 'type' => 'Académico'])->syncRoles($admin);
            // Permission::create(['name' => 'directivos.index', 'description' => 'Gestionar directivos', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'procesos.index', 'description' => 'Gestionar procesos', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'universidad.index', 'description' => 'Gestionar universidades', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'carreras.index', 'description' => 'Gestionar carreras', 'type' => 'Académico'])->syncRoles($admin);
            Permission::create(['name' => 'cursos.index', 'description' => 'Gestionar cursos', 'type' => 'Académico'])->syncRoles($admin);


            Permission::create(['name' => 'descuento.index', 'description' => 'Gestionar descuentos', 'type' => 'Contabilidad'])->syncRoles($admin);
            Permission::create(['name' => 'tipo_pago.index', 'description' => 'Gestionar tipos de pagos', 'type' => 'Contabilidad'])->syncRoles($admin);
            Permission::create(['name' => 'pagos.index', 'description' => 'Gestionar pagos', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'servicio.index', 'description' => 'Gestionar servicios', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'partida.index', 'description' => 'Gestionar partidas', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'presupuesto.index', 'description' => 'Gestionar presupuesto', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'factura.index', 'description' => 'Gestionar facturas', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'sueldos.index', 'description' => 'Gestionar sueldos', 'type' => 'Contabilidad'])->syncRoles($admin);
            // Permission::create(['name' => 'detalle_factura.index', 'description' => 'Gestionar los detalles de las facturas', 'type' => 'Contabilidad'])->syncRoles($admin);
        });
    }
}
