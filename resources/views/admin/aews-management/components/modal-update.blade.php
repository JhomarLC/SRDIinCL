<div class="modal fade" id="editAEWModal" tabindex="-1" aria-labelledby="exampleModalgridLabel" aria-modal="true">
    <div class="modal-dialog">
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
                        <div class="col-xxl-12">
                            <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" hidden id="edit_id">
                            <input type="text" class="form-control" name="first_name" id="update_first_name" placeholder="Enter first name">
                            <span class="invalid-feedback" id="update_first_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" name="middle_name" id="update_middle_name" placeholder="Enter middle name">
                            <span class="invalid-feedback" id="update_middle_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-10">
                            <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="update_last_name" placeholder="Enter last name">
                            <span class="invalid-feedback" id="update_last_name_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-2">
                            <label for="suffix" class="form-label">Suffix</label>
                            <input type="text" class="form-control" name="suffix" id="update_suffix" placeholder="Enter suffix">
                            <span class="invalid-feedback" id="update_suffix_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="update_email" placeholder="Enter email">
                            <span class="invalid-feedback" id="update_email_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="password" class="form-label">Update Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" id="update_password" placeholder="Enter password">
                            <span class="invalid-feedback" id="update_password_error" role="alert"></span>
                        </div>
                        <div class="col-xxl-12">
                            <label for="password_confirmation" class="form-label">Confirm Updated Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password_confirmation" id="update_password_confirmation" placeholder="Confirm password">
                            <span class="invalid-feedback" id="update_confirm_password_error" role="alert"></span>
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
