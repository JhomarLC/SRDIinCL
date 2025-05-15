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

                                    <div class="tab-pane fade" id="v-pills-water-management" role="tabpanel" aria-labelledby="v-pills-water-management-tab">
                                        <div>
                                            <h5>Water Management</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12 d-flex align-items-center gap-3">
                                                <label class="form-check-label" for="water-management-nia">Type of Irrigation</label>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-nia" value="nia" checked>
                                                    <label class="form-check-label" for="water-management-nia">NIA</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-supplementary" value="supplementary">
                                                    <label class="form-check-label" for="water-management-supplementary">Supplementary</label>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="text-muted">

                                        <!-- Single Total Cost for NIA -->
                                        <div class="row g-3 mt-1" id="water-management-nia-total-cost">
                                            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                                                <label for="waterManagementNiaTotalCost" class="form-label">NIA Total Amount</label>
                                                <input type="number" class="form-control" id="waterManagementNiaTotalCost" placeholder="Enter Total Cost">
                                            </div>
                                        </div>

                                        <div class="mt-3">

                                            <!-- This is for Supplementary -->
                                            <div class="form-check mb-2" id="water-management-pakyaw-checkbox">
                                                <input type="checkbox" class="form-check-input" id="water-management-pakyaw">
                                                <label class="form-check-label" for="water-management-pakyaw">Package</label>
                                            </div>

                                            <!-- Single Total Cost for Pakyaw -->
                                            <div class="row g-3 mt-1" id="water-management-pakyaw-total-cost" style="display:none;">
                                                <hr class="text-muted">
                                                <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                                                    <label for="waterManagementPakyawTotalCost" class="form-label">Total Cost</label>
                                                    <input type="number" class="form-control" id="waterManagementPakyawTotalCost" placeholder="Enter Total Cost">
                                                </div>
                                            </div>

                                            <hr class="text-muted">

                                            <!-- Regular Inputs -->
                                            <div id="water-management-regular-fields">
                                                <!-- Repeatable Block Starts -->
                                                <div class="row g-3">
                                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                                        <label class="form-label mb-0">1st Irrigation</label>
                                                        <a href="#">
                                                            <button class="btn btn-secondary">
                                                                <i class="ri-file-add-fill"></i> Add Irrigation
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Irrigation fee (NIS/CIS) </label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Fuel cost (STW), liters</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Irrigation</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Meals and Snacks</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
                                                </button>
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->


                                    <div class="tab-pane fade" id="v-pills-pest-management" role="tabpanel"
                                        aria-labelledby="v-pills-pest-management-tab">
                                        <div>
                                            <h5>Pest Management</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>
                                        <div>
                                            <div class="row g-3">
                                                <div class="col-12 d-flex justify-content-between align-items-center">
                                                    <label class="form-label mb-0">Pesticide Details</label>
                                                    <a href="#">
                                                        <button class="btn btn-secondary">
                                                            <i class=" ri-add-line"></i> Type of Pesticide
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                            <hr class="text-muted">
                                        </div>

                                        <div>
                                            <!-- Regular Inputs -->
                                            <div id="seedbed-fertilization-regular-fields">
                                                <!-- Repeatable Block Starts -->
                                                <div class="block">
                                                    <div class="mt-2 row g-3 align-items-center mb-2">
                                                        <div class="col-6">
                                                            <label class="form-label">Type of Pesticide</label>
                                                            <select class="form-control select2" aria-label="Default select example">
                                                                <option selected disabled hidden>-- SELECT TYPE OF PESTICIDE --</option>
                                                                <option value="1">Complete (14-14-14-24S)</option>
                                                                <option value="2">Ammonium Phosphate (16-20-0)</option>
                                                                <option value="3">Ammonium Sulphate (21-0-0)</option>
                                                                <option value="3">Muriate of Potash (0-0-60)</option>
                                                                <option value="3">Urea (46-0-0)</option>
                                                                <option value="3">Foliar fertilizers</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label">Brand Name</label>
                                                            <input type="text" class="form-control" placeholder="Brand Name" />
                                                        </div>
                                                    </div>

                                                    <div class="row g-3 mt-1">
                                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                                            <label class="form-label mb-0"></label>
                                                            <a href="#">
                                                                <button class="btn btn-secondary">
                                                                    <i class=" ri-add-line"></i> Application
                                                                </button>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3 p-3 mb-3 rounded bg-light">
                                                        <label class="form-label mb-0">1st Application</label>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center soaking-qty" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost soaking-unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost soaking-total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-3 p-3 mb-3 rounded bg-light">
                                                        <label class="form-label mb-0">2nd Application</label>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center soaking-qty" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost soaking-unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost soaking-total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Chemical Application</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Manual Weeding</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Meals and Snacks</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">
                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-water-management-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
                                                </button>
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-harvest-management-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->

                                    <div class="tab-pane fade" id="v-pills-harvest-management" role="tabpanel" aria-labelledby="v-pills-harvest-management-tab">
                                        <div>
                                            <h5>Harvest Management</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-12 d-flex align-items-center gap-3">
                                                <label class="form-check-label" for="water-management-nia">Type of Harvesting</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-supplementary" value="supplementary">
                                                    <label class="form-check-label" for="water-management-supplementary">Manual</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-nia" value="nia" checked>
                                                    <label class="form-check-label" for="water-management-nia">Mechanical</label>
                                                </div>

                                            </div>
                                        </div>
                                        <hr class="text-muted">

                                        <!-- Single for Mechanical -->
                                        <div class="block">
                                            <div class="row g-3 mt-2">
                                                <div class="col-12">
                                                    <label class="form-label">Mechanical</label>
                                                </div>
                                            </div>
                                            <div class="row p-3 mb-3 rounded bg-light">
                                                <div class="col-3">
                                                    <label class="form-label text-muted">Bags</label>
                                                    <div class="input-step step-primary full-width d-flex">
                                                        <button type="button" class="minus">–</button>
                                                        <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                        <button type="button" class="plus">+</button>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label text-muted">Avg. Bag Weight</label>
                                                    <input type="number" class="form-control unit-cost" placeholder="Avg Bag Weight" />
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label text-muted">Price per Kilo</label>
                                                    <input type="number" class="form-control unit-cost" placeholder="Price per Kilo" />
                                                </div>
                                                <div class="col-3">
                                                    <label class="form-label text-muted">Total Cost</label>
                                                    <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="text-muted">

                                        <div class="mt-3">

                                            <!-- This is for Supplementary -->
                                            <div class="form-check mb-2" id="water-management-pakyaw-checkbox">
                                                <input type="checkbox" class="form-check-input" id="water-management-pakyaw">
                                                <label class="form-check-label" for="water-management-pakyaw">Package</label>
                                            </div>

                                            <!-- Single Total Cost for Pakyaw -->
                                            <div class="row g-3 mt-1" id="water-management-pakyaw-total-cost" style="display:none;">
                                                <hr class="text-muted">
                                                <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                                                    <label for="waterManagementPakyawTotalCost" class="form-label">Total Cost</label>
                                                    <input type="number" class="form-control" id="waterManagementPakyawTotalCost" placeholder="Enter Total Cost">
                                                </div>
                                            </div>

                                            <hr class="text-muted">

                                            <!-- Regular Inputs -->
                                            <div id="water-management-regular-fields">
                                                <!-- Repeatable Block Starts -->

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Manual Harvesting</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Threshing</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Labor: Hauling</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Sacks, ordinary</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Sacks, laminated</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Twine, bundle</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Twine needle, pc</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Soft Thread, roll</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Needle, pc</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3 mt-2">
                                                        <div class="col-12">
                                                            <label class="form-label">Meals and Snacks</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">
                                                <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
                                                    <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
                                                </button>
                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->

                                    <div class="tab-pane fade" id="v-pills-other-expenses" role="tabpanel" aria-labelledby="v-pills-other-expenses-tab">
                                        <div>
                                            <h5>Other Expenses</h5>
                                            <p class="text-muted">Fill all information below</p>
                                        </div>

                                        <div class="mt-3">
                                            <!-- Regular Inputs -->
                                            <div id="seedbed-prep-regular-fields">
                                                <!-- Repeatable Block Starts -->
                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Hauling</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Bags</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Permanent Hired Labor Fee</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class=" row col-12">
                                                            <div class="col-4">
                                                                <label class="form-label text-muted">Bags</label>
                                                                <div class="input-step step-primary full-width d-flex">
                                                                    <button type="button" class="minus">–</button>
                                                                    <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                    <button type="button" class="plus">+</button>
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="form-label text-muted">Avg. Bag Weight (kg)</label>
                                                                <input type="number" class="form-control unit-cost" placeholder="Avg Bag Weight" />
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="form-label text-muted">Price per Kilo</label>
                                                                <input type="number" class="form-control unit-cost" placeholder="Price per Kilo" />
                                                            </div>
                                                        </div>

                                                        <div class="row col-12 mt-2">
                                                            <div class="col-6">
                                                                <label class="form-label text-muted">Percent Share of Total Bags Harvested </label>
                                                                <input type="number" class="form-control unit-cost" placeholder="Percent Share of Total Bags Harvested" />
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label text-muted">Total Cost</label>
                                                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <hr class="text-muted">
                                                <!-- End of each block -->

                                                <div class="block">
                                                    <div class="row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label">Land Ownership Fee (amilyar)</label>
                                                        </div>
                                                    </div>
                                                    <div class="row p-3 mb-3 rounded bg-light">
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Qty</label>
                                                            <div class="input-step step-primary full-width d-flex">
                                                                <button type="button" class="minus">–</button>
                                                                <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                                                                <button type="button" class="plus">+</button>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Unit Cost</label>
                                                            <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                                                        </div>
                                                        <div class="col-4">
                                                            <label class="form-label text-muted">Total Cost</label>
                                                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr class="text-muted">
                                                <!-- End of each block -->

                                            </div>

                                            <div class="d-flex align-items-start gap-3 mt-4">

                                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                                                    <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab pane -->

                                    <script>
                                         document.addEventListener('DOMContentLoaded', function () {

                                        const radioNIA = document.getElementById('water-management-nia');
                                        const radioSupplementary = document.getElementById('water-management-supplementary');

                                        const niaTotalCost = document.getElementById('water-management-nia-total-cost');

                                        const pakyawCheckboxContainer = document.getElementById('water-management-pakyaw-checkbox');
                                        const pakyawCheckbox = document.getElementById('water-management-pakyaw');
                                        const pakyawTotalCost = document.getElementById('water-management-pakyaw-total-cost');

                                        const regularFields = document.getElementById('water-management-regular-fields');

                                        function updateDisplay() {
                                            if (radioNIA.checked) {
                                                // Show only the NIA total cost
                                                niaTotalCost.style.display = 'block';
                                                pakyawCheckboxContainer.style.display = 'none';
                                                pakyawTotalCost.style.display = 'none';
                                                regularFields.style.display = 'none';
                                            } else if (radioSupplementary.checked) {
                                                // Hide NIA total cost
                                                niaTotalCost.style.display = 'none';
                                                pakyawCheckboxContainer.style.display = 'block';

                                                if (pakyawCheckbox.checked) {
                                                    pakyawTotalCost.style.display = 'block';
                                                    regularFields.style.display = 'none';
                                                } else {
                                                    pakyawTotalCost.style.display = 'none';
                                                    regularFields.style.display = 'block';
                                                }
                                            }
                                        }

                                        // Add event listeners
                                        radioNIA.addEventListener('change', updateDisplay);
                                        radioSupplementary.addEventListener('change', updateDisplay);
                                        pakyawCheckbox.addEventListener('change', updateDisplay);

                                        // Initial display setup
                                        updateDisplay();
                                        });
                                    </script>
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

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>
@include('baseline-monitoring._includes.script')
@include('baseline-monitoring._includes.logic')
<script src='{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
