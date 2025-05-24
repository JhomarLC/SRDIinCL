@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- select2  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'dashboard'],
    ])
    @slot('title')
        Training Evaluation Management
    @endslot
@endcomponent
@include('components.alert')
@include('training-evaluation-management.components.modal-create')
@include('training-evaluation-management.components.modal-update')
@include('training-evaluation-management.components.status-update')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Pests and Nutrient Management for Intermediaries and Farmers</h5>
                <a style="margin-right: 10px" href="{{ route('training-evaluation-management.export.full') }}">
                    <button class="btn btn-success"><i class="ri-file-excel-2-fill"></i> Export Full Evaluation Report</button>
                </a>
                <button  class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addnewtrainingeventsmodal">
                    <i class="ri-file-add-fill"></i> New Training Event
                </button>
            </div>
            <div class="card-body">
                <table id="training_events" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Training ID</th>
                            <th>Training Date</th>
                            <th>Training Date</th>
                            <th data-ordering="false">Training Address</th>
                            <th data-ordering="false">Common Goal</th>
                            <th data-ordering="false">Common Overall Quality</th>
                            <th data-ordering="false">Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@endsection
@section('script')

<!-- datatables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>
@include('training-evaluation-management._includes.script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
