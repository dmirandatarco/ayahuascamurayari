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
          <h2 class="text-primary mb-3">Liquidacion: {{$liquidacion->proveedor->nombre}}</h2> 
          <div class="mb-3 col-md-2" >
            <label class="card-title">Fecha:</label>
            <p class="parrafo">{{date("d-m-Y H:m",strtotime($liquidacion->fecha))}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Tipo:</label>
            <p class="parrafo">
              @if($liquidacion->tipo==1)
                Ingreso
              @else
                Egreso
              @endif
            </p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Acuenta:</label>
            <p class="parrafo">S/ {{$liquidacion->acuenta}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Total:</label>
            <p class="parrafo">{{$liquidacion->monto}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Usuario:</label>
            <p class="parrafo">{{$liquidacion->user->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Estado:</label>
            <p class="parrafo">
              @if($liquidacion->estado==1)
                Registrado
              @elseif($liquidacion->estado==2)
                Pagado
              @else
                Anulado
              @endif
            </p>  
          </div>
          <div class="col-md-12">
            <h4 class="mb-4">DETALLES DE LIQUIDACION</h4>
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th><label class="form-label"> FECHA</label></th>
                            <th><label class="form-label"> PAX</label></th>
                            <th><label class="form-label"> 
                              @if($liquidacion->tipo==1)
                                  PASAJERO
                                @else
                                  SERVICIO
                              @endif
                              </label>
                            </th>
                            @if($liquidacion->tipo==1)
                              <th><label class="form-label"> TOUR</label></th>
                            @endif
                            <th><label class="form-label"> PRECIO</label></th>
                            @if($liquidacion->tipo==1)
                              <th><label class="form-label"> COBRAR</label></th>
                            @endif
                            <th><label class="form-label"> SUB TOTAL</label></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($liquidacion->detallesliquidacion as $detalle)
                            <tr>
                              @if($liquidacion->tipo==1)
                                <td>{{date("d-m-Y",strtotime($detalle->ejecutable->fecha_viaje))}}</td>
                              @else
                                <td>{{date("d-m-Y",strtotime($detalle->ejecutable->operar?->fecha))}}</td>
                              @endif
                              <td>{{$detalle->cantidad}}</td>
                              <td>{{$detalle->ejecutable->reserva?->pasajero->nombre}} {{$detalle->ejecutable->reserva?->pasajero->celular}} {{$detalle->ejecutable->servicio?->nombre}}</td>
                              @if($liquidacion->tipo==1)
                                <td>{{$detalle->ejecutable->tour?->nombre}} </td>
                              @endif
                              <td>{{$detalle->precio}}</td>
                              @if($liquidacion->tipo==1)
                                <td>{{$detalle->ejecutable->reserva?->totales[0]->moneda->abreviatura}} {{$detalle->ejecutable->reserva?->totales[0]->saldo}}</td>
                              @endif
                              @if($liquidacion->tipo==1)
                                <td>{{number_format($detalle->precio*$detalle->cantidad,2)}}</td>
                              @else
                                <td>{{number_format($detalle->precio,2)}}</td>
                              @endif
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
            </div><!-- Col -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@endsection
