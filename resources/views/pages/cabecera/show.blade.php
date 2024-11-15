@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper justify-content-center d-flex">
    @if ($cabecera->tipo == '1')
    <div class="card  w-50" style="width: ;">
        <div class="col-md-12">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($cabecera->images as $key => $imagen)
                        <div class="carousel-item{{ $key === 0 ? ' active' : '' }}">
                            <img src="{{asset('storage/img/cabecera/'.$imagen->nombre)}}" class="d-block w-100" alt="{{$cabecera->nombre}}">
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
    @else
    <div class="card  w-50" style="width: ;">
        <div class="col-md-12">
            <div class="ratio ratio-16x9">
                <video muted autoplay loop style="position:absolute; top:0; left:0; width:100%; height:95%; object-fit:cover;margin-top: -110px;">
                    <source src="{{asset('storage/img/cabecera/'.$cabecera->video)}}">
                </video>
            </div>
        </div>
    </div>
    @endif
</div>


@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables-net-bs5/dataTables.bootstrap5.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush
