<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}" placeholder="Ingrese Nombre">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="cargo" class="form-label">Cargo:</label>
  <input type="text" class="form-control cargo" id="cargo" name="cargo" value="{{old('cargo')}}" placeholder="Ingrese Cargo">
  @error('cargo')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="numero" class="form-label">Celular:</label>
  <input type="numero" class="form-control number" id="numero" name="numero" value="{{old('numero')}}" placeholder="Ingrese Numero">
  @error('numero')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
