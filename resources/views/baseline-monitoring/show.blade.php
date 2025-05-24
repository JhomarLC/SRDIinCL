@extends('layouts.master')
@section('title') @lang('translation.dashboards') @endsection
@section('css')
{{-- <link href="{{ URL::asset('build/libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" type="text/css" /> --}}
<!--datatable css-->
<link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
<!--datatable responsive css-->
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<!--profile css-->
<link rel="stylesheet" href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}">

@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'dashboard'],
        ['label' => 'Baseline Monitoring', 'route' => 'baseline-monitoring.index'],
    ])
    @slot('title')
        Baseline Monitoring Data
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
    </div>
    <!--end row-->
</div>
<div class="row">
    <div class="col-lg-12">
        <div>
            <div class="d-flex profile-wrapper">

                <!-- Nav tabs -->
                <ul class="nav nav-pills animation-nav profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link fs-14 active" data-bs-toggle="tab" href="#profile-tab" role="tab">
                            <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span
                                class="d-none d-md-inline-block">Dry Season</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fs-14" data-bs-toggle="tab" href="#data_riceFarming_tab" role="tab">
                            <i class="ri-list-unordered d-inline-block d-md-none"></i> <span
                                class="d-none d-md-inline-block">Wet Season</span>
                        </a>
                    </li>
                </ul>
                {{-- <div class="flex-shrink-0">
                    <a href="pages-profile-settings" class="btn btn-success"><i
                            class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                </div> --}}
            </div>
            <!-- Tab panes -->
            <div class="tab-content pt-4 text-muted">
                <div class="tab-pane active" id="profile-tab" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                                <h5 class="card-title mb-2 mb-md-0">Dry Season</h5>
                                <a href="{{ route('baseline-monitoring.create', [$participant->id, 'dry-season'])}}" class="btn btn-secondary">
                                    <i class="ri-add-fill"></i>
                                    @if (empty($drySeasonData['activities']))
                                        Dry Season Baseline Monitoring
                                    @else
                                        Update Data
                                    @endif
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th rowspan="2">ACTIVITIES</th>
                                            <th rowspan="2">PARTICULARS</th>
                                            <th colspan="3">EXPENSES</th>
                                        </tr>
                                        <tr>
                                            <th>QTY</th>
                                            <th>UNIT COST</th>
                                            <th>TOTAL COST</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($drySeasonData['activities']))
                                            @foreach ($drySeasonData['activities'] as $activity)
                                                @php
                                                    $category = strtoupper($activity['category']);
                                                    $isIrrigation = strtolower($category) === 'water management';
                                                    $isPakyaw = $activity['is_pakyaw'];
                                                    $details = $activity['details'] ?? [];
                                                    $irrigationEvents = $activity['irrigation_events'] ?? [];
                                                @endphp

                                                {{-- Irrigation Events --}}
                                                @if ($isIrrigation && is_array($irrigationEvents) && count($irrigationEvents) > 0)
                                                    <tr>
                                                        <td rowspan="{{ count($irrigationEvents) }}">
                                                            <strong>{{ $category }}</strong>
                                                        </td>
                                                        @php $first = true; @endphp
                                                        @foreach ($irrigationEvents as $event)
                                                            @if (!$first) <tr> @endif
                                                                <td>{{ $event['description'] ?? 'Irrigation Event' }}</td>
                                                                <td class="text-end">{{ $event['qty'] ?? '—' }}</td>
                                                                <td class="text-end">₱{{ number_format($event['unit_cost'] ?? 0, 2) }}</td>
                                                                <td class="text-end">₱{{ number_format($event['total_cost'] ?? 0, 2) }}</td>
                                                            </tr>
                                                            @php $first = false; @endphp
                                                        @endforeach

                                                {{-- Pakyaw Summary --}}
                                                @elseif ($isPakyaw)
                                                    <tr>
                                                        <td><strong>{{ $category }}</strong></td>
                                                        <td class="text-muted">Pakyaw labor cost</td>
                                                        <td class="text-end">—</td>
                                                        <td class="text-end">—</td>
                                                        <td class="text-end">₱{{ number_format($activity['total_cost'], 2) }}</td>
                                                    </tr>

                                                {{-- Details List --}}
                                                @elseif (is_array($details) && count($details) > 0)
                                                    <tr>
                                                        <td rowspan="{{ count($details) }}">
                                                            <strong>{{ $category }}</strong>
                                                        </td>
                                                        @php $first = true; @endphp
                                                        @foreach ($details as $detail)
                                                            @if (!$first) <tr> @endif
                                                                <td>{{ $detail['activity'] }}</td>
                                                                <td class="text-end">{{ $detail['qty'] }}</td>
                                                                <td class="text-end">₱{{ number_format($detail['unit_cost'], 2) }}</td>
                                                                <td class="text-end">₱{{ number_format($detail['total_cost'], 2) }}</td>
                                                            </tr>
                                                            @php $first = false; @endphp
                                                        @endforeach

                                                {{-- Fallback --}}
                                                @else
                                                    <tr>
                                                        <td><strong>{{ $category }}</strong></td>
                                                        <td colspan="4" class="text-muted">No breakdown available</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No records found for this season.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card-->
                </div>
                <!--end tab-pane-->

                <div class="tab-pane" id="data_riceFarming_tab" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                                <h5 class="card-title mb-2 mb-md-0">Wet Season</h5>
                                <a href="{{ route('baseline-monitoring.create', [$participant->id, 'wet-season'])}}" class="btn btn-secondary">
                                    <i class="ri-add-fill"></i>
                                    @if (empty($drySeasonData['activities']))
                                        Wet Season Baseline Monitoring
                                    @else
                                        Update Data
                                    @endif
                                </a>

                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-light text-center">
                                        <tr>
                                            <th rowspan="2">ACTIVITIES</th>
                                            <th rowspan="2">PARTICULARS</th>
                                            <th colspan="3">EXPENSES</th>
                                        </tr>
                                        <tr>
                                            <th>QTY</th>
                                            <th>UNIT COST</th>
                                            <th>TOTAL COST</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($wetSeasonData['activities']) && is_array($wetSeasonData['activities']) && count($wetSeasonData['activities']) > 0)
                                            @foreach ($wetSeasonData['activities'] as $activity)
                                                @php
                                                    $category = strtoupper($activity['category']);
                                                    $isIrrigation = strtolower($category) === 'water management';
                                                    $isPakyaw = $activity['is_pakyaw'];
                                                    $details = $activity['details'] ?? [];
                                                    $irrigationEvents = $activity['irrigation_events'] ?? [];
                                                @endphp

                                                {{-- Irrigation Events --}}
                                                @if ($isIrrigation && is_array($irrigationEvents) && count($irrigationEvents) > 0)
                                                    <tr>
                                                        <td rowspan="{{ count($irrigationEvents) }}">
                                                            <strong>{{ $category }}</strong>
                                                        </td>
                                                        @php $first = true; @endphp
                                                        @foreach ($irrigationEvents as $event)
                                                            @if (!$first) <tr> @endif
                                                                <td>{{ $event['description'] ?? 'Irrigation Event' }}</td>
                                                                <td class="text-end">{{ $event['qty'] ?? '—' }}</td>
                                                                <td class="text-end">₱{{ number_format($event['unit_cost'] ?? 0, 2) }}</td>
                                                                <td class="text-end">₱{{ number_format($event['total_cost'] ?? 0, 2) }}</td>
                                                            </tr>
                                                            @php $first = false; @endphp
                                                        @endforeach

                                                {{-- Pakyaw Summary --}}
                                                @elseif ($isPakyaw)
                                                    <tr>
                                                        <td><strong>{{ $category }}</strong></td>
                                                        <td class="text-muted">Pakyaw labor cost</td>
                                                        <td class="text-end">—</td>
                                                        <td class="text-end">—</td>
                                                        <td class="text-end">₱{{ number_format($activity['total_cost'], 2) }}</td>
                                                    </tr>

                                                {{-- Details List --}}
                                                @elseif (is_array($details) && count($details) > 0)
                                                    <tr>
                                                        <td rowspan="{{ count($details) }}">
                                                            <strong>{{ $category }}</strong>
                                                        </td>
                                                        @php $first = true; @endphp
                                                        @foreach ($details as $detail)
                                                            @if (!$first) <tr> @endif
                                                                <td>{{ $detail['activity'] }}</td>
                                                                <td class="text-end">{{ $detail['qty'] }}</td>
                                                                <td class="text-end">₱{{ number_format($detail['unit_cost'], 2) }}</td>
                                                                <td class="text-end">₱{{ number_format($detail['total_cost'], 2) }}</td>
                                                            </tr>
                                                            @php $first = false; @endphp
                                                        @endforeach

                                                {{-- Fallback --}}
                                                @else
                                                    <tr>
                                                        <td><strong>{{ $category }}</strong></td>
                                                        <td colspan="4" class="text-muted">No breakdown available</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No records found for this season.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!--end tab-pane-->
            </div>
            <!--end tab-content-->
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

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<!-- apexcharts -->
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/js/jsvectormap.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/jsvectormap/maps/world-merc.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js')}}"></script>
<!-- dashboard init -->
<script src="{{ URL::asset('build/js/pages/dashboard-ecommerce.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@include('farmers-profile._includes.script')
@endsection
