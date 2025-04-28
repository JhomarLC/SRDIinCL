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
        ['label' => 'Speakers', 'route' => 'speaker-management.index'],
    ])
    @slot('title')
        Speaker Evaluations
    @endslot
@endcomponent
@include('components.alert')
@include('speaker-management.speaker-topics.speaker-evaluations.components.status-update')


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
                        {{ $average_overall_score == 0 ? 'No Evaluations' : $average_overall_score . ' ' . scoreLabel($average_overall_score) }}
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
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <a style="margin-right: 10px" href="{{ route('speaker-topics.index', $speaker_topic->id) }}" class="btn btn-secondary">
                    <i class="ri-arrow-left-fill"></i> Back
                </a>
                <div class="mb-2">
                    <h5 class="text-lg mb-1">
                        <strong>Topic:</strong> {{ $label }}
                    </h5>

                    <div>
                        <i class="ri-map-pin-fill"></i>
                        <span class="text-muted">
                            {{ $speaker_topic->formatted_topic_date }} at {{ $speaker_topic->full_address }}
                        </span>
                    </div>
                </div>

                <div class="d-flex gap-2 align-items-start">
                    <a href="{{ route('admin-management.export') }}" class="btn btn-success">
                        <i class="ri-file-excel-2-fill"></i> Export
                    </a>
                    <a href="{{ route('speaker-eval.create', [$speaker->id, $speaker_topic->id]) }}" class="btn btn-secondary">
                        <i class="ri-file-add-fill"></i> New Evaluation
                    </a>
                </div>
            </div>

            <div class="d-flex mt-2" style="margin-left: 20px">
                <p class="flex-grow-1 mb-0"><strong>K </strong>- Knowledge</p>
                <p class="flex-grow-1 mb-0"><strong>TM</strong> - Teaching Method</p>
                <p class="flex-grow-1 mb-0"><strong>AV</strong> - Audio Visual</p>
                <p class="flex-grow-1 mb-0"><strong>C </strong>- Clarity</p>
            </div>
            <div class="card-header d-flex">
                <p class="flex-grow-1 mb-0"><strong>QH</strong> - Question Handling</p>
                <p class="flex-grow-1 mb-0"><strong>AC</strong> - Audience Connection</p>
                <p class="flex-grow-1 mb-0"><strong>CR</strong> - Content Relevance</p>
                <p class="flex-grow-1 mb-0"><strong>GA</strong> - Goal Achievement</p>
            </div>
            <div class="card-body">
                <table id="eval" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">Name</th>
                            <th data-ordering="false">K</th>
                            <th data-ordering="false">TM</th>
                            <th data-ordering="false">AV</th>
                            <th data-ordering="false">C</th>
                            <th data-ordering="false">QH</th>
                            <th data-ordering="false">AC</th>
                            <th data-ordering="false">CR</th>
                            <th data-ordering="false">GA</th>
                            {{-- <th data-ordering="false">Total Rating</th> --}}
                            <th data-ordering="false">Additional Feedback</th>
                            <th data-ordering="false">Overall Score</th>
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
@include('speaker-management.speaker-topics.speaker-evaluations._includes.script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
