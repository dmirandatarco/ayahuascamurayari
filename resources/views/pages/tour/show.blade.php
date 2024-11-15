@extends('layout.master')
@section('content')
<div class="card mb-3">
  <div class="card-header">
    <h2 class="text-primary">{{$tour->nombre}}</h2> 
  </div>
</div> 
<div class="row inbox-wrapper">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-6" >
            <label class="card-title"  for="categoria_id">Categoria:</label>
            <p class="parrafo">{{$tour->categoria->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-6" >
            <label class="card-title"  for="ubicacion_id">Ubicación:</label>      
            <p class="parrafo">
              @foreach($tour->ubicaciones as $ubicacion)
                @if($loop->last)
                  {{$ubicacion->nombre}}
                @else
                  {{$ubicacion->nombre}},
                @endif
              @endforeach
            </p> 
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title"  for="duracion">Duración:</label> 
            <p>{{$tour->duracion}}</p>    
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title" for="unidad">Unidad:</label> 
            <p>{{$tour->unidad}}</p>  
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title"  for="inicio">Hora de Inicio:</label> 
            <p>{{$tour->inicio}}</p>       
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title"  for="tamaño_grupo">Grupo:</label> 
            <p>{{$tour->tamaño_grupo}}</p>         
          </div>
          <div class="mb-3 col-md-6" >
            <label class="card-title"  for="precio">Precio:</label> 
            <p>{{$tour->precio}}</p>         
          </div>
          <div class="mb-3 col-md-6" >
            <label class="card-title"  for="precio_confidencial">Precio Confidencial:</label> 
            <p>{{$tour->precio_confidencial}}</p>         
          </div>
          <div class="mb-3 col-md-12" >
            <label class="card-title"  for="descripcion">Descripción:</label> 
            <p>{!! $tour->descripcion !!}</p>       
          </div>
          <div class="mb-3 col-md-6">
            <label class="card-title" for="servicio_id">Servicios:</label> 
            <p>   
            @foreach($tour->servicios as $servicio)
              @if($loop->last)
                {{$servicio->nombre}}
              @else
                {{$servicio->nombre}},
              @endif
            @endforeach
            </p>
          </div>
          <div class="mb-3 col-md-6">
            <label class="card-title" for="servicio_id">Web:</label> 
            <p>   {{$tour->web ? 'Si' : 'No'}}
            </p>
          </div>
          <div class="mb-3 col-md-4" >
            <label class="card-title" for="servicio_id">Imagen Principal:</label> 
            <p> <img src="{{asset('storage/img/tours/'.$tour->imagenprincipal)}}"  class="imagen-principal">
            </p>
          </div>
          <div class="mb-3 col-md-8" >
            <label class="card-title" for="servicio_id">Galeria:</label> 
            <p> 
              @foreach($tour->images as $image)
                <img src="{{asset('storage/img/tours/'.$image->nombre)}}"  class="imagen-principal mb-3">
              @endforeach
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-12" >
            <label class="card-title"  for="incluye">Incluye:</label> 
            <p>{!!str_replace(array("<p>"), '</li><li class="nav-link"><i class="icon-sm" data-feather="check-circle"></i>  ',$tour->incluye)!!}</p>   
          </div>
          <div class="mb-3 col-md-12" >
            <label class="card-title" for="noincluye">No Incluye:</label> 
            <p>{!!str_replace(array("<p>"), '</li><li class="nav-link"><i class="icon-sm" data-feather="x-circle"></i>  ',$tour->noincluye)!!}</p>   
          </div>
          <div class="mb-3 col-md-12" >
            <label class="card-title" for="recomendaciones">Recomendaciones:</label> 
            <p>{!!str_replace(array("<p>"), '</li><li class="nav-link" ><i class="icon-sm" data-feather="chevrons-right"></i>  ',$tour->recomendaciones)!!}</p>   
          </div>     
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


