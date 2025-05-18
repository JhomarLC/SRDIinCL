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
<!-- select2  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'dashboard'],
        ['label' => 'Baseline Monitoring', 'route' => 'baseline-monitoring.index']
    ])
    @slot('title')
        Create Baseline Monitoring
    @endslot
@endcomponent

<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ URL::asset('images/philrice.jpg') }}" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <div class="col-auto">
            <div class="avatar-lg">
                <img src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('build/images/users/user-dummy-img.jpg') }} @endif"
                    alt="user-img" class="img-thumbnail rounded-circle" />
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ $participant->full_name }}</h3>
                <p class="text-white text-opacity-75">Farmer</p>
                <div class="hstack text-white-50 gap-1">
                    <div class="me-2">
                        <i class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>
                        {{ $participant->full_address }}
                    </div>
                </div>

            </div>
        </div>
        <!--end col-->
        {{-- <div class="col-12 col-lg-auto order-last order-lg-0">
            <div class="row text text-white-50 text-center">
                <div class="col-6 p-2">
                    <h4 class="text-white mb-1">{{ $participant->trainings->count() }}</h4>
                    <p class="fs-14 mb-0">Total No. of Trainings</p>
                </div>

                <div class="col-6 p-2">
                    <h4 class="text-white mb-1">{{ $participant->recent_gik ?? 'N/A' }}%</h4>
                    <p class="fs-14 mb-0">Recent GIK</p>
                </div>
            </div>
        </div> --}}
        <!--end col-->

    </div>
    <!--end row-->
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">
                    {{ ucwords(str_replace('-', ' ', $season)) }} Baseline Monitoring
                </h4>
            </div><!-- end card header -->
            <div class="card-body form-steps">
                <form class="vertical-navs-step">
                    <div class="row gy-5">
                        <div class="col-lg-3">
                            <div class="nav flex-column custom-nav nav-pills" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-dry-season-info-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-dry-season-info" type="button" role="tab"
                                    aria-controls="v-pills-dry-season-info" aria-selected="true">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Dry Season Information
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-land-prep-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-land-prep" type="button" role="tab"
                                    aria-controls="v-pills-land-prep" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Land Preparation
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-seeds-prep-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-seeds-prep" type="button" role="tab"
                                    aria-controls="v-pills-seeds-prep" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Seeds Preparation
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-seedbed-prep-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-seedbed-prep" type="button" role="tab"
                                    aria-controls="v-pills-seedbed-prep" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Seedbed Preparation
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-seedbed-fertilization-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-seedbed-fertilization" type="button" role="tab"
                                    aria-controls="v-pills-seedbed-fertilization" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Seedbed Fertilization
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-crop-establishment-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-crop-establishment" type="button" role="tab"
                                    aria-controls="v-pills-crop-establishment" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Crop Establishment
                                    </span>
                                </button>

                                <button class="nav-link" id="v-pills-fertilizer-management-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-fertilizer-management" type="button" role="tab"
                                    aria-controls="v-pills-fertilizer-management" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Fertilizer Management
                                    </span>
                                </button>

                                <button class="nav-link" id="v-pills-water-management-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-water-management" type="button" role="tab"
                                    aria-controls="v-pills-water-management" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Water Management
                                    </span>
                                </button>

                                <button class="nav-link" id="v-pills-pest-management-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-pest-management" type="button" role="tab"
                                    aria-controls="v-pills-pest-management" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Pest Management
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-harvest-management-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-harvest-management" type="button" role="tab"
                                    aria-controls="v-pills-harvest-management" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Harvest Management
                                    </span>
                                </button>
                                <button class="nav-link" id="v-pills-other-expenses-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-other-expenses" type="button" role="tab"
                                    aria-controls="v-pills-other-expenses" aria-selected="false">
                                    <span class="step-title me-2">
                                        <i class="ri-close-circle-fill step-icon me-2"></i> Other Expenses
                                    </span>
                                </button>
                            </div>
                            <!-- end nav -->
                        </div> <!-- end col-->
                        <div class="col-lg-7">
                            <div class="px-lg-4">
                                <div class="tab-content">
                                    @include('baseline-monitoring.components.create-tabs.1-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.2-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.3-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.4-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.5-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.6-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.7-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.8-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.9-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.10-tabpanel')
                                    @include('baseline-monitoring.components.create-tabs.11-tabpanel')

                                    <!-- end tab pane -->
                                </div>
                                <!-- end tab content -->
                            </div>
                        </div>
                        <!-- end col -->

                        <div class="col-lg-2">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fs-14 text-primary mb-0"><i
                                        class="las la-money-check align-middle me-2"></i> Total Expenses</h5>
                                {{-- <span class="badge bg-danger rounded-pill">3</span> --}}
                            </div>
                            <ul class="list-group mb-3">
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Land Preparation </h6>
                                        {{-- <small class="text-muted">Brief description</small> --}}
                                    </div>
                                    <span class="text-muted">2300</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Seedbad Preparation</h6>
                                    </div>
                                    <span class="text-muted">2300</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Seedling Management</h6>
                                    </div>
                                    <span class="text-muted">300</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Crop Establishment</h6>
                                    </div>
                                    <span class="text-muted">300</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                        <h6 class="my-0">Fertilizer Management</h6>
                                    </div>
                                    <span class="text-muted">300</span>
                                </li>
                                {{-- <li class="list-group-item d-flex justify-content-between bg-light">
                                    <div class="text-success">
                                        <h6 class="my-0">Crop Establishment</h6>
                                        <small>−$5 Discount</small>
                                    </div>
                                    <span class="text-success">−2420</span>
                                </li> --}}
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (PHP)</span>
                                    <strong>4520</strong>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- end row -->
                </form>
            </div>
        </div>
        <!-- end -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->
@endsection
@section('script')
<!-- password -->
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>

<script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>

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
<script src="{{ URL::asset('admin-js/create-farmers-profile.js') }}"></script>

<!-- for numbers -->
<script src="{{ URL::asset('build/js/pages/form-input-spin.init.js') }}"></script>

<script src='{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>
@include('baseline-monitoring._includes.script')
@include('baseline-monitoring._includes.logic')
@include('baseline-monitoring._includes.submit')
@endsection
