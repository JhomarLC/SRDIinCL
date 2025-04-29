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
        ['label' => 'Training Events', 'route' => 'training-event-management.index'],
    ])
    @slot('title')
        Training Evaluations
    @endslot
@endcomponent
@include('components.alert')
@include('training-evaluation-management.training-evaluations.components.status-update')


<div class="profile-foreground position-relative mx-n4 mt-n4">
    <div class="profile-wid-bg">
        <img src="{{ URL::asset('build/images/philrice.jpg') }}" alt="" class="profile-wid-img" />
    </div>
</div>
<div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
    <div class="row g-4">
        <!--end col-->
        <div class="col">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ $training_event->formatted_training_date }}</h3>
                <p class="text-white text-opacity-75">{{ $training_event->training_title }}</p>
                <div class="hstack text-white-50 gap-1">
                    <div class="me-2"><i
                            class="ri-map-pin-user-line me-1 text-white text-opacity-75 fs-16 align-middle"></i>{{ $training_event->full_address }}</div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-12 col-lg-auto order-last order-lg-0">
            <div class="row text text-white-50 text-center">
                <div class="col p-2">
                    <h4 class="text-white mb-1">
                        {{-- {{ $average_overall_score == 0 ? 'No Evaluations' : $average_overall_score . ' ' . scoreLabel($average_overall_score) }} --}}
                        {{-- No Training Evaluations --}}
                    </h4>
                    {{-- <p class="fs-14 mb-0">Total Rating</p> --}}
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
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <a style="margin-right: 10px" href="{{ route('training-event-management.index') }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-fill"></i> Back
                </a>
                <div class="mb-2">
                    {{-- <p><strong>Avg. Content Score:</strong> {{ $training_event->avg_content_score ?? 'N/A' }}</p>
                    <p><strong>Avg. Course Score:</strong> {{ $training_event->avg_course_score ?? 'N/A' }}</p>
                    <p><strong>Most Common Goal:</strong> {{ $training_event->most_common_goal_achievement }}</p>
                    <p><strong>Most Common Quality:</strong> {{ $training_event->most_common_overall_quality }}</p> --}}

                    {{-- <h5 class="text-lg mb-1">
                        <strong>Topic:</strong>
                    </h5>

                    <div>
                        <i class="ri-map-pin-fill"></i>
                        <span class="text-muted">
                            {{ $speaker_topic->formatted_topic_date }} at {{ $speaker_topic->full_address }}
                        </span>
                    </div> --}}
                </div>

                <div class="d-flex gap-2 align-items-start">
                    <a href="{{ route('admin-management.export') }}" class="btn btn-success">
                        <i class="ri-file-excel-2-fill"></i> Export
                    </a>
                    <a href="{{ route('training-evaluation-management.create', $training_event->id) }}" class="btn btn-secondary">
                        <i class="ri-file-add-fill"></i> New Evaluation
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table id="eval" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>

                            <th>Training ID</th>
                            <th data-ordering="false">Training Content</th>
                            <th data-ordering="false">Course Management</th>
                            <th data-ordering="false">Course Objectives</th>
                            <th data-ordering="false">Overall Training</th>
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
@include('training-evaluation-management.training-evaluations._includes.script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
