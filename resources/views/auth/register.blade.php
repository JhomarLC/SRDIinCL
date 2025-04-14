@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('css')
<!-- select2  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}" /> <!-- 'classic' theme -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}" /> <!-- 'monolith' theme -->
<link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}" /> <!-- 'nano' theme -->

<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@include('components.alert')
<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg"  id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-1 text-white">
                        <div class="d-inline-block auth-logo" style="font-size:xx-large; font-weight:bold;">
                            <!--<a href="index" class="d-inline-block auth-logo">
                                <img src="{{ URL::asset('build/images/logo-light.png')}}" alt="" height="20">
                            </a>-->
                            SRDI in CL
                        </div>
                        <p class="fs-15 fw-medium">Scaling Rice Development in Initiatives in CL</p>
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-12 col-lg-10 col-xl-10 col-xxl-10">
                    <div class="card card-lg mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                {{-- <h5 class="text-primary">Hi, Welcome Back !</h5> --}}
                                <p class="text-muted">Sign up to continue to SRDI in CL.</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="row g-3">
                                        <!-- Name Fields -->
                                        <div class="col-xxl-3">
                                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                                   name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="Enter first name">
                                            @error('first_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-3">
                                            <label for="middle_name" class="form-label">Middle Name</label>
                                            <input type="text" class="form-control @error('middle_name') is-invalid @enderror"
                                                   name="middle_name" id="middle_name" value="{{ old('middle_name') }}" placeholder="Enter middle name">
                                            @error('middle_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-3">
                                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                                   name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Enter last name">
                                            @error('last_name')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-3">
                                            <label for="suffix" class="form-label">Suffix</label>
                                            <input type="text" class="form-control @error('suffix') is-invalid @enderror"
                                                   name="suffix" id="suffix" value="{{ old('suffix') }}" placeholder="Enter suffix">
                                            @error('suffix')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <!-- Email -->
                                        <div class="col-xxl-12">
                                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                   name="email" id="email" value="{{ old('email') }}" placeholder="Enter email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <!-- Password -->
                                        <div class="col-xxl-6">
                                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   name="password" id="password" placeholder="Enter password">
                                            @error('password')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <hr>

                                        <!-- Region to Barangay -->
                                        <div class="col-xxl-6">
                                            <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('region') is-invalid @enderror" id="region" name="region">
                                                <option selected disabled hidden>-- SELECT REGION --</option>
                                            </select>
                                            @error('region')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('province') is-invalid @enderror" id="province" name="province" disabled>
                                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                                            </select>
                                            @error('province')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('municipality') is-invalid @enderror" id="municipality" name="municipality" disabled>
                                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                                            </select>
                                            @error('municipality')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('barangay') is-invalid @enderror" id="barangay" name="barangay" disabled>
                                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                                            </select>
                                            @error('barangay')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <hr>

                                        <!-- Contact and Dates -->
                                        <div class="col-xxl-6">
                                            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('contact_number') is-invalid @enderror"
                                                   name="contact_number" id="contact_number" value="{{ old('contact_number') }}" placeholder="Contact Number">
                                            @error('contact_number')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                                   name="start_date" id="start_date" value="{{ old('start_date') }}">
                                            @error('start_date')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <!-- Position and Employment -->
                                        <div class="col-xxl-6">
                                            <label for="position_id" class="form-label">Position <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('position_id') is-invalid @enderror" id="position_id" name="position_id">
                                                <option selected disabled hidden>-- SELECT POSITION --</option>
                                                @foreach ($positions as $position)
                                                    <option value="{{ $position->id }}" {{ old('position_id') == $position->id ? 'selected' : '' }}>
                                                        {{ $position->position_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('position_id')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <div class="col-xxl-6">
                                            <label for="employment_type_id" class="form-label">Employment Type <span class="text-danger">*</span></label>
                                            <select class="form-control select2 @error('employment_type_id') is-invalid @enderror" id="employment_type_id" name="employment_type_id">
                                                <option selected disabled hidden>-- SELECT EMPLOYMENT TYPE --</option>
                                                @foreach ($employment_types as $type)
                                                    <option value="{{ $type->id }}" {{ old('employment_type_id') == $type->id ? 'selected' : '' }}>
                                                        {{ $type->employment_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employment_type_id')
                                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>

                                        <hr>

                                        <!-- Submit Button -->
                                        <div class="col-xxl-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <a href="{{ route('login') }}" class="btn btn-light">Back to Login</a>
                                                <button type="submit" class="btn btn-success">
                                                    <i class="ri-user-add-line"></i> Register
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                    <div class="mt-4 text-center">
                        <p class="mb-0">Already have an account ? <a href="{{ route('login') }}" class="fw-semibold text-primary text-decoration-underline"> Sign in </a> </p>
                    </div>

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy; 2025 © SRDI in CL by TMS Division in DA-PhilRice</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
@endsection
@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ URL::asset('build/js/pages/select2.init.js') }}"></script>
@include('auth._includes.script')
<script src="{{ URL::asset('build/libs/particles.js/particles.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/particles.app.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
@endsection
