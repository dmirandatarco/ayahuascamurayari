@extends('layout.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<div class="row inbox-wrapper">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @livewire('menu-crear')
            </div>
        </div>
    </div>
</div>


@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/sortablejs/Sortable.min.js') }}"></script>
@endpush