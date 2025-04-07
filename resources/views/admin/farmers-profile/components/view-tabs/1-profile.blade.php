<div class="tab-pane active" id="profile-tab" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-2 mb-md-0 mt-2">Personal Information</h5>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Fullname :</p>
                            <input type="text" class="form-control" value="{{ $participant->full_name }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Nickname :</p>
                            <input type="text" class="form-control" value="{{ $participant->nickname ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Religion :</p>
                            <input type="text" class="form-control" value="{{ $participant->religion }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Age :</p>
                            <input type="text" class="form-control" value="{{ $participant->age }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Gender :</p>
                            <input type="text" class="form-control" value="{{ $participant->gender }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Civil Status :</p>
                            <input type="text" class="form-control" value="{{ $participant->civil_status }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Phone Number :</p>
                            <input type="text" class="form-control" value="{{ $participant->phone_number }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Highest Level of Education :</p>
                            <input type="text" class="form-control" value="{{ $participant->education_level }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Address :</p>
                            <input type="text" class="form-control"
                            value="{{ $participant->full_address }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Disability :</p>
                            <input type="text" class="form-control" value="{{ $participant->disability_type ?? 'N/A' }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Indigenous People :</p>
                            <input type="text" class="form-control" value="{{ $participant->is_indigenous ? 'Yes' : 'No' }}" disabled>                                                </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </div><!-- end card body -->
        <hr>
        <div class="card-body">
            <h5 class="card-title mb-3">Other Details</h5>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Primary Sector :</p>
                            <input type="text" class="form-control" value="{{ $participant->primary_sector }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Number of Years in Rice Farming :</p>
                            <input type="text" class="form-control" value="{{ $participant->years_in_farming }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Farmers' Association :</p>
                            <input type="text" class="form-control" value="{{ $participant->farmer_association }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Farm Ownership Status :</p>
                            <input type="text" class="form-control" value="{{ $participant->farm_role }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">RSBSA Number :</p>
                            <input type="text" class="form-control" value="{{ $participant->rsbsa_number ?? 'N/A' }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Food Restriction :</p>
                            <input type="text" class="form-control" value="{{ $participant->food_restrictions->pluck('food_restriction')->implode(', ') ?: 'N/A' }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Medical Illness :</p>
                            <input type="text" class="form-control" value="{{ $participant->medical_conditions->pluck('medical_conditions')->implode(', ') ?: 'N/A' }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>

        </div>
        <!-- end card body -->
        <hr>
        <div class="card-body">
            <h5 class="card-title mb-3">Emergency Contact</h5>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Fullname :</p>
                            <input type="text" class="form-control"
                            value="{{ $participant->emergency_contact->full_name }}"
                            disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-12 col-md-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Relationship :</p>
                            <input type="text" class="form-control" value="{{ $participant->emergency_contact->relationship }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->

                <div class="col-12 col-md-4 mb-4">
                    <div class="d-flex mt-4">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="mb-1 fw-bold">Telephone / Phone Number :</p>
                            <input type="text" class="form-control" value="{{ $participant->emergency_contact->contact_number }}" disabled>
                        </div>
                    </div>
                </div>
                <!--end col-->
            </div>
        </div>
    </div>
    <!-- end card-->
</div>
<!--end tab-pane-->
