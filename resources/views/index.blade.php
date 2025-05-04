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
                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i
                                    class="ri-arrow-up-line align-middle"></i> {{ $farmersGrowthPercentage }} % </span> vs. previous month</p>
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
                        <p class="mb-0 text-muted"><span class="badge bg-light text-danger mb-0"><i
                                    class="ri-arrow-down-line align-middle"></i> 3.96 % </span> vs. previous month</p>
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
                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i
                                    class="ri-arrow-up-line align-middle"></i> 40.96 % </span> vs. previous month</p>
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
                        <p class="mb-0 text-muted"><span class="badge bg-light text-success mb-0"><i
                                    class="ri-arrow-up-line align-middle"></i> {{ $farmersGrowthPercentage }} % </span> vs. previous month</p>
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
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Sex</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(genderLabels, genderCounts, "Farmers by gender", "gender-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="farmers_by_sex"
                    data-colors='["#c90076", "#2986cc"]'
                    class="apex-charts" dir="ltr"></div>
                    <div id="gender-subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Age Group</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="custom_datalabels_bar" data-colors='["#4CAF50", "#2196F3", "#FFC107", "#FF5722", "#9C27B0"]' class="apex-charts" dir="ltr"></div>
                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
    {{-- <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">PH Vector Map</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="map" style="height: 350px"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div> --}}
    <!-- end col -->
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
