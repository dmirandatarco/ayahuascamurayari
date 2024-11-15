<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="tipo_documento" class="form-label">Tipo Documento:</label>
  <select class="form-select tipo_documento" name="tipo_documento" id="tipo_documento" data-live-search="true" >
    <option value="" >SELECCIONE</option>
    <option value="DNI" @selected(old('DNI')=="DNI")>DNI</option>
    <option value="PASAPORTE" @selected(old('PASAPORTE')=="PASAPORTE")>PASAPORTE</option>
    <option value="CARNET" @selected(old('CARNET')=="CARNET")>CARNET</option>
    <option value="RUC" @selected(old('RUC')=="RUC")>RUC</option>
  </select>
  @error('tipo_documento')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="num_documento" class="form-label">Numero de Documento:</label>
  <input type="text" class="form-control num_documento" id="num_documento" name="num_documento" value="{{old('num_documento')}}">
  @error('num_documento')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="celular" class="form-label">Celular:</label>
  <input type="text" class="form-control celular" id="celular" name="celular" value="{{old('celular')}}">
  @error('celular')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="email" class="form-label">E-mail:</label>
  <input type="email" class="form-control email" id="email" name="email" value="{{old('email')}}">
  @error('email')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="pais_id" class="form-label">Pais / Nacionalidad:</label>
  <div >
    <select class="js-example-basic-single form-control pais_id" name="pais_id" id="pais_id" data-live-search="true">
      <option value="" >SELECCIONE</option>
      @foreach($paises as $chunk)
        @foreach($chunk as $pais)
          <option value="{{$pais->id}}" @selected(old('pais_id')==$pais->id)>{{$pais->nombre}}</option>
        @endforeach
      @endforeach
    </select>
    @error('pais_id')
      <span class="error-message" style="color:red">{{ $message }}</span>
    @enderror
  </div>
</div>
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
