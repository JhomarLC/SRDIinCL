<div class="modal fade" id="editAEWModal" tabindex="-1" aria-labelledby="exampleModalgridLabel">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalgridLabel">Update AEW Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" >
                <form id="updateAEWForm" method="POST">
                    @csrf  <!-- CSRF Token for security -->
                    @method('PUT')
                    <div class="row g-3">
                        <div class="col-xxl-3">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" hidden id="edit_id">
                            <input type="text" class="form-control" name="first_name" id="update_first_name" placeholder="Enter first name">
                            <span class="invalid-feedback" id="update_first_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="update_middle_name" placeholder="Enter middle name">
                            <span class="invalid-feedback" id="update_middle_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="update_last_name" placeholder="Enter last name">
                            <span class="invalid-feedback" id="update_last_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-3">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" name="suffix" id="update_suffix" placeholder="Enter suffix">
                            <span class="invalid-feedback" id="update_suffix_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="update_email" placeholder="Enter email">
                            <span class="invalid-feedback" id="update_email_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="password" class="form-label">Update Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="update_password" placeholder="Enter password">
                            <span class="invalid-feedback" id="update_password_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="password_confirmation" class="form-label">Confirm Updated Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="update_password_confirmation" placeholder="Confirm password">
                            <span class="invalid-feedback" id="update_confirm_password_error" role="alert"></span>
                        </div>
                        <hr>
                        <div class="col-xxl-6">
                            <label for="update_region" class="form-label">Region <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_region" name="update_region">
                                <option selected disabled hidden>-- SELECT REGION --</option>
                            </select>
                            <span class="invalid-feedback" id="update_region_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="update_province" class="form-label">Province <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_province" name="update_province" disabled>
                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                            </select>
                            <span class="invalid-feedback" id="update_province_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="update_municipality" class="form-label">Municipality <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_municipality" name="update_municipality" disabled>
                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                            </select>
                            <span class="invalid-feedback" id="update_municipality_error" role="alert"></span>
                        </div>

                        <div class="col-xxl-6">
                            <label for="update_barangay" class="form-label">Barangay <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_barangay" name="update_barangay" disabled>
                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                            </select>
                            <span class="invalid-feedback" id="update_barangay_error" role="alert"></span>
                        </div>
                        <hr>
                        <div class="col-xxl-6">
                            <label for="update_contact_number" class="form-label">Contact Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_number" id="update_contact_number" placeholder="Contact Number">
                            <span class="invalid-feedback" id="update_contact_number_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="update_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" id="update_start_date" name="start_date"
                                class="form-control flatpickr-input"
                                data-provider="flatpickr"
                                data-altFormat="F j, Y"
                                data-date-format="Y-m-d"
                                placeholder="Start Date"
                                required>
                            <span class="invalid-feedback" id="update_start_date_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="update_position_id" class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_position_id" name="position_id">
                                <option selected disabled hidden>-- SELECT POSITION --</option>
                                @foreach ($positions as $position)
                                    <option value="{{ $position->id }}">{{ $position->position_name}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="update_position_id_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-6">
                            <label for="update_employment_type_id" class="form-label">Employment Type <span class="text-danger">*</span></label>
                            <select class="form-control select2" id="update_employment_type_id" name="employment_type_id">
                                <option selected disabled hidden>-- SELECT EMPLOYMENT TYPE --</option>
                                @foreach ($employment_types as $employment_type)
                                    <option value="{{ $employment_type->id }}">{{ $employment_type->employment_name}}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback" id="update_employment_type_id_error" role="alert"></span>
                        </div>
                        <div class="col-lg-12">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success"> <i class="ri-user-add-line"></i> Update AEW account</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
