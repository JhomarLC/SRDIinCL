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
        ['label' => 'Admin', 'route' => 'admin.dashboard'],
        ['label' => 'Speakers', 'route' => 'speaker-management.index'],
    ])
    @slot('title')
        Speaker Topics
    @endslot
@endcomponent
@include('components.alert')
@include('admin.speaker-management.speaker-topics.components.modal-create')
@include('admin.speaker-management.speaker-topics.components.modal-update')
@include('admin.speaker-management.speaker-topics.components.status-update')


<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ URL::asset('build/images/philrice.jpg') }}" alt="" class="profile-wid-img" />
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
                <h3 class="text-white mb-1">{{ $speaker->full_name }}</h3>
                <p class="text-white text-opacity-75">Speaker</p>
                {{-- <div class="hstack text-white-50 gap-1">
                    <div class="me-2"><i
                            class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>Dipaculao, Aurora</div>
                </div> --}}
            </div>
        </div>
        <!--end col-->
        <div class="col-12 col-lg-auto order-last order-lg-0">
            <div class="row text text-white-50 text-center">
                <div class="col p-2">
                    <h4 class="text-white mb-1">
                        {{ is_null($speaker->overall_evaluation_score) ? 'No Evaluations' : $speaker->overall_evaluation_score . ' ' . scoreLabel($speaker->overall_evaluation_score) }}
                    </h4>
                    <p class="fs-14 mb-0">Total Rating</p>
                </div>
            </div>
        </div>
        <!--end col-->

    </div>
    <!--end row-->
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <a style="margin-right: 10px" href="{{ route('speaker-management.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-fill"></i> Back
                </a>
                <h5 class="card-title mb-0 flex-grow-1">Lists of Speaker's Topics</h5>

                <a style="margin-right: 10px" href="{{ route('admin-management.export') }}">
                    <button class="btn btn-success"><i class="ri-file-excel-2-fill"></i> Export</button>
                </a>
                <button  class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addnewtopicmodal">
                    <i class="ri-chat-new-fill"></i> New Topic
                </button>
            </div>
            <div class="card-body">
                <table id="topics" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th>Topic Discussed</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Average Evaluation</th>
                            <th>Status</th>
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
@include('admin.speaker-management.speaker-topics._includes.script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
