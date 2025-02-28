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
<meta name="csrf-token" content="{{ csrf_token() }}">

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
@component('admin.admin-management.components.modal-create')
@endcomponent

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h5 class="card-title mb-0 flex-grow-1">Lists of Admins</h5>
                <a style="margin-right: 10px" href="{{ route('admin-management.export') }}">
                    <button class="btn btn-success"><i class="ri-file-excel-2-fill"></i> Export</button>
                </a>
                <button  class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#addnewadminmodal">
                    <i class="ri-user-add-line"></i> New Admin
                </button>
            </div>
            <div class="card-body">
                <table id="admins" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th data-ordering="false">First Name</th>
                            <th data-ordering="false">Last Name</th>
                            <th data-ordering="false">Suffix</th>
                            <th data-ordering="false">Email</th>
                            <th data-ordering="false">Status</th>
                            <!--
                            <th data-ordering="false">Updated</th>
                            <th data-ordering="false">Created</th>
                            -->
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

<script src="{{ URL::asset('build/js/pages/datatables.init.js') }}"></script>

<script src="{{ URL::asset('admin-js/admin.js') }}"></script>

<script>
    $(document).ready(function () {
        $("#admins").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin-management.get-index') }}",
            columns: [
                { data: 'first_name', name: 'first_name' },
                { data: 'last_name', name: 'last_name' },
                { data: 'suffix', name: 'suffix',  orderable: false, searchable: false },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                // { data: 'updated_at', name: 'updated_at' },
                // { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });

    $(document).ready(function () {
        $('#createAdminForm').submit(function (e) {
            e.preventDefault();

            // Clear previous errors
            $('.form-control').removeClass('is-invalid'); // Remove red borders
            $('.invalid-feedback').text(''); // Clear error messages

            let formData = {
                first_name: $('#first_name').val(),
                middle_name: $('#middle_name').val(),
                last_name: $('#last_name').val(),
                suffix: $('#suffix').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('admin-management.store') }}", // Laravel route for storing admin
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $('#addnewadminmodal').modal('hide'); // Hide modal
                        $('#createAdminForm')[0].reset(); // Reset form
                        $('#admins').DataTable().ajax.reload(); // Reload DataTable
                        // alert("Admin added successfully!"); // Show success message
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid'); // Add red border
                            $('#' + key + '_error').text(value); // Display error message
                        });
                    }
                }
            });
        });

        // Remove error message on input
        $('.form-control').on('input', function () {
            $(this).removeClass('is-invalid'); // Remove red border
            $('#' + $(this).attr('id') + '_error').text(''); // Clear error message
        });
    });

</script>

<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
