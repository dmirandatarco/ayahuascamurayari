@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endpush
@section('content')
<form action="{{route('blog.update',$blog)}}" method="post" class="forms-sample" enctype="multipart/form-data">
  {{method_field('patch')}}
  {{csrf_field()}}
<div class="card mb-3">
  <div class="card-header">
    <h2 class="text-primary">Editar Blog</h2>
  </div>
</div>
<div class="row inbox-wrapper">
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-12" >
            <input type="hidden" name="language_id" value="{{$blog->language_id}}">
            <input type="hidden" value="{{$blog->id}}" name="blog_id"/>
            <label class="form-label" for="titulo">Titulo:</label>
            <input type="text" name="titulo"  id="titulo" class="form-control" value="{{old('titulo',$blog->titulo)}}" placeholder="Titulo">
            @error('titulo')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
          @livewire('imagen-principal-edit',["imagen"=>$blog->imagenprincipal])
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="descripcioncorta">Resumen:</label>
            <textarea class="form-control" name="descripcioncorta" id="descripcioncorta" rows="10">{{old('descripcioncorta',$blog->descripcioncorta)}}</textarea>
            @error('descripcioncorta')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
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
            <label class="form-label" for="descripcionlarga">Descripcion:</label>
            <textarea class="form-control" name="descripcionlarga" id="descripcionlarga" rows="10">{{old('descripcionlarga',$blog->descripcionlarga)}}</textarea>
            @error('descripcionlarga')
              <span class="error-message" style="color:red">{{ $message }}</span>
            @enderror
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="mb-3 col-md-12" >
            <label class="form-label" for="imagenes">Galeria:</label>
            @livewire('imagenes-tour-edit',["imagenesanteriores"=>$blog->images])
          </div>
        </div>
      </div>
    </div>
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

ClassicEditor
.create( document.querySelector( '#descripcioncorta' ),{
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
.create( document.querySelector( '#descripcionlarga' ),{
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

