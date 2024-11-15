@extends('layout.master')
@push('plugin-styles')
  <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
  <div class="col-md-12 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <h2 class="text-primary mb-3">ENDOSE AGENCIA {{$reserva->proveedor->nombre}}</h2> 
          <div class="mb-3 col-md-3" >
            <label class="card-title">Pasajero:</label>
            <p class="parrafo">{{$reserva->pasajero->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Celular:</label>
            <p class="parrafo">{{$reserva->pasajero->celular}}</p>  
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title">E-mail:</label>
            <p class="parrafo">{{$reserva->pasajero->email}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Counter:</label>
            <p class="parrafo">{{$reserva->user->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Fecha:</label>
            <p class="parrafo">{{date("d-m-Y H:m",strtotime($reserva->fecha))}}</p>  
          </div>
          <div class="col-md-12">
            <h4 class="mb-4">DETALLES DE TOURS</h4>
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                              <th><label class="form-label"> Nº</label></th>
                              <th><label class="form-label"> FECHA</label></th>
                              <th><label class="form-label"> TOUR</label></th>
                              <th><label class="form-label"> HOTEL</label></th>
                              <th><label class="form-label"> PRECIO</label></th>
                              <th><label class="form-label"> INGRESO</label></th>
                              <th><label class="form-label"> OBSERVACIÓN</label></th>
                              <th><label class="form-label"> ESTADO</label></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($reserva->detalles as $detalle)
                            <tr>
                              <td>{{$detalle->cantidad}}</td>
                              <td>{{date("d-m-Y",strtotime($detalle->fecha_viaje))}}</td>
                              <td>{{$detalle->tour->nombre}}</td>
                              <td>{{$detalle->hotel->nombre}}</td>
                              <td>{{$detalle->moneda->abreviatura}} {{number_format($detalle->precio,2)}}</td>
                              <td>{{number_format($detalle->ingreso,2)}}</td>
                              <td>{{$detalle->observacion}}</td>
                              <td>
                                @if($detalle->estado==1)
                                  Registrado
                                @elseif($detalle->estado==2)
                                  No Show
                                @elseif($detalle->estado==3)
                                  Show
                                @elseif($detalle->estado==4)
                                  Finalizado
                                @else
                                  Anulado
                                @endif
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                          @foreach($reserva->totales as $total)
                            <tr>
                              <td colspan="4" style="text-align-last: right;" >Por Cobrar:</td>
                              <td > {{$total->moneda->abreviatura}} {{number_format($total->saldo,2)}}</td>
                            </tr>
                          @endforeach
                        </tfoot>
                    </table>
                </div>
            </div><!-- Col -->
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(count($reserva->servicios)>0)
  <div class="col-md-6">
    <div class="card">
      <div class="card-body">
        <h4 class="mb-4">SERVICIOS</h4>
        <div class="col-md-12 mb-3">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                          <th><label class="form-label"> CANTIDAD</label></th>
                          <th><label class="form-label"> SERVICIO</label></th>
                          <th><label class="form-label"> PRECIO</label></th>
                          <th><label class="form-label"> OBSERVACIÓN</label></th>
                          <th><label class="form-label"> OBSERVACIÓN</label></th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($reserva->servicios as $servicio)
                        <tr>
                          <td>{{$servicio->pivot->cantidad}}</td>
                          <td>{{$servicio->nombre}}</td>
                          <td>{{number_format($servicio->pivot->precio_venta,2)}}</td>
                          <td>{{$servicio->pivot->descripcion}}</td>
                          <td>
                            @if($servicio->estado==1)
                              Registrado
                            @elseif($servicio->estado==2)
                              Operado
                            @elseif($servicio->estado==3)
                              Finalizado
                            @else
                              Anulado
                            @endif
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
        </div><!-- Col -->
      </div>
    </div>
  </div>
  @endif
</div>



@endsection
