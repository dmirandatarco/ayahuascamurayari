@extends('layout.master')
@push('plugin-styles')
    <link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/filepond/filepond.css') }}" rel="stylesheet" />
@endpush
@section('content')
    @livewire('cabecera-traducir', ["cabecera" => $cabecera, "lang" => $lang])


@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('assets/plugins/ckeditor/es.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('assets/plugins/filepond/filepond-validation.js') }}"></script>
@endpush

@push('custom-scripts')


@endpush

