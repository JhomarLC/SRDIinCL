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
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'dashboard'],
    ])
    @slot('title')
        Farmer's Baseline Monitoring
    @endslot
@endcomponent
@include('components.alert')
<div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between">
    <div class="flex-grow-1 mb-3 mb-lg-0">
        <!-- You can optionally add a title or leave this empty -->
    </div>
    <form action="javascript:void(0);" class="d-flex flex-wrap gap-3 align-items-end">
        <div class="d-flex flex-column" style="min-width: 250px;">
            <label for="province" class="form-label">Filter Province</label>
            <select class="form-control select2 filter" id="province" name="province_code">
                <option value="" selected>All Province</option>
            </select>
        </div>
        <div class="d-flex flex-column" style="min-width: 250px;">
            <label for="season" class="form-label">Filter Province</label>
            <select class="form-control select2 filter" id="season" name="season">
                <option value="" selected>All Season</option>
                <option value="Wet Season" selected>Wet Season</option>
                <option value="Dry Season" selected>All Season</option>
            </select>
        </div>
        <div class="d-flex gap-2">
            <button type="button" id="exportBtn" class="btn btn-success">
                <i class="ri-file-excel-2-fill"></i> Export
            </button>
            <button type="button" id="resetFiltersBtn" class="btn btn-outline-secondary">
                <i class="ri-refresh-line"></i> Reset
            </button>
        </div>
    </form>
</div>
{{-- Or raw output if you want unescaped HTML (be cautious!) --}}
<div class="row mt-3">
    <div class="col-lg-12">
        <div class="card">
            {{-- <pre>{{ json_encode($participant_farming_data, JSON_PRETTY_PRINT) }}</pre> --}}

            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Lists of Farmers Profile</h5>
                {{-- <a href="{{ route('farmers-profile.create') }}"  class="btn btn-secondary">
                    <i class="ri-user-add-line"></i> New Farmers Profile
                </a> --}}
            </div>
            <div class="card-body">
                <table id="baseline" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">Full Name</th>
                            <th data-ordering="false">Address</th>
                            {{-- <th data-ordering="false">Season</th> --}}
                            <th data-ordering="false">Wet Season</th>
                            <th data-ordering="false">Dry Season</th>
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
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@include('baseline-monitoring._includes.script')
@endsection
