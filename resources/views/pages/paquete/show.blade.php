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
          <h2 class="text-primary mb-3">Paquete Nº {{$paquete->id}}</h2> 
          <div class="mb-3 col-md-3" >
            <label class="card-title">Nombre:</label>
            <p class="parrafo">{{$paquete->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Cantidad Pax:</label>
            <p class="parrafo">{{$paquete->cantidad}}</p>  
          </div>
          <div class="mb-3 col-md-3" >
            <label class="card-title">Dias:</label>
            <p class="parrafo">{{$paquete->dia}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Counter:</label>
            <p class="parrafo">{{$paquete->user->nombre}}</p>  
          </div>
          <div class="mb-3 col-md-2" >
            <label class="card-title">Total:</label>
            <p class="parrafo">{{$paquete->moneda->abreviatura}} {{$paquete->total}}</p>  
          </div>
          <div class="col-md-12">
            <h4 class="mb-4">DETALLES DE TOURS</h4>
            <div class="col-md-12 mb-3">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                          <tr>
                            <th class="col-md-2"><label class="form-label"> TOUR</label></th>
                            <th class="col-md-2"><label class="form-label"> DIA</label></th>
                            <th class="col-md-3"><label class="form-label"> OBSERVACIÓN</label></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($paquete->detalles as $detalle)
                            <tr>
                              <td>{{$detalle->tour->nombre}}</td>
                              <td>{{$detalle->dia}}</td>
                              <td>{{$detalle->observacion}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <td colspan="2" style="text-align-last: right;" >Total:</td>
                              <td > {{$paquete->moneda->total}} {{number_format($paquete->total,2)}}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div><!-- Col -->
          </div>
        </div>
      </div>
    </div>
  </div>
  @if(count($paquete->servicios)>0)
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
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($paquete->servicios as $servicio)
                        <tr>
                          <td>{{$servicio->pivot->cantidad}}</td>
                          <td>{{$servicio->nombre}}</td>
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
