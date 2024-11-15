<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1=Role::create(['name'=> 'GERENTE']);
        // $role1=Role::where('name', 'GERENTE')->first();

        Permission::create(['name'=>'user.index','description'=>'Ver la lista de Usuarios','categoria'=>'Usuario'])->assignRole($role1);
        Permission::create(['name'=>'user.show','description'=>'Ver Información de Usuarios','categoria'=>'Usuario'])->assignRole($role1);
        Permission::create(['name'=>'user.edit','description'=>'Editar Usuarios','categoria'=>'Usuario'])->assignRole($role1);
        Permission::create(['name'=>'user.destroy','description'=>'Cambiar de estado Usuarios','categoria'=>'Usuario'])->assignRole($role1);
        Permission::create(['name'=>'user.create','description'=>'Crear Usuarios','categoria'=>'Usuario'])->assignRole($role1);
        Permission::create(['name'=>'dashboard','description'=>'Ver el Dashboard','categoria'=>'Dashboard'])->assignRole($role1);
        Permission::create(['name'=>'role.index','description'=>'Ver la lista de Roles','categoria'=>'Roles'])->assignRole($role1);
        Permission::create(['name'=>'role.edit','description'=>'Editar Rol','categoria'=>'Roles'])->assignRole($role1);
        Permission::create(['name'=>'role.destroy','description'=>'Cambiar de estado Rol','categoria'=>'Roles'])->assignRole($role1);
        Permission::create(['name'=>'role.create','description'=>'Crear Rol','categoria'=>'Roles'])->assignRole($role1);
        Permission::create(['name'=>'hotel.index','description'=>'Ver la lista de Hoteles','categoria'=>'Hotel'])->assignRole($role1);
        Permission::create(['name'=>'hotel.create','description'=>'Crear Hotel','categoria'=>'Hotel'])->assignRole($role1);
        Permission::create(['name'=>'hotel.edit','description'=>'Editar Hotel','categoria'=>'Hotel'])->assignRole($role1);
        Permission::create(['name'=>'hotel.destroy','description'=>'Cambiar de estado del Hotel','categoria'=>'Hotel'])->assignRole($role1);
        Permission::create(['name'=>'pasajero.index','description'=>'Ver la lista de Pasajeros','categoria'=>'Pasajero'])->assignRole($role1);
        Permission::create(['name'=>'pasajero.create','description'=>'Crear Pasajero','categoria'=>'Pasajero'])->assignRole($role1);
        Permission::create(['name'=>'pasajero.edit','description'=>'Editar Pasajero','categoria'=>'Pasajero'])->assignRole($role1);
        Permission::create(['name'=>'medio.index','description'=>'Ver la lista de Medios de Pagos','categoria'=>'Medios'])->assignRole($role1);
        Permission::create(['name'=>'medio.create','description'=>'Crear Medio de Pago','categoria'=>'Medios'])->assignRole($role1);
        Permission::create(['name'=>'medio.edit','description'=>'Editar Medio de Pago','categoria'=>'Medios'])->assignRole($role1);
        Permission::create(['name'=>'medio.destroy','description'=>'Cambiar de estado de Medio de Pago','categoria'=>'Medios'])->assignRole($role1);
        Permission::create(['name'=>'guia.index','description'=>'Ver la lista de Guias','categoria'=>'Guia'])->assignRole($role1);
        Permission::create(['name'=>'guia.create','description'=>'Crear Guia','categoria'=>'Guia'])->assignRole($role1);
        Permission::create(['name'=>'guia.edit','description'=>'Editar Guia','categoria'=>'Guia'])->assignRole($role1);
        Permission::create(['name'=>'guia.destroy','description'=>'Cambiar de estado de Guia','categoria'=>'Guia'])->assignRole($role1);
        Permission::create(['name'=>'transporte.index','description'=>'Ver la lista de Tranportes','categoria'=>'Transporte'])->assignRole($role1);
        Permission::create(['name'=>'transporte.create','description'=>'Crear Transporte','categoria'=>'Transporte'])->assignRole($role1);
        Permission::create(['name'=>'transporte.edit','description'=>'Editar Transporte','categoria'=>'Transporte'])->assignRole($role1);
        Permission::create(['name'=>'transporte.destroy','description'=>'Cambiar de estado de Transporte','categoria'=>'Transporte'])->assignRole($role1);
        Permission::create(['name'=>'restaurante.index','description'=>'Ver la lista de Restaurantes','categoria'=>'Restaurant'])->assignRole($role1);
        Permission::create(['name'=>'restaurante.create','description'=>'Crear Restaurante','categoria'=>'Restaurant'])->assignRole($role1);
        Permission::create(['name'=>'restaurante.edit','description'=>'Editar Restaurante','categoria'=>'Restaurant'])->assignRole($role1);
        Permission::create(['name'=>'restaurante.destroy','description'=>'Cambiar de estado de Restaurante','categoria'=>'Restaurant'])->assignRole($role1);
        Permission::create(['name'=>'agencia.index','description'=>'Ver la lista de Agencias','categoria'=>'Agencia'])->assignRole($role1);
        Permission::create(['name'=>'agencia.create','description'=>'Crear Agencia','categoria'=>'Agencia'])->assignRole($role1);
        Permission::create(['name'=>'agencia.edit','description'=>'Editar Agencia','categoria'=>'Agencia'])->assignRole($role1);
        Permission::create(['name'=>'agencia.destroy','description'=>'Cambiar de estado de Agencia','categoria'=>'Agencia'])->assignRole($role1);
        Permission::create(['name'=>'proveedor.index','description'=>'Ver la lista de Proveedores','categoria'=>'Proveedor'])->assignRole($role1);
        Permission::create(['name'=>'proveedor.create','description'=>'Crear Proveedor','categoria'=>'Proveedor'])->assignRole($role1);
        Permission::create(['name'=>'proveedor.edit','description'=>'Editar Proveedor','categoria'=>'Proveedor'])->assignRole($role1);
        Permission::create(['name'=>'proveedor.destroy','description'=>'Cambiar de estado de Proveedor','categoria'=>'Proveedor'])->assignRole($role1);
        Permission::create(['name'=>'servicio.index','description'=>'Ver la lista de Servicios','categoria'=>'Servicios'])->assignRole($role1);
        Permission::create(['name'=>'servicio.create','description'=>'Crear Servicio','categoria'=>'Servicios'])->assignRole($role1);
        Permission::create(['name'=>'servicio.edit','description'=>'Editar Servicio','categoria'=>'Servicios'])->assignRole($role1);
        Permission::create(['name'=>'servicio.destroy','description'=>'Cambiar de estado de Servicio','categoria'=>'Servicios'])->assignRole($role1);
        Permission::create(['name'=>'tour.index','description'=>'Ver la lista de Tour','categoria'=>'Tour'])->assignRole($role1);
        Permission::create(['name'=>'tour.create','description'=>'Crear Tour','categoria'=>'Tour'])->assignRole($role1);
        Permission::create(['name'=>'tour.edit','description'=>'Editar Tour','categoria'=>'Tour'])->assignRole($role1);
        Permission::create(['name'=>'tour.destroy','description'=>'Cambiar de estado de Tour','categoria'=>'Tour'])->assignRole($role1);
        Permission::create(['name'=>'tour.show','description'=>'Ver información del Tour','categoria'=>'Tour'])->assignRole($role1);
        Permission::create(['name'=>'ubicacion.index','description'=>'Ver la lista de Ubicaciones','categoria'=>'Ubicacion'])->assignRole($role1);
        Permission::create(['name'=>'ubicacion.create','description'=>'Crear Ubicacion','categoria'=>'Ubicacion'])->assignRole($role1);
        Permission::create(['name'=>'ubicacion.edit','description'=>'Editar Ubicacion','categoria'=>'Ubicacion'])->assignRole($role1);
        Permission::create(['name'=>'categoria.index','description'=>'Ver la lista de Categorias','categoria'=>'Categoria'])->assignRole($role1);
        Permission::create(['name'=>'categoria.create','description'=>'Crear Categoria','categoria'=>'Categoria'])->assignRole($role1);
        Permission::create(['name'=>'categoria.edit','description'=>'Editar Categoria','categoria'=>'Categoria'])->assignRole($role1);
        Permission::create(['name'=>'reserva.index','description'=>'Listado de Reservas','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.create','description'=>'Crear Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.ver','description'=>'Ver Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.destroy','description'=>'Anular Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.edit','description'=>'Editar Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.ticket','description'=>'Descargar Ticket de Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.seguimiento','description'=>'Ver Seguimiento','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'reserva.pasajeros','description'=>'Ver todos los pasajeros de la Reserva','categoria'=>'Reserva'])->assignRole($role1);
        Permission::create(['name'=>'endoseinn.index','description'=>'Listado de Endose Inn','categoria'=>'Endose inn'])->assignRole($role1);
        Permission::create(['name'=>'endoseinn.create','description'=>'Crear Endose Inn','categoria'=>'Endose inn'])->assignRole($role1);
        Permission::create(['name'=>'endoseinn.ver','description'=>'Ver Endose Inn','categoria'=>'Endose inn'])->assignRole($role1);
        Permission::create(['name'=>'endoseinn.destroy','description'=>'Anular Endose Inn','categoria'=>'Endose inn'])->assignRole($role1);
        Permission::create(['name'=>'endoseinn.edit','description'=>'Editar Endose Inn','categoria'=>'Endose inn'])->assignRole($role1);
        Permission::create(['name'=>'endoseout.index','description'=>'Listado de Endose Out','categoria'=>'Endose out'])->assignRole($role1);
        Permission::create(['name'=>'endoseout.create','description'=>'Crear Endose Out','categoria'=>'Endose out'])->assignRole($role1);
        Permission::create(['name'=>'endoseout.ver','description'=>'Ver Endose Out','categoria'=>'Endose out'])->assignRole($role1);
        Permission::create(['name'=>'endoseout.destroy','description'=>'Anular Endose Out','categoria'=>'Endose out'])->assignRole($role1);
        Permission::create(['name'=>'endoseout.edit','description'=>'Editar Endose Out','categoria'=>'Endose out'])->assignRole($role1);
        Permission::create(['name'=>'operar.index','description'=>'Listado de Operaracion Tour','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.createtour','description'=>'Crear Operaracion Tour','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.servicio','description'=>'Listado de Operaracion Servicio','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.crearservicio','description'=>'Crear Operaracion de Servicio','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.ver','description'=>'Ver Operacion','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.destroy','description'=>'Anular Operacion','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.edit','description'=>'Editar Operacion','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'operar.showtour','description'=>'Realizar Show / No Show','categoria'=>'Operar'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.ingreso','description'=>'Listado de Liquidacion de ingreso','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.salida','description'=>'Listado de Liquidacion de egreso','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.ingresocreate','description'=>'Crear Liquidacion de ingreso','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.salidacreate','description'=>'Crear Liquidacion de egreso','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.ver','description'=>'Ver Liquidacion','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.edit','description'=>'Editar Liquidacion','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'liquidacion.destroy','description'=>'Liquidacion Anular','categoria'=>'Liquidacion'])->assignRole($role1);
        Permission::create(['name'=>'paquete.lista','description'=>'Listado de Paquetes','categoria'=>'Paquete'])->assignRole($role1);
        Permission::create(['name'=>'paquete.create','description'=>'Crear Paquete','categoria'=>'Paquete'])->assignRole($role1);
        Permission::create(['name'=>'paquete.edit','description'=>'Editar Paquete','categoria'=>'Paquete'])->assignRole($role1);
        Permission::create(['name'=>'paquete.destroy','description'=>'Anular Paquete','categoria'=>'Paquete'])->assignRole($role1);
        Permission::create(['name'=>'paquete.ver','description'=>'Ver detalles del Paquete','categoria'=>'Paquete'])->assignRole($role1);
        Permission::create(['name'=>'whatsapp.index','description'=>'Listado de Whatsapps','categoria'=>'Whatsapp'])->assignRole($role1);
        Permission::create(['name'=>'whatsapp.create','description'=>'Crear Whatsapp','categoria'=>'Whatsapp'])->assignRole($role1);
        Permission::create(['name'=>'whatsapp.edit','description'=>'Editar Whatsapp','categoria'=>'Whatsapp'])->assignRole($role1);
        Permission::create(['name'=>'whatsapp.destroy','description'=>'Anular Whatsapp','categoria'=>'Whatsapp'])->assignRole($role1);
        Permission::create(['name'=>'language.index','description'=>'Listado de Idiomas','categoria'=>'Idioma'])->assignRole($role1);
        Permission::create(['name'=>'language.create','description'=>'Crear Idioma','categoria'=>'Idioma'])->assignRole($role1);
        Permission::create(['name'=>'language.edit','description'=>'Editar Idioma','categoria'=>'Idioma'])->assignRole($role1);
        Permission::create(['name'=>'language.destroy','description'=>'Anular Idioma','categoria'=>'Idioma'])->assignRole($role1);
        Permission::create(['name'=>'comentario.index','description'=>'Listado de Comentarios','categoria'=>'Comentario'])->assignRole($role1);
        Permission::create(['name'=>'comentario.destroy','description'=>'Aceptar Comentario','categoria'=>'Comentario'])->assignRole($role1);
        Permission::create(['name'=>'paqueteweb.index','description'=>'Listado de Paquetes Web','categoria'=>'Paquete web'])->assignRole($role1);
        Permission::create(['name'=>'paqueteweb.create','description'=>'Crear Paquete Web','categoria'=>'Paquete web'])->assignRole($role1);
        Permission::create(['name'=>'paqueteweb.edit','description'=>'Editar Paquete Web','categoria'=>'Paquete web'])->assignRole($role1);
        Permission::create(['name'=>'paqueteweb.destroy','description'=>'Camibar estado Paquete Web','categoria'=>'Paquete web'])->assignRole($role1);
        Permission::create(['name'=>'menu.index','description'=>'Ver la lista de Menus','categoria'=>'Menu'])->assignRole($role1);
        Permission::create(['name'=>'menu.create','description'=>'Crear Menu','categoria'=>'Menu'])->assignRole($role1);
        Permission::create(['name'=>'menu.edit','description'=>'Editar Menu','categoria'=>'Menu'])->assignRole($role1);
        Permission::create(['name'=>'menu.destroy','description'=>'Cambiar de estado de Menu','categoria'=>'Menu'])->assignRole($role1);
        Permission::create(['name'=>'blog.index','description'=>'Ver la lista de Blogs','categoria'=>'Blog'])->assignRole($role1);
        Permission::create(['name'=>'blog.create','description'=>'Crear Blog','categoria'=>'Blog'])->assignRole($role1);
        Permission::create(['name'=>'blog.edit','description'=>'Editar Blog','categoria'=>'Blog'])->assignRole($role1);
        Permission::create(['name'=>'blog.destroy','description'=>'Cambiar de estado de Blog','categoria'=>'Blog'])->assignRole($role1);
    }
}
