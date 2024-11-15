@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endpush
@section('content')
<form action="{{route('tour.update',$tour)}}" method="post" class="forms-sample" enctype="multipart/form-data">
  {{method_field('patch')}}
  {{csrf_field()}}
<div class="card mb-3">
  <div class="card-header">
    <h2 class="text-primary">Editar Tour</h2>
  </div>
</div>
<div class="row inbox-wrapper">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-12" >
            <input type="hidden" value="{{$tour->id}}" name="tour_id"/>
            <label class="form-label" for="nombre">Nombre:</label>
            <input type="text" name="nombre"  id="nombre" class="form-control" value="{{old('nombre',$tour->nombre)}}" placeholder="Nombre">
            @error('nombre')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="categoria_id">Categoria:</label>
            <select class="form-select js-states" id="categoria_id" name="categoria_id" data-width="100%">
              <option value="">SELECCIONE</option>
              @foreach($categorias as $categoria)
                <option value="{{$categoria->id}}" @selected(old('categoria_id',$tour->categoria_id)==$categoria->id)>{{$categoria->nombre}}</option>
              @endforeach
            </select>
            @error('categoria_id')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="ubicacion_id">Ubicación:</label>
            <select class="form-select" id="ubicacion_id" name="ubicacion_id[]" data-width="100%" multiple>
              @foreach($ubicaciones as $ubicacion)
                  <option value="{{$ubicacion->nombre}}"
                    @if(old('ubicacion_id')!="")
                      @selected(collect(old('ubicacion_id'))->contains($ubicacion->nombre))
                    @else
                      @selected($tour->ubicaciones->contains($ubicacion))
                    @endif
                  >{{$ubicacion->nombre}}</option>
              @endforeach
            </select>
            @error('ubicacion_id')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-3" >
            <label class="form-label" for="duracion">Duración:</label>
            <input type="number" name="duracion"  id="duracion" class="form-control" value="{{old('duracion',$tour->duracion)}}" placeholder="Duracion">
            @error('duracion')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-3" >
            <label class="form-label" for="unidad">Unidad:</label>
            <select class="form-select" id="unidad" name="unidad" data-width="100%">
              <option value="HORA(S)" @selected(old('unidad',$tour->unidad)=="HORA(S)")>HORA(S)</option>
              <option value="DIA(S)" @selected(old('unidad',$tour->unidad)=="DIA(S)")>DIA(S)</option>
            </select>
            @error('unidad')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-3" >
            <label class="form-label" for="inicio">Hora de Inicio:</label>
            <input type="time" name="inicio"  id="inicio" class="form-control" value="{{old('inicio',date("H:i",strtotime($tour->inicio)))}}" >
            @error('inicio')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-3" >
            <label class="form-label" for="tamaño_grupo">Grupo:</label>
            <input type="number" name="tamaño_grupo"  id="tamaño_grupo" class="form-control" value="{{old('tamaño_grupo',$tour->tamaño_grupo)}}" placeholder="Grupo max.">
            @error('tamaño_grupo')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="precio">Precio:</label>
            <input type="number" name="precio"  id="precio" class="form-control" value="{{old('precio',$tour->precio)}}" step="0.01" placeholder="Precio">
            @error('precio')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="precio_confidencial">Precio antes:</label>
            <input type="number" name="precio_confidencial"  id="precio_confidencial" class="form-control" value="{{old('precio_confidencial',$tour->precio_confidencial)}}" step="0.01" placeholder="Precio Confidencial">
            @error('precio_confidencial')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="descripcion">Descripción:</label>
            <textarea class="form-control" name="descripcion" id="descripcion" rows="10">{{old('descripcion',$tour->descripcion)}}</textarea>
            @error('descripcion')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="video">Video URL:</label>
            <input type="text" name="video"  id="video" class="form-control" value="{{old('video',$tour->video)}}" placeholder="video">
            @error('video')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="voucher">Pdf Diseño:</label>
            <input type="file" name="voucher" id="voucher" class="form-control">
            @error('voucher')
                <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          @livewire('imagen-principal-edit',["imagen"=>$tour->imagenprincipal])
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="incluye">Incluye:</label>
            <textarea class="form-control" name="incluye" id="incluye" rows="10">{{old('incluye',$tour->incluye)}}</textarea>
            @error('incluye')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="noincluye">No Incluye:</label>
            <textarea class="form-control" name="noincluye" id="noincluye" rows="10">{{old('noincluye',$tour->noincluye)}}</textarea>
            @error('noincluye')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="recomendaciones">Recomendaciones:</label>
            <textarea class="form-control" name="recomendaciones" id="recomendaciones" rows="10">{{old('recomendaciones',$tour->recomendaciones)}}</textarea>
            @error('recomendaciones')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="destacado">Destacado:</label><br>
            <div role="group"  class="btn-group btn-group-lg  form-switch mb-2">
              <label class="form-check-label me-5" for="formaReserva">No</label>
              <input type="checkbox" class="form-check-input me-3" id="destacado" name="destacado"  @checked($tour->destacado)/>
              <label class="form-check-label" for="destacado">Si</label>
            </div>
          </div>
          <div class="mb-3 col-md-6" >
            <label class="form-label" for="orden">Orden:</label><br>
            <input type="text" class="form-control" id="orden" name="orden"  value="{{old('orden',$tour->orden)}}"/>
            <input type="hidden" name="language_id" value="{{$tour->language_id}}">
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
            <label class="form-label" for="imagenes">Galeria:</label>
            @livewire('imagenes-tour-edit',["imagenesanteriores"=>$tour->images])
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6 mb-3">
    @livewire('itinerario',["itinerarios" => $tour->itinerarios])
  </div>
  <button type="submit" class="btn btn-primary me-2">Guardar</button>
</div>
</form>

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
  <script src="{{ asset('assets/plugins/ckeditor/es.js') }}"></script>
  <script src="{{ asset('assets/plugins/filepond/filepond.js') }}"></script>
  <script src="{{ asset('assets/plugins/filepond/filepond-validation.js') }}"></script>
@endpush

@push('custom-scripts')


<script>

$(document).ready(function() {
    $('#categoria_id').select2();
});

$(document).ready(function() {
    $('#ubicacion_id').select2({
      tags: true,
      tokenSeparators: [','],
      placeholder: "Seleccione...",
    });
});

$(document).ready(function() {
    $('#servicio_id').select2({
      placeholder: "Seleccione...",
    });
});

ClassicEditor
.create( document.querySelector( '#descripcion' ),{
  language: 'es',
})
.then(editor => {
    editor.keystrokes.set( 'space', ( key, stop ) => {
        editor.execute( 'input', { text: '\u00a0' } );
        stop();
    } );
})
.catch( error => {
    console.error( error );
} );

ClassicEditor
.create( document.querySelector( '#incluye' ),{
  language: 'es',
})
.then(editor => {
    editor.keystrokes.set( 'space', ( key, stop ) => {
        editor.execute( 'input', { text: '\u00a0' } );
        stop();
    } );
})
.catch( error => {
    console.error( error );
} );

ClassicEditor
.create( document.querySelector( '#noincluye' ),{
  language: 'es',
})
.then(editor => {
    editor.keystrokes.set( 'space', ( key, stop ) => {
        editor.execute( 'input', { text: '\u00a0' } );
        stop();
    } );
})
.catch( error => {
    console.error( error );
} );

ClassicEditor
.create( document.querySelector( '#recomendaciones' ),{
  language: 'es',
})
.then(editor => {
    editor.keystrokes.set( 'space', ( key, stop ) => {
        editor.execute( 'input', { text: '\u00a0' } );
        stop();
    } );
})
.catch( error => {
    console.error( error );
} );

</script>
@endpush

