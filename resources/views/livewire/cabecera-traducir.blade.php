<div>
    <form action="{{route('cabecera.store')}}" method="POST" class="forms-sample" enctype="multipart/form-data">
    {{csrf_field()}}
    <div class="card mb-3">
        <div class="card-header d-flex justify-content-between">
            <h2 class="text-primary">Cabecera</h2>
            <div class="mb-3" >
                <div role="group"  class="btn-group btn-group-lg  form-switch mb-2">
                <label class="form-check-label me-5" for="formaReserva">Video</label>
                <input type="checkbox" class="form-check-input form-check-input-grande me-3" id="tipo" name="tipo" wire:model="tipo" style="font-size: 25px !important;margin-left:-0.5rem !important;width: 3em;" disabled/>
                <label class="form-check-label" for="tipo">Slider</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row inbox-wrapper">
        <div class="col-md-12 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label class="form-label" for="nombre">Nombre:</label>
                            <input type="text" name="nombre"  id="nombre" wire:model="nombre" class="form-control" value="{{old('nombre')}}" placeholder="Nombre">
                            <!-- Idioma -->
                            @error('nombre')
                            <span class="error-message" style="color:red">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row inbox-wrapper">
        @if($tipo==1)
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12" >
                                <label class="form-label" for="imagenes">Galeria:</label>
                                <!-- Documentos -->
                                <div class="row form-group">
                                    <div class="col-md-12 mb-5">
                                        <div class="table-responsive">
                                            <table id="vias" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <label class="form-label d-inline-flex">Link de URL</label>
                                                        </th>
                                                        <th>
                                                            <label class="form-label d-inline-flex"> Imagen Slider</label>
                                                        </th>
                                                        <th>
                                                                <button type="button" class="btn btn-success btn-icon" wire:click="aumentarGaleria2" tabindex="118">+</button>

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                        $j=0;
                                                    @endphp
                                                @if($imagenes)
                                                    @for($i=0;$i<$cont4;$i++)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="url_link[]" placeholder="Link de navegación" id="url_link.{{$i}}" wire:model="url_link.{{$i}}">
                                                            @error('url_link.'.$i)
                                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                        <td class="d-flex gap-2">
                                                            {{-- <input type="file" accept="image/*" class="form-control h-100" name="imagenes.{{$i}}" id="imagenes.{{$i}}" wire:model.defer="imagenes.{{$i}}"> --}}
                                                            @if($imagenes[$i]!= null)
                                                            <img src="{{$imagenes[$i]}}"  class="imagen-principal img-thumbnail w-25">
                                                            @endif
                                                        </td>
                                                        <td>
                                                        <button type="button" class="btn btn-danger btn-icon" wire:click="reducirGaleria({{$i}})" tabindex="119">-</button>
                                                        </td>
                                                    </tr>
                                                    @endfor
                                                @endif

                                                @for($j;$j<$cont5;$j++)
                                                    <tr>
                                                        <td>
                                                            <input type="text" class="form-control" name="url_link2[]" placeholder="Link de navegación" id="url_link2.{{$j}}" wire:model="url_link2.{{$j}}">
                                                            @error('url_link2.'.$j)
                                                            <span class="error-message" style="color:red">{{ $message }}</span>
                                                            @enderror
                                                        </td>
                                                        <td>
                                                            <input type="file" accept="image/*" class="form-control" name="imagenes2.{{$j}}" id="imagenes2.{{$j}}" wire:model.defer="imagenes2.{{$j}}">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-icon" wire:click="reducirGaleria2({{$j}})" tabindex="119">-{{$j}}</button>
                                                        </td>
                                                    </tr>
                                                @endfor
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-md-12" >
                                <label class="form-label" for="video">Video:</label>
                                <input type="file" class="form-control" id="video_lote" name="video_lote" accept="video/*" wire:model="video">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <button type="button" class="btn btn-primary" wire:click.prevent="register">Guardar</button>
    </div>
    </form>
</div>
