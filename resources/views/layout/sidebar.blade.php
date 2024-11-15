<nav class="sidebar">
  <div class="sidebar-header">
    <a href="/" class="sidebar-brand">
      <img  style="height: 2.8rem;" src="{{asset('img/logo.png')}}" alt="logo">
    </a>
    <div class="sidebar-toggler not-active">
      <span></span>
      <span></span>
      <span></span>
    </div>
  </div>
  <div class="sidebar-body">
    <ul class="nav">
      <li class="nav-item nav-category">Menu</li>
      <li class="nav-item {{ active_class(['dashboard']) }}">
        @can('dashboard')
        <a href="{{ url('dashboard') }}" class="nav-link">
          <i class="link-icon" data-feather="activity"></i>
          <span class="link-title">Dashboard</span>
        </a>
        @endcan
      </li>
      <li class="nav-item {{ active_class(['user','user/*']) }}">
        @can('user.index')
        <a href="{{url('user') }}" class="nav-link">
          <i class="link-icon " data-feather="users"></i>
          <span class="link-title">Usuarios</span>
        </a>
        @endcan
      </li>
      <li class="nav-item {{ active_class(['roles','roles/*']) }}">
        @can('role.index')
        <a href="{{url('roles') }}" class="nav-link">
          <i  class="link-icon mdi mdi-account-key" ></i>
          <span class="link-title">Roles</span>
        </a>
        @endcan
      </li>
      @if( Gate::check('reserva.index') || Gate::check('reserva.create') || Gate::check('reserva.seguimiento'))
      <li class="nav-item {{ active_class(['reserva/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#reserva" role="button" aria-expanded="{{ is_active_route(['reserva/*']) }}" aria-controls="reserva">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Reservas</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['reserva/*']) }}" id="reserva">
          <ul class="nav sub-menu">
            @can('reserva.index')
            <li class="nav-item">
              <a href="{{ url('reserva/lista') }}" class="nav-link {{ active_class(['reserva/lista']) }}">Lista</a>
            </li>
            @endcan
            @can('reserva.create')
            <li class="nav-item">
              <a href="{{ url('reserva/crear') }}" class="nav-link {{ active_class(['reserva/crear']) }}">Crear</a>
            </li>
            @endcan
            @can('reserva.seguimiento')
            <li class="nav-item">
              <a href="{{ url('reserva/seguimiento') }}" class="nav-link {{ active_class(['reserva/seguimiento']) }}">Seguimiento</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      <li class="nav-item {{ active_class(['endoseinn','endoseinn/*']) }}">
        @can('endoseinn.index')
        <a href="{{url('endoseinn') }}" class="nav-link">
          <i class="link-icon" data-feather="briefcase"></i>
          <span class="link-title">Endose inn</span>
        </a>
        @endcan
      </li>
      <li class="nav-item {{ active_class(['endoseout','endoseout/*']) }}">
        @can('endoseout.index')
        <a href="{{url('endoseout') }}" class="nav-link">
          <i class="link-icon" data-feather="check-circle"></i>
          <span class="link-title">Endose Out</span>
        </a>
        @endcan
      </li>
      @if( Gate::check('operar.index') || Gate::check('operar.create') )
      <li class="nav-item {{ active_class(['operar/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#operar" role="button" aria-expanded="{{ is_active_route(['operar/*']) }}" aria-controls="operar">
          <i class="link-icon" data-feather="calendar"></i>
          <span class="link-title">Operaciones</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['operar/*']) }}" id="operar">
          <ul class="nav sub-menu">
            @can('operar.index')
            <li class="nav-item">
              <a href="{{ url('operar/lista-tour') }}" class="nav-link {{ active_class(['operar/lista-tour','operar/lista-tour/*']) }}">Tours</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      @if( Gate::check('liquidacion.ingreso') || Gate::check('liquidacion.salida') )
      <li class="nav-item {{ active_class(['liquidacion/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#liquidacion" role="button" aria-expanded="{{ is_active_route(['liquidacion/*']) }}" aria-controls="liquidacion">
          <i class="link-icon mdi mdi-cash-multiple" ></i>
          <span class="link-title">Liquidaciones</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['liquidacion/*']) }}" id="liquidacion">
          <ul class="nav sub-menu">
            @can('liquidacion.ingreso')
            <li class="nav-item">
              <a href="{{ url('liquidacion/ingreso') }}" class="nav-link {{ active_class(['liquidacion/ingreso','liquidacion/ingreso/*']) }}">Liquidacion Ingreso</a>
            </li>
            @endcan
            @can('liquidacion.salida')
            <li class="nav-item">
              <a href="{{ url('liquidacion/salida') }}" class="nav-link {{ active_class(['liquidacion/salida','liquidacion/salida/*']) }}">Liquidacion Egreso</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      @if( Gate::check('paquete.lista') || Gate::check('paquete.create') )
      <li class="nav-item {{ active_class(['paquete/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#paquete" role="button" aria-expanded="{{ is_active_route(['paquete/*']) }}" aria-controls="paquete">
          <i class="link-icon mdi" data-feather="box" ></i>
          <span class="link-title">Paquetes</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['paquete/*']) }}" id="paquete">
          <ul class="nav sub-menu">
            @can('paquete.lista')
            <li class="nav-item">
              <a href="{{ url('paquete/lista') }}" class="nav-link {{ active_class(['paquete/lista','paquete/lista/*']) }}">Lista</a>
            </li>
            @endcan
            @can('paquete.create')
            <li class="nav-item">
              <a href="{{ url('paquete/crear') }}" class="nav-link {{ active_class(['paquete/crear','paquete/create/*']) }}">Crear</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      @if( Gate::check('hotel.index') || Gate::check('pasajero.index') || Gate::check('medio.index') || Gate::check('servicio.index') || Gate::check('guia.index') || Gate::check('transporte.index') || Gate::check('restaurante.index') || Gate::check('agencia.index') || Gate::check('proveedor.index') )
      <li class="nav-item {{ active_class(['mantenimiento/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#mantenimiento" role="button" aria-expanded="{{ is_active_route(['mantenimiento/*']) }}" aria-controls="mantenimiento">
          <i class="link-icon" data-feather="settings"></i>
          <span class="link-title">Mantenimiento</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['mantenimiento/*']) }}" id="mantenimiento">
          <ul class="nav sub-menu">
            @can('hotel.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/hotel') }}" class="nav-link {{ active_class(['mantenimiento/hotel']) }}">Hoteles</a>
            </li>
            @endcan
            @can('pasajero.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/pasajero') }}" class="nav-link {{ active_class(['mantenimiento/pasajero']) }}">Pasajeros</a>
            </li>
            @endcan
            @can('medio.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/medio') }}" class="nav-link {{ active_class(['mantenimiento/medio']) }}">Medios Pagos</a>
            </li>
            @endcan
            @can('servicio.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/servicio') }}" class="nav-link {{ active_class(['mantenimiento/servicio']) }}">Servicios</a>
            </li>
            @endcan
            @can('guia.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/guia') }}" class="nav-link {{ active_class(['mantenimiento/guia']) }}">Guias</a>
            </li>
            @endcan
            @can('transporte.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/transporte') }}" class="nav-link {{ active_class(['mantenimiento/transporte']) }}">Transportes</a>
            </li>
            @endcan
            @can('restaurante.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/restaurante') }}" class="nav-link {{ active_class(['mantenimiento/restaurante']) }}">Restaurantes</a>
            </li>
            @endcan
            @can('agencia.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/agencia') }}" class="nav-link {{ active_class(['mantenimiento/agencia']) }}">Agencias</a>
            </li>
            @endcan
            @can('proveedor.index')
            <li class="nav-item">
              <a href="{{ url('mantenimiento/proveedor') }}" class="nav-link {{ active_class(['mantenimiento/proveedor']) }}">Proveedores</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      @if( Gate::check('categoria.index') || Gate::check('ubicacion.index') || Gate::check('proveedor.index') )
      <li class="nav-item {{ active_class(['mantenimientoweb/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#mantenimientoweb" role="button" aria-expanded="{{ is_active_route(['mantenimientoweb/*']) }}" aria-controls="mantenimientoweb">
          <i class="link-icon mdi mdi-cash-multiple" ></i>
          <span class="link-title">Mantenimiento Web</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['mantenimientoweb/*']) }}" id="mantenimientoweb">
          <ul class="nav sub-menu">

          @can('categoria.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/categoria') }}" class="nav-link {{ active_class(['mantenimientoweb/categoria']) }}">Categorias</a>
            </li>
            @endcan
            @can('ubicacion.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/ubicacion') }}" class="nav-link {{ active_class(['mantenimientoweb/ubicacion']) }}">Ubicaciones</a>
            </li>
            @endcan
            @can('tour.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/tour') }}" class="nav-link {{ active_class(['mantenimientoweb/tour','mantenimientoweb/tour/*']) }}">Tours</a>
            </li>
            @endcan
            @can('whatsapp.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/whatsapp') }}" class="nav-link {{ active_class(['mantenimientoweb/whatsapp','mantenimientoweb/whatsapp/*']) }}">Whatsapp</a>
            </li>
            @endcan
            @can('language.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/idioma') }}" class="nav-link {{ active_class(['mantenimientoweb/idioma','mantenimientoweb/idioma/*']) }}">Idiomas</a>
            </li>
            @endcan
            @can('comentario.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/comentario') }}" class="nav-link {{ active_class(['mantenimientoweb/comentario','mantenimientoweb/comentario/*']) }}">Comentarios</a>
            </li>
            @endcan
            @can('paqueteweb.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/paquete') }}" class="nav-link {{ active_class(['mantenimientoweb/paquete','mantenimientoweb/paquete/*']) }}">Paquete</a>
            </li>
            @endcan
            @can('menu.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/menu') }}" class="nav-link {{ active_class(['mantenimientoweb/menu','mantenimientoweb/menu/*']) }}">Menus</a>
            </li>
            @endcan
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/cabecera') }}" class="nav-link {{ active_class(['mantenimientoweb/cabecera','mantenimientoweb/cabecera/*']) }}">Cabecera</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/nosotros/') }}" class="nav-link {{ active_class(['mantenimientoweb/nosotros','mantenimientoweb/nosotros/*']) }}">Nosotros</a>
            </li>
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/certificados/') }}" class="nav-link {{ active_class(['mantenimientoweb/certificados','mantenimientoweb/certificados/*']) }}">Certificados</a>
            </li>
            @can('blog.index')
            <li class="nav-item">
              <a href="{{ url('mantenimientoweb/blog') }}" class="nav-link {{ active_class(['mantenimientoweb/blog']) }}">Blog</a>
            </li>
            @endcan
          </ul>
        </div>
      </li>
      @endif
      <li class="nav-item {{ active_class(['reportes/*']) }}">
        <a class="nav-link" data-bs-toggle="collapse" href="#reportes" role="button" aria-expanded="{{ is_active_route(['reportes/*']) }}" aria-controls="reportes">
          <i class="link-icon" data-feather="file-text"></i>
          <span class="link-title">Reportes</span>
          <i class="link-arrow" data-feather="chevron-down"></i>
        </a>
        <div class="collapse {{ show_class(['reportes/*']) }}" id="reportes">
          <ul class="nav sub-menu">
            <li class="nav-item">
              <a href="{{ url('reportes/reservas') }}" class="nav-link {{ active_class(['reportes/reservas']) }}">Reserva</a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</nav>
