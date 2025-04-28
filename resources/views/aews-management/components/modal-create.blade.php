<div class="modal fade" id="addnewaewmodal" tabindex="-1" aria-labelledby="exampleModalgridLabel">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Add AEW Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <form id="createAEWForm">
                    @csrf  <!-- CSRF Token for security -->
                    <div class="row g-3">
                        <div class="col-xxl-3">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="Enter first name">
                            <span class="invalid-feedback" id="first_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Enter middle name">
                            <span class="invalid-feedback" id="middle_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Enter last name">
                            <span class="invalid-feedback" id="last_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" name="suffix" id="suffix" placeholder="Enter suffix">
                            <span class="invalid-feedback" id="suffix_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-12">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                            <span class="invalid-feedback" id="email_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                            <span class="invalid-feedback" id="password_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Confirm password">
                            <span class="invalid-feedback" id="confirm_password_error" role="alert"></span>
                        </div>
                        <hr>
                        <div class="col-xxl-6">
                            <label for="region" class="form-label">Region <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="region" name="region">
                                <option selected disabled hidden>-- SELECT REGION --</option>
                            </select>
                            <span class="invalid-feedback" id="region_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="province" name="province" disabled>
                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                            </select>
                            <span class="invalid-feedback" id="province_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="municipality" name="municipality" disabled>
                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                            </select>
                            <span class="invalid-feedback" id="municipality_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="barangay" name="barangay" disabled>
                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                            </select>
                            <span class="invalid-feedback" id="barangay_error" role="alert"></span>
                        </div>
                        <!-- <div class="col-xxl-6">
                            <label for="barangay" class="form-label">Barangay</label>
                            <input type="text" class="form-control" name="barangay" id="barangay" placeholder="Enter barangay">
                            <span class="invalid-feedback" id="barangay_error" role="alert"></span>
                        </div> -->
                        <hr>
                        <div class="col-xxl-6">
                            <label for="contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number">
                            <span class="invalid-feedback" id="contact_number_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="start_date" name="start_date"
                                class="form-control flatpickr-input"
                                data-provider="flatpickr"
                                data-altFormat="F j, Y"
                                data-date-format="Y-m-d"
                                placeholder="Start Date"
                                required>
                            <span class="invalid-feedback" id="start_date_error" role="alert"></span>
                        </div>
                        <!-- <div class="col-xxl-4">
                             <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" id="end_date" name="end_date"
                                class="form-control flatpickr-input"
                                data-provider="flatpickr"
                                data-altFormat="F j, Y"
                                data-date-format="Y-m-d"
                                placeholder="End Date"
                                required>
                            <span class="invalid-feedback" id="end_date_error" role="alert"></span>
                        </div> -->
                        <div class="col-xxl-6">
                            <label for="position_id" class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="position_id" name="position_id">
                                <option selected disabled hidden>-- SELECT POSITION --</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->position_name}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="position_id_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="employment_type_id" class="form-label">Employment Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="employment_type_id" name="employment_type_id">
                                <option selected disabled hidden>-- SELECT EMPLOYMENT TYPE --</option>
                                @foreach ($employment_types as $employment_type)
                                    <option value="{{ $employment_type->id }}">{{ $employment_type->employment_name}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="employment_type_id_error" role="alert"></span>
                        </div>
                        <hr>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-secondary"> <i class="ri-user-add-line"></i> Add new AEW</button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
