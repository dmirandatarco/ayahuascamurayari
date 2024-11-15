@extends('layout.master')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')

<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card" >
    <div class="card overflow-hidden">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
          <h6 class="card-title mb-0">Reservas por Usuario</h6>
        </div>
        <div class="row align-items-start mb-2">
          <div class="col-md-7">

          </div>
        </div>
        <canvas id="chartjsGroupedBar"  height="80"></canvas>
      </div>
    </div>
  </div>
</div> <!-- row -->
@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/chartjs/chart.min.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.js') }}"></script>
  <script src="{{ asset('assets/plugins/jquery.flot/jquery.flot.pie.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
  if($('#chartjsGroupedBar').length) {
    new Chart($('#chartjsGroupedBar'), {
      type: 'bar',
      data: {
        labels: [<?php foreach($reservasPorUsuario as $reserva)
                {echo '"'.$reserva->user->nombre.'",';} ?>],
        datasets: [
          {
            label:"Fichas",
            backgroundColor: ["#68da3e","#00c6ab","#6aa3b4","#416864","#223026","#ebb7ce","#b38471","#5c5e36","#1d3d33","#0c181c","#ebe6ea","#e4c5c4","#c8ad8d","#6f7357","#273a2d","#20c67a","#3f8880","#9dc09d","#fef6cd","#d6ebc1","#ff8862","#be6167","#7b3ea0","#0076a1","#3da3a7","#ffd3ff","#a83f6c","#a8a8ff","#00c162","#008bde","#5749dd","#70271c","#a16f40","#dccf6a","#51f68d","#ecc402","#e570be","#db54a4","#e0314a","#ad0244","#643d85","#a62fd6","#939924","#af9fec","#e899d1","#ff9177","#fc8526"],
            data: [<?php foreach($reservasPorUsuario as $reserva)
                {echo '"'.$reserva->total_reservas.'",';} ?>]
          }

        ]
      },
      options: {
        plugins: {
          legend: {
            display: true,
            labels: {
              color: "#000",

            }
          },
        },
        scales: {
          x: {
            display: true,
            grid: {
              display: true,
              color: "rgba(77, 138, 240, .15)",
              borderColor: "rgba(77, 138, 240, .15)",
            },
            ticks: {
              color: "#000",
              font: {
                size: 12
              }
            }
          },
          y: {
            grid: {
              display: true,
              color: "rgba(77, 138, 240, .15)",
              borderColor: "rgba(77, 138, 240, .15)",
            },
            ticks: {
              color: "#000",
              font: {
                size: 12
              }
            }
          }
        }
      }
    });
  }

  </script>

@endpush
