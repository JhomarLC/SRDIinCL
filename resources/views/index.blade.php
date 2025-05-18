@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" />
<!-- In <head> -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<!-- select2  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
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
    <div class="col-xl-4 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">AVG. PRE-TEST</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ number_format($trainingAverages->avg_pre_test, 2) }}"></span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                <i data-feather="clipboard" class="text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-4 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">AVG. POST-TEST</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ number_format($trainingAverages->avg_post_test, 2) }}">0</span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                <i data-feather="award" class="text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> <!-- end col-->

    <div class="col-xl-4 col-md-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">Gain in Knowledge</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ number_format($trainingAverages->avg_gik, 2) }}">0</span> %</h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                <i data-feather="target" class="text-success"></i>
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
                <form method="GET" action="{{ route('dashboard') }}" class="d-flex flex-wrap gap-3 align-items-end mb-5">
                    <div class="flex-grow-1"></div>
                    <div class="d-flex flex-column" style="min-width: 250px;">
                        <label for="province" class="form-label">Filter Province</label>
                        <select name="province" id="province" class="form-control select2">
                            <option value="all" {{ request('province') == 'all' ? 'selected' : '' }}>-- ALL PROVINCE --</option>
                            @foreach($provinces as $province)
                                <option value="{{ $province->name }}" {{ request('province') == $province->name ? 'selected' : '' }}>
                                    {{ $province->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex flex-column" style="min-width: 250px;">
                        <label for="municipality" class="form-label">Filter Municipality</label>
                         <select name="municipality" id="municipality" class="form-control select2">
                            <option value="all" {{ request('municipality') == 'all' ? 'selected' : '' }}>-- ALL MUNICIPALITY --</option>
                            @foreach($municipalities as $municipality)
                                @if(request('province') == 'all' || request('province') == null || ($municipality->province && $municipality->province->name == request('province')))
                                    <option value="{{ $municipality->name }}" {{ request('municipality') == $municipality->name ? 'selected' : '' }}>
                                        {{ $municipality->name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-filter-fill"></i> Filter
                    </button>
                </form>
                <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active p-4" data-bs-toggle="tab" href="#farmers-profile" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-home-variant"></i></span>
                            <span class="d-none d-sm-block fs-16">
                                <i class="ri-group-fill"></i> Farmers Profile
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-4" data-bs-toggle="tab" href="#speaker-evaluations" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-account"></i></span>
                            <span class="d-none d-sm-block fs-16">
                                <i class="ri-user-voice-fill"></i> Speaker Evaluations
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-4" data-bs-toggle="tab" href="#training-evaluations" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block fs-16">
                                <i class="ri-booklet-fill"></i> Training Evaluations
                            </span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link p-4" data-bs-toggle="tab" href="#baseline-monitoring" role="tab">
                            <span class="d-block d-sm-none"><i class="mdi mdi-email"></i></span>
                            <span class="d-none d-sm-block fs-16">
                                <i class="ri-bar-chart-grouped-fill"></i> Baseline Monitoring
                            </span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content text-muted">
                    <div class="tab-pane active" id="farmers-profile" role="tabpanel">
                        @include('dashboard-tab.farmers-profile-tab')
                    </div>
                    <div class="tab-pane" id="speaker-evaluations" role="tabpanel">
                        <h6>Speaker Evaluations</h6>

                    </div>
                    <div class="tab-pane" id="training-evaluations" role="tabpanel">
                        <h6>Training Evaluations</h6>

                    </div>
                    <div class="tab-pane" id="baseline-monitoring" role="tabpanel">
                        <h6>Baseline Monitoring</h6>

                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>

@endsection

@section('script')
<!-- apexcharts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

@include('_includes.script')
@endsection
