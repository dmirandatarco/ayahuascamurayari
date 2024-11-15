<div class="row">
    <h4 class="mb-3">{{$isEdit == 1 ? 'EDITAR MENU':'CREAR MENU'}}</h4>
    <div class="mb-3 col-md-6">
        <label class="form-label" for="nombre">TITULO:</label>
        <input type="text" class="form-control" name="nombre" placeholder="Titulo principal" id="nombre" wire:model.defer="nombre" required>
        @error('nombre')
        <span class="error-message" style="color:red">{{$message}}</span>
        @enderror
    </div>
    <div class="mb-3 col-md-6">
        <label class="form-label" for="tipo">UBICACION:</label>
        <div wire:ignore>
            <select class="form-control"  id="tipo" wire:model.defer="tipo">
                <option value="1">HEADER</option>
                <option value="0">FOOTER</option>
            </select>
        </div>       
        @error('tipo')
            <span class="error-message" style="color:red">{{$message}}</span>
        @enderror
    </div>

    <div class="col-md-12">
        <h4 class="mb-4">LINKS</h4>
        <button type="button"  data-bs-toggle="tooltip" data-bs-title="Agregar" class="btn btn-success " wire:click="aumentar"> 
            <i class="fa fa-plus-circle"></i> Agregar
        </button>
        <div class="col-md-12 mb-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th ><label class="form-label"> CATEGORIA</label></th>
                            <th ><label class="form-label"> NOMBRE</label></th>
                            <th ><label class="form-label"> URL</label></th>
                            <th ></th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo" wire:sortable="actualizarOrden">
                        @for($i=0; $i<$cont; $i++)
                            <tr id="{{$i}}">
                                <td>{{$i+1}}</td>
                                <td>
                                    <select class="form-control" name="tour_id" id="categoria_id{{$i}}" wire:model.defer="categoria_id.{{$i}}">
                                        <option value="">SELECCIONE</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id.'.$i)
                                    <span class="error-message" style="color:red">Campo Obligatorio</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="nombredetalle " name="nombredetalle{{$i}}" id="nombredetalle{{$i}}" wire:model.defer="nombredetalle.{{$i}}">
                                    @error('nombredetalle.'.$i)
                                    <span class="error-message" style="color:red">Campo Obligatorio</span>
                                    @enderror
                                </td>
                                <td>
                                    <input type="text" class="form-control" placeholder="nombredetalle " name="url{{$i}}" id="url{{$i}}" wire:model.defer="url.{{$i}}">
                                    @error('url.'.$i)
                                    <span class="error-message" style="color:red">Campo Obligatorio</span>
                                    @enderror
                                </td>
                                <td>
                                    <button type="button" data-bs-toggle="tooltip" data-bs-title="Reducir" class="btn btn-danger btn-icon" wire:click="reducir">-</button>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>
        </div><!-- Col -->
    </div>
    <div class="row flex justify-content-end">
        <div class="col-md-1  flex justify-content-end">
            <button type="button" class="btn btn-primary me-2 " wire:click="guardar" @disabled($cont == 0)>Guardar</button>
        </div>
    </div>
</div>

@push('custom-scripts')
<script>
    $('#tipo').select2({
        width: '100%',
    });
    $('#tipo').on('change', function() {
        @this.set('tipo', this.value);
    });

    document.addEventListener('livewire:load', function () {
        var simpleList = document.querySelector("#cuerpo");
        var sortable = new Sortable(simpleList, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function(evt) {
                var ordenElementos = Array.from(simpleList.children).map(function(elemento) {
                    return elemento.id; // Supongamos que los elementos tienen una ID única
                });

                Livewire.emit('actualizarOrden', ordenElementos); // Llama al método de Livewire para actualizar el orden
            }
        });
    });
</script>
@endpush