<div class="text-block NopaddingDetails">
    <h5 class="mb-4">Comentarios</h5>
    @foreach($model->comentarios  as $comentario)
    <div class="media d-block d-sm-flex review">
        <div class="text-md-center mr-4 mr-xl-5"><img src="{{asset('storage/img/usuario/default.png')}}" alt="Padmé Amidala" class="avatar avatar-xl p-2 mb-4"></div>
        <div class="media-body">
            <h6 class="mt-2 mb-1">{{$comentario->nombre}} ({{date("d-m-Y",strtotime($comentario->fecha))}})</h6>
            <div class="mb-2">
                @for($i=0;$i<$comentario->calificacion;$i++)
                <i class="fa fa-xs fa-star text-primary"></i>
                @endfor
            </div>
            <p class="text-muted text-sm">{{$comentario->comentario}}</p>
        </div>
    </div>
    @endforeach
    <div class="rebiew_section">
        <div id="leaveReview" class="mt-4 collapse show" style="">
            <h5 class="mb-4">Ingresa tu comentario</h5>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <input type="text" name="nombre" id="nombre" placeholder="Ingrese su Nombre" wire:model.defer="nombre" class="form-control">
                        @error('nombre')
                        <P class="text-sm" style="color:red">{{ $message }}</P>
                        @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <select name="calificacion" id="calificacion" class="custom-select focus-shadow-0" wire:model.defer="calificacion">
                            <option value="">SELECCIONE</option>
                            <option value="5">★★★★★ (5/5)</option>
                            <option value="4">★★★★☆ (4/5)</option>
                            <option value="3">★★★☆☆ (3/5)</option>
                            <option value="2">★★☆☆☆ (2/5)</option>
                            <option value="1">★☆☆☆☆ (1/5)</option>
                        </select>
                        @error('calificacion')
                        <P class="text-sm" style="color:red">{{ $message }}</P>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <input type="email" name="email" id="email" placeholder="Ingrese su email"  wire:model.defer="email"class="form-control">
                @error('email')
                <P class="text-sm" style="color:red">{{ $message }}</P>
                @enderror
            </div>
            <div class="form-group">
                <textarea rows="4" name="comentario" id="comentario" wire:model.defer="comentario" placeholder="Escriba su comentario aqui" class="form-control"></textarea>
                @error('comentario')
                <P class="text-sm" style="color:red">{{ $message }}</P>
                @enderror
            </div>
            <button type="button"  data-bs-toggle="tooltip" data-bs-title="Enviar" class="btn btn-primary" wire:click="agregar">Enviar</button>
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                </div>
            @endif
        </div>
    </div>
</div>
