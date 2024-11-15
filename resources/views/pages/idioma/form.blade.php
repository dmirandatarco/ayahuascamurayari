<div class="mb-3">
  <label for="abreviatura" class="form-label">Abreviatura:</label>
  <input type="text" class="form-control abreviatura" id="abreviatura" name="abreviatura" value="{{old('abreviatura')}}">
  @error('abreviatura')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="icono" class="form-label">Imagen:</label>
  <input id="icono" class="form-control" type="file" name="icono" value="{{old('icono')}}">
  @error('icono')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>

