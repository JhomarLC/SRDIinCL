@extends('admin.layouts.master')
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
        ['label' => 'Farmers Profile', 'route' => 'farmers-profile.index']
    ])
    @slot('title')
        Update Farmers Profile
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
                        {{ $participant->barangay->name ?? '' }}, {{ $participant->municipality->name ?? '' }}, {{ $participant->province->name ?? '' }}
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
<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Farmers Profile</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form action="#" id="updateFarmersProfileForm" class="form-steps" autocomplete="off">
                    <div class="text-center pt-3 pb-4 mb-1">
                        <h5>Fillout Farmers Profile</h5>
                    </div>
                    <div id="custom-progress-bar" class="progress-nav mb-4">
                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar"
                                    id="pills-personal-info-tab" data-bs-toggle="pill" data-bs-target="#pills-personal-info"
                                    type="button" role="tab" aria-controls="pills-personal-info"
                                    aria-selected="true">1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-trainings-tab" data-bs-toggle="pill" data-bs-target="#pills-trainings"
                                    type="button" role="tab" aria-controls="pills-trainings"
                                    aria-selected="false">2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-other-info-tab" data-bs-toggle="pill" data-bs-target="#pills-other-info"
                                    type="button" role="tab" aria-controls="pills-other-info"
                                    aria-selected="false">3</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-data-ricefarming-tab" data-bs-toggle="pill" data-bs-target="#pills-data-ricefarming"
                                    type="button" role="tab" aria-controls="pills-data-ricefarming"
                                    aria-selected="false">4</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-emergency-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-emergency-contact"
                                    type="button" role="tab" aria-controls="pills-emergency-contact"
                                    aria-selected="false">5</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-training-result-tab" data-bs-toggle="pill" data-bs-target="#pills-training-result"
                                    type="button" role="tab" aria-controls="pills-training-result"
                                    aria-selected="false">6</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        @include('admin.farmers-profile.components.update-tabs.1-tabpanel')
                        @include('admin.farmers-profile.components.update-tabs.2-tabpanel')
                        @include('admin.farmers-profile.components.update-tabs.3-tabpanel')
                        @include('admin.farmers-profile.components.update-tabs.4-tabpanel')
                        @include('admin.farmers-profile.components.update-tabs.5-tabpanel')
                        @include('admin.farmers-profile.components.update-tabs.6-tabpanel')
                    </div>
                    <!-- end tab content -->
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

</div>
@endsection
@section('script')
<!-- password -->
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
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

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>
<script src='{{ URL::asset('build/libs/choices.js/public/assets/scripts/choices.min.js') }}'></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@include('admin.farmers-profile._includes.script')
@include('admin.farmers-profile._includes.update-script')
@endsection
