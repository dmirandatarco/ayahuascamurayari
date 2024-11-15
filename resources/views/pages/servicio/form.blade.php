<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="tipo_id" class="form-label">Categoria:</label>
  <div >
    <select class="js-example-basic-single form-control tipo_id" name="tipo_id" id="tipo_id" data-live-search="true">
      <option value="" >SELECCIONE</option>
      @foreach($tipos as $tipo)
          <option value="{{$tipo->id}}" @selected(old('tipo_id')==$tipo->id)>{{$tipo->nombre}}</option>
      @endforeach
    </select>
    @error('tipo_id')
      <span class="error-message" style="color:red">{{ $message }}</span>
    @enderror
  </div>
</div>
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
