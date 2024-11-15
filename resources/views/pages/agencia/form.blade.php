<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
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
  <label for="direccion" class="form-label">Dirección:</label>
  <input type="text" class="form-control direccion" id="direccion" name="direccion" value="{{old('direccion')}}">
  @error('direccion')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="precio" class="form-label">Precio:</label>
  <input type="number" class="form-control precio" id="precio" name="precio" value="{{old('precio')}}" step="0.01">
  @error('precio')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<input type="hidden" class="form-control servicio_id" id="servicio_id" name="servicio_id" value="{{old('servicio_id')}}">
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
