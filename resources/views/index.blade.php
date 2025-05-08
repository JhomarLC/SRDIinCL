@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
<!-- In <head> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map { height: 600px; }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<div class="row">
    <div class="col">
        <div class="h-100">
            <div class="row mb-3 pb-1">
                <div class="col-12">
                    <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                        <div class="flex-grow-1">
                            @php
                                $user = Auth::user();
                                $greeting = 'Good Morning';

                                if (now()->hour >= 12 && now()->hour < 18) {
                                    $greeting = 'Good Afternoon';
                                } elseif (now()->hour >= 18) {
                                    $greeting = 'Good Evening';
                                }
                            @endphp

                            <h4 class="fs-16 mb-1">
                                {{ $greeting }},
                                @if ($user->isAdmin())
                                    Admin!
                                @elseif ($user->isProvincialAew())
                                    Provincial AEW!
                                @elseif ($user->isMunicipalAew())
                                    Municipal AEW!
                                @else
                                    {{ $user->first_name }}!
                                @endif
                            </h4>

                            <p class="text-muted mb-0">
                                Here's what's happening with your dashboard today.
                            </p>
                        </div>
                    </div>
                    <!-- end card header -->
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div> <!-- end .h-100-->
    </div> <!-- end col -->
</div>

<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Farmers</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ $totalFarmers }}"></span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-circle fs-2">
                                <i data-feather="users" class="text-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Speaker Evaluations</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="791">0</span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-circle fs-2">
                                <i data-feather="clipboard" class="text-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Training Evaluations</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="1203">0</span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-circle fs-2">
                                <i data-feather="clipboard" class="text-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-3 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Baseline Records</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ $totalFarmers * 2 }}"></span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-info rounded-circle fs-2">
                                <i data-feather="activity" class="text-dark"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="col-xxl-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-success" role="tablist">
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link active" data-bs-toggle="tab" href="#farmers-profile" role="tab">
                            <i class="ri-group-fill"></i> Farmers Profile
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#speaker-evaluations" role="tab">
                            <i class="ri-user-voice-fill"></i> Speaker Evaluations
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#training-evaluations" role="tab">
                            <i class="ri-booklet-fill"></i> Training Evaluations
                        </a>
                    </li>
                    <li class="nav-item waves-effect waves-light">
                        <a class="nav-link" data-bs-toggle="tab" href="#baseline-monitoring" role="tab">
                            <i class="ri-bar-chart-grouped-fill"></i> Baseline Monitoring
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->

            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!--end col-->
</div>
<div class="tab-content text-muted">
    <div class="tab-pane active" id="farmers-profile" role="tabpanel">
        @include('dashboard-tab.farmers-profile-tab')
    </div>
    <div class="tab-pane" id="speaker-evaluations" role="tabpanel">

    </div>
    <div class="tab-pane" id="training-evaluations" role="tabpanel">

    </div>
    <div class="tab-pane" id="baseline-monitoring" role="tabpanel">

    </div>
</div>
@endsection

@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js')}}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.ajax"></script>
<!-- Before </body> -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@include('_includes.script')
@endsection
