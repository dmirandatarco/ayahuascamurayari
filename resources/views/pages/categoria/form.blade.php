<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="descripcion" class="form-label">Descripción:</label>
  <textarea class="form-control descripcion" id="descripcion" name="descripcion">{{old('descripcion')}}</textarea>
  @error('descripcion')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="imagen" class="form-label">Imagen:</label>
  <input id="imagen" class="form-control" type="file" name="imagen" value="{{old('imagen')}}">
  @error('imagen')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<input type="hidden" name="language_id" id="language_id" value="{{old('language_id')}}" class="language_id">
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
