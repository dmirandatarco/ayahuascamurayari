<div class="mb-3">
  <label for="nombre" class="form-label">Nombre:</label>
  <input type="text" class="form-control nombre" id="nombre" name="nombre" value="{{old('nombre')}}">
  @error('nombre')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="numero" class="form-label">Numero de Cuenta:</label>
  <input type="text" class="form-control numero" id="numero" name="numero" value="{{old('numero')}}">
  @error('numero')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="descripcion" class="form-label">Descripción:</label>
  <input type="text" class="form-control descripcion" id="descripcion" name="descripcion" value="{{old('descripcion')}}">
  @error('descripcion')
    <span class="error-message" style="color:red">{{ $message }}</span>
  @enderror
</div>
<div class="mb-3">
  <label for="moneda_id" class="form-label">Moneda:</label>
  <div >
    <select class="js-example-basic-single form-control moneda_id" name="moneda_id" id="moneda_id" data-live-search="true">
      <option value="" >SELECCIONE</option>
      @foreach($monedas as $moneda)
          <option value="{{$moneda->id}}" @selected(old('moneda_id')==$moneda->id)>{{$moneda->abreviatura}} {{$moneda->nombre}}</option>
      @endforeach
    </select>
    @error('moneda_id')
      <span class="error-message" style="color:red">{{ $message }}</span>
    @enderror
  </div>
</div>
<div class="modal-footer">
  <button type="button"  data-bs-toggle="tooltip" data-bs-title="Cerrar" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
  <button type="submit"  data-bs-toggle="tooltip" data-bs-title="Guardar" class="btn btn-primary">Guardar</button>
</div>
