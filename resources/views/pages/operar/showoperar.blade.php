@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
@section('content')
<form action="{{route('operar.showtourguardar')}}" method="post" class="form-horizontal" enctype="multipart/form-data">
{{csrf_field()}}
<div class="row inbox-wrapper">
  <div class="col-md-12 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h2 class="text-primary mb-3">SHOW / NO SHOW Tour {{$operar->tour->nombre}}</h2> 
          <input type="hidden" name="id_operar" value="{{$operar->id}}">
          <div class="mb-3 col-md-2" >
            <label class="card-title">Fecha:</label>
            <p class="parrafo">{{date("d-m-Y H:m",strtotime($operar->fecha))}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Pasajeros:</label>
            <p class="parrafo">{{$operar->cantidad}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Monto:</label>
            <p class="parrafo">{{$operar->monto_dar}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Precio Total:</label>
            <p class="parrafo">{{$operar->precio}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Usuario:</label>
            <p class="parrafo">{{$operar->user->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Estado:</label>
            <p class="parrafo">
              @if($operar->estado==1)
                Registrado
              @else
                Anulado
              @endif
            </p>  
          </div>
          @foreach($operar->proveedors as $proveedor)
          <div class="mb-3 col-md-3" >
            <label class="card-title">{{$proveedor->servicio->nombre}}:</label>
            <p class="parrafo">{{$proveedor->nombre}}</p>  
          </div>
          @endforeach
          <div class="col-md-12">
            <h4 class="mb-4">DETALLES DE TOURS</h4>
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><label class="form-label"> PAX</label></th>
                            <th><label class="form-label"> PASAJERO</label></th>
                            <th><label class="form-label"> CONTRATO</label></th>
                            <th><label class="form-label"> HOTEL</label></th>
                            <th><label class="form-label"> INGRESOS</label></th>
                            <th><label class="form-label"> HORA DE RECOJO</label></th>
                            <th><label class="form-label"> SALDO</label></th>
                            <th><label class="form-label"> OBSERVACIONES</label></th>
                            <th><label class="form-label"> ESTADO</label></th>
                            <th><label class="form-label"> SHOW / NO SHOW</label></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($operar->detallesoperar as $detalle)
                          <tr>
                            <td>{{$detalle->detalle->cantidad}}</td>
                            <td>{{$detalle->detalle->reserva->pasajero->nombre}} {{$detalle->detalle->reserva->pasajero->celular}}</td>
                            <td>{{$detalle->detalle->reserva->user->nombre}} </td>
                            <td>{{$detalle->detalle->hotel->nombre}}</td>
                            <td>{{$detalle->detalle->ingreso}}</td>
                            <td>{{$detalle->horarecojo}}</td>
                            <td>
                                @foreach($detalle->detalle->reserva->totales as $total)
                                    @if($loop->last)
                                        {{$total->moneda->abreviatura}} {{$total->saldo}}
                                    @else
                                        {{$total->moneda->abreviatura}} {{$total->saldo}} /
                                    @endif
                                @endforeach
                            </td>
                            <td>{{$detalle->detalle->observacion}}</td>
                            <td>
                              @if($detalle->detalle->estado==1)
                                Registrado
                              @elseif($detalle->detalle->estado==2)
                                No Show
                              @elseif($detalle->detalle->estado==3)
                                Show
                              @elseif($detalle->detalle->estado==4)
                                Finalizado
                              @else
                                Anulado
                              @endif
                            </td>
                            <td>
                              <div class="form-check form-switch mb-2">
                                <input type="checkbox" class="form-check-input " name="check[{{$detalle->id}}]" @checked($detalle->detalle->estado==3 )/>
                              </div>
                            </td>
                          </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <div class="row flex justify-content-end mb-4">
                  <div class="col-md-1  flex justify-content-end">
                      <button type="submit" class="btn btn-primary me-2 ">Guardar</button>
                  </div>
              </div>
            </div><!-- Col -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>


@endsection
