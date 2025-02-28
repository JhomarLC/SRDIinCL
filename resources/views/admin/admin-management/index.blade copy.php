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
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'admin.dashboard'],
    ])
    @slot('title')
        Admin Account Management
    @endslot
@endcomponent
@component('components.alert')
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Lists of Admins</h5>
                <a style="margin-right: 10px" href="{{ route('admin-management.export') }}">
                    <button class="btn btn-success"><i class="ri-file-excel-2-fill"></i> Export</button>
                </a>
                <a href="{{ route('admin-management.create') }}">
                    <button class="btn btn-secondary"><i class="ri-user-add-line"></i> New Admin</button>
                </a>
            </div>
            <div class="card-body">
                <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">Name</th>
                            <th data-ordering="false">Email</th>
                            <th data-ordering="false">Status</th>
                            <th data-ordering="false">Updated At</th>
                            <th data-ordering="false">Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Disabled</span>
                                @endif
                            </td>
                            <td>{{ $user->updated_at_formatted }}</td>
                            <td>{{ $user->created_at_formatted  }}</td>
                            <td>
                                @if (Auth::user()->id === $user->id)
                                    <a class="btn btn-sm btn-success disabled"  href="#"><i class="ri-edit-fill"></i> Update Account</a>
                                    <button class="btn btn-sm btn-danger disabled"><i class="ri-archive-fill"></i> Deactivate</button>
                                @else
                                    <a class="btn btn-sm btn-success" href="{{ route('admin-management.edit', $user->id) }}"><i class="ri-edit-fill"></i> Update Account</a>
                                    @if ($user->status === 'active')
                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" href="#deactivateAccount{{$user->id}}"><i class="ri-archive-fill"></i> Disable</button>
                                    @elseif ($user->status === 'disabled')
                                        <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" href="#activeAccount{{$user->id}}"><i class="ri-service-fill"></i> Activate</button>
                                    @endif
                                @endif
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade zoomIn" id="activeAccount{{$user->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="deleteRecord-close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mt-2 text-center">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon
                                                src="https://cdn.lordicon.com/lltgvngb.json"
                                                trigger="loop"
                                                colors="primary:#f7b84b,secondary:#f06548"
                                                style="width:100px;height:100px">
                                            </lord-icon>
                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                <h4>Are you Sure ?</h4>
                                                <p class="text-muted mx-4 mb-0">Are you sure you want to activate {{ $user->name }}'s account?</p>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin-management.activate', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn w-sm btn-danger">Yes, Activate It!</button>
                                            </form>

                                        </div>
                                    </div>

                                </div><!-- /.modal-content -->
                            </div>
                        </div>
                        <!--end modal -->

                        <!-- Modal -->
                        <div class="modal fade zoomIn" id="deactivateAccount{{$user->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="deleteRecord-close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mt-2 text-center">
                                            <script src="https://cdn.lordicon.com/lordicon.js"></script>
                                            <lord-icon
                                                src="https://cdn.lordicon.com/lltgvngb.json"
                                                trigger="loop"
                                                colors="primary:#f7b84b,secondary:#f06548"
                                                style="width:100px;height:100px">
                                            </lord-icon>
                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                <h4>Are you Sure ?</h4>
                                                <p class="text-muted mx-4 mb-0">Are you sure you want to disable {{ $user->name }}'s account?</p>
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">Close</button>
                                            <form action="{{ route('admin-management.deactivate', $user->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn w-sm btn-danger">Yes, Disable It!</button>
                                            </form>

                                        </div>
                                    </div>

                                </div><!-- /.modal-content -->
                            </div>
                        </div>
                        <!--end modal -->

                        @endforeach
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

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
