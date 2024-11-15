<div>
    @for($i=0;$i<$pax;$i++)
        <div class="row mb-3">
            <div class="col-md-1">
                <label class="form-label">#</label>
                <input type="text" disabled value="{{$i+1}}" class="form-control" required>
            </div>
            <div class="col">
                <label class="form-label">Nombres(*)</label>
                <input type="text" name="name[]"  class="form-control" >
                <div class="error-message text-danger" id="nameError_{{$i}}"></div>
            </div>
            <div class="col">
                <label class="form-label">Documento(*)</label>
                <select class="custom-select select-big mb-3" name="doc[]"  data-live-search  required>
                <option value="" >SELECCIONE</option> 
                <option value="DNI">DNI</option>
                    <option value="PASAPORTE">PASAPORTE</option>         
                    <option value="CARNET">CARNET</option>         
                    <option value="RUC">RUC</option>
                </select>
                <div class="error-message text-danger" id="docError_{{$i}}"></div>
            </div>
            <div class="col">
                <label class="form-label">Nº Documento(*)</label>
                <input type="text" name="nume_doc[]"  class="form-control"  required>
                <div class="error-message text-danger" id="numedocError_{{$i}}"></div>
            </div>
            <div class="col">
                <label for="pais_id" class="form-label">NACIONALIDAD:</label>
                <select class="custom-select select-big mb-3" name="pais[]" id="pais" required>
                <option value="" >SELECCIONE</option> 
                @foreach($paises as $pais)
                    <option value="{{$pais->id}}">{{$pais->nombre}}</option>
                @endforeach
                </select>
                <div class="error-message text-danger" id="paisError_{{$i}}"></div>
            </div>
        </div>
    @endfor
</div>
