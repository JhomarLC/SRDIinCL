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
<!-- select2  -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')

@component('components.breadcrumb')
    @slot('breadcrumbs', [
        ['label' => 'Admin', 'route' => 'dashboard'],
        ['label' => 'Farmers Profile', 'route' => 'farmers-profile.index']
    ])
    @slot('title')
        Create Farmers Profile
    @endslot
@endcomponent

<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Farmers Profile</h4>
            </div><!-- end card header -->
            <div class="card-body">
                <form action="#" class="form-steps" autocomplete="off">
                    <div class="text-center pt-3 pb-4 mb-1">
                        <h5>Fillout Farmers Profile</h5>
                    </div>
                    <div id="custom-progress-bar" class="progress-nav mb-4">
                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <ul class="nav nav-pills progress-bar-tab custom-nav" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill active" data-progressbar="custom-progress-bar"
                                    id="pills-personal-info-tab" data-bs-toggle="pill" data-bs-target="#pills-personal-info"
                                    type="button" role="tab" aria-controls="pills-personal-info"
                                    aria-selected="true">1</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-trainings-tab" data-bs-toggle="pill" data-bs-target="#pills-trainings"
                                    type="button" role="tab" aria-controls="pills-trainings"
                                    aria-selected="false">2</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-other-info-tab" data-bs-toggle="pill" data-bs-target="#pills-other-info"
                                    type="button" role="tab" aria-controls="pills-other-info"
                                    aria-selected="false">3</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-data-ricefarming-tab" data-bs-toggle="pill" data-bs-target="#pills-data-ricefarming"
                                    type="button" role="tab" aria-controls="pills-data-ricefarming"
                                    aria-selected="false">4</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-emergency-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-emergency-contact"
                                    type="button" role="tab" aria-controls="pills-emergency-contact"
                                    aria-selected="false">5</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link rounded-pill" data-progressbar="custom-progress-bar"
                                    id="pills-training-result-tab" data-bs-toggle="pill" data-bs-target="#pills-training-result"
                                    type="button" role="tab" aria-controls="pills-training-result"
                                    aria-selected="false">6</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="pills-personal-info" role="tabpanel"
                            aria-labelledby="pills-personal-info-tab">
                            <div>
                                <div>
                                    <h5>Personal Information</h5>
                                    <p class="text-muted">Fill all information below</p>
                                </div>
                                <div>
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label for="firstName" class="form-label">First name</label>
                                            <input type="text" class="form-control" id="firstName"
                                                placeholder="Enter first name" value="" required>
                                            <div class="invalid-feedback">Please enter a first name</div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Middle name</label>
                                            <input type="text" class="form-control" id="lastName"
                                                placeholder="Enter middle name" value="" required>
                                            <div class="invalid-feedback">Please enter a middle name</div>
                                        </div>

                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Last name</label>
                                            <input type="text" class="form-control" id="lastName"
                                                placeholder="Enter last name" value="" required>
                                            <div class="invalid-feedback">Please enter a last name</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Suffix</label>
                                            <input type="text" class="form-control" id="lastName"
                                                placeholder="Enter Suffix" value="" required>
                                            <div class="invalid-feedback">Please enter Suffix</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Nickname</label>
                                            <input type="text" class="form-control" id="lastName"
                                                placeholder="Enter Nickname" value="" required>
                                            <div class="invalid-feedback">Please enter Nickname</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="exampleInputdate" class="form-label">Birthdate</label>
                                            <input type="date" class="form-control" id="exampleInputdate">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="text" class="form-control" id="age"
                                                placeholder="Enter Age" value="" required>
                                            <div class="invalid-feedback">Please enter Age</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-control mb-3 select2" id="gender" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT GENDER --</option>
                                                <option value="1">Male</option>
                                                <option value="2">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-3" >
                                            <label for="civilStatus" class="form-label">Civil Status</label>
                                            <select class="form-control select2" id="civilStatus" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT CIVIL STATUS --</option>
                                                <option value="1">Single</option>
                                                <option value="2">Married</option>
                                                <option value="3">Separated</option>
                                                <option value="4">Widow</option>
                                                <option value="5">Divorced</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="religion" class="form-label">Religion</label>
                                            <input type="text" class="form-control" id="religion" placeholder="Enter Religion" required>
                                            <div class="invalid-feedback">Please enter religion</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="phoneNumber" class="form-label">Phone Number</label>
                                            <input type="text" class="form-control" id="phoneNumber" placeholder="Enter Phone Number" required>
                                            <div class="invalid-feedback">Please enter Phone Number</div>
                                        </div>
                                        <div class="col-sm-3" >
                                            <label for="civilStatus" class="form-label">Highest Level of Education</label>
                                            <select class="form-control select2" id="education" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT EDUCATION --</option>
                                                <option value="1">Elementary</option>
                                                <option value="2">High School</option>
                                                <option value="3">Vocational</option>
                                                <option value="4">College Degree</option>
                                                <option value="5">Master's Degree</option>
                                                <option value="6">Doctorate Degree</option>
                                                <option value="7">Undergraduate</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Has a disability (PWD)</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="disability" id="disabilityYes" value="yes">
                                                <label class="form-check-label" for="disabilityYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="disability" id="disabilityNo" value="no" checked>
                                                <label class="form-check-label" for="disabilityNo">No</label>
                                            </div>
                                        </div>

                                        <!-- Disability Selection Dropdown -->
                                        <div class="col-sm-3" id="disabilitySelectContainer" >
                                            <label for="disabilitySelect" class="form-label">If Yes, Select Disability</label>
                                            <select class="form-control mb-3 select2" id="disabilitySelect" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT DISABILITY --</option>
                                                <option value="1">1 - Visual Impairment</option>
                                                <option value="2">2 - Hearing Loss</option>
                                                <option value="3">3 - Orthopedic Disability</option>
                                                <option value="4">4 - Learning Disability</option>
                                                <option value="5">5 - Psychological Disability</option>
                                                <option value="6">6 - Chronic Illness</option>
                                                <option value="7">7 - Mental Disability</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="lastName" class="form-label">Indigenous People (IP):</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="indigenousPeople" id="IPYes" value="yes">
                                                <label class="form-check-label" for="IPYes">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="indigenousPeople" id="IPNo" value="no" checked>
                                                <label class="form-check-label" for="IPNo">No</label>
                                            </div>
                                        </div>

                                        <!-- Tribe Name Input (Hidden by Default) -->
                                        <div class="col-sm-3" id="tribeContainer" >
                                            <label for="tribeName" class="form-label">Name of Tribe</label>
                                            <input type="text" class="form-control" id="tribeName" placeholder="Enter Tribe">
                                            <div class="invalid-feedback">Please enter Tribe</div>
                                        </div>

                                    </div>
                                </div>
                                <div class="mt-3">
                                    <hr>
                                    <h5>Address</h5>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-4" >
                                            <label for="civilStatus" class="form-label">Province</label>
                                            <select class="form-control select2" id="province" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT PROVINCE --</option>
                                                <option value="1">Sample</option>
                                                <option value="2">Sample</option>
                                                <option value="3">Sample</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" >
                                            <label for="civilStatus" class="form-label">Municipality</label>
                                            <select class="form-control select2" id="municipality" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT MUNICIPALITY --</option>
                                                <option value="1">Sample</option>
                                                <option value="2">Sample</option>
                                                <option value="3">Sample</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4" >
                                            <label for="barangay" class="form-label">Barangay</label>
                                            <select class="form-control select2" id="barangay" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT BARANGAY --</option>
                                                <option value="1">Sample</option>
                                                <option value="2">Sample</option>
                                                <option value="3">Sample</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-9">
                                            <label for="houseNumber" class="form-label">House Number/Sitio/Purok</label>
                                            <input type="text" class="form-control" id="houseNumber" placeholder="Enter House Number" required>
                                            <div class="invalid-feedback">Please enter House Number</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="houseNumber" class="form-label">Zip Code</label>
                                            <input type="text" class="form-control" id="houseNumber" placeholder="Enter Zip Code" required>
                                            <div class="invalid-feedback">Please enter Zip Code</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <hr>
                                    <h5>Other Details</h5>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-4" >
                                            <label for="civilStatus" class="form-label">Primary sector involved in</label>
                                            <select class="form-control select2" id="primarySector" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT PRIMARY SECTOR --</option>
                                                <option value="1">Farmer or Seed grower</option>
                                                <option value="2">Extension workers and other intermediaries (e.g. LFT, trainer, extension worker)</option>
                                                <option value="3">Researcher</option>
                                                <option value="3">Educator (elementary/high school/college teachers)</option>
                                                <option value="3">Student (e.g. college student, post-graduate student)</option>
                                                <option value="3">Policy maker (e.g. local chief executive)</option>
                                                <option value="3">Media (e.g. broadcaster, vlogger, etc)</option>
                                                <option value="3">Industry Player (e.g. trader, miller, wholesaler, retailer)</option>
                                                <option value="3">Other (e.g. OFW, job seeker, freelancer, consultant)</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="yearsOfRiceFarm" class="form-label">Number of years in Rice Farming</label>
                                            <input type="text" class="form-control" id="yearsOfRiceFarm" placeholder="Enter Number of Years" required>
                                            <div class="invalid-feedback">Please enter Zip Code</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="farmersAssociation" class="form-label">Farmers' Association</label>
                                            <input type="text" class="form-control" id="farmersAssociation" placeholder="Enter Farmers' Association" required>
                                            <div class="invalid-feedback">Please enter Farmers' Association</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-6" >
                                            <label for="farmOwnerStatus" class="form-label">Farm Ownership Status</label>
                                            <select class="form-control select2" id="farmOwnerStatus" aria-label="Default select example">
                                                <option selected disabled hidden>-- SELECT FARM OWNERSHIP STATUS --</option>
                                                <option value="1">Owner/Farm Owner</option>
                                                <option value="2">Relative of the Owner/Farm Owner</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="RSBSAnumber" class="form-label">RSBSA Number</label>
                                            <input type="text" class="form-control" id="RSBSAnumber" placeholder="Enter Farmers' Association" required>
                                            <div class="invalid-feedback">Please enter RSBSA Number</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-trainings-tab"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                            </div>
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-trainings" role="tabpanel"
                            aria-labelledby="pills-trainings-tab">
                            <div class="d-flex align-items-center">
                                    <h5 class="flex-grow-1">Trainings on rice farming attended in the past five (5) years</h5>
                                    <button class="btn btn-secondary">
                                        <i class="ri-add-line"></i> Add Training
                                    </button>
                            </div>

                            <p class="text-muted">Fill all information below</p>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-7">
                                        <label for="trainingTitle" class="form-label">Title of the training/workshop</label>
                                        <input type="text" class="form-control" id="trainingTitle"
                                            placeholder="Enter title of the training/workshop" value="" required>
                                        <div class="invalid-feedback">Please enter training title</div>
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="yearTrainingConducted" class="form-label">Year Conducted</label>
                                        <select class="form-control mb-3 select2" aria-label="Default select example">
                                            <option selected disabled hidden>-- SELECT YEAR --</option>
                                            <option value="1">2023</option>
                                            <option value="2">2024</option>
                                            <option value="2">2025</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-7">
                                        <label for="agencyConducted" class="form-label">Group or agency that conducted the training</label>
                                        <input type="text" class="form-control" id="agencyConducted"
                                            placeholder="Enter group of agency that conducted the training" value="" required>
                                        <div class="invalid-feedback">Please enter training title</div>
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="payForTraining" class="form-label">Did you personally pay for attending the training?</label>
                                        <div class="form-check form-check-inline mt-2">
                                            <input class="form-check-input" type="radio" name="indigenousPeople" id="IPYes" value="yes">
                                            <label class="form-check-label" for="IPYes">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="indigenousPeople" id="IPNo" value="no" checked>
                                            <label class="form-check-label" for="IPNo">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-light btn-label previestab"
                                    data-previous="pills-personal-info-tab"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                    Previous</button>
                                <button type="button"
                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-other-info-tab"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
                            </div>
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-other-info" role="tabpanel"
                            aria-labelledby="pills-other-info-tab">
                            <div>
                                <h5>Other Information</h5>
                                <p class="text-muted">Fill all information below</p>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="foodRestrictions" class="form-label">List the foods that cannot be eaten due to allergies,
                                            illness, religion, and beliefs (food restrictions).</label>
                                        <input type="text" class="form-control" id="foodRestrictions"
                                            placeholder="Enter Food Restriction" value="" required>
                                        <div class="invalid-feedback">Please enter food restrictions</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-12">
                                        <label for="medicalCondition" class="form-label">List any medical condition or illness, if any,
                                            that may affect your participation in specific training activities.</label>
                                        <input type="text" class="form-control" id="medicalCondition"
                                            placeholder="Enter Medical Condition or Illness" value="" required>
                                        <div class="invalid-feedback">Please enter medical condition or illness</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-light btn-label previestab"
                                    data-previous="pills-trainings-tab"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                    Previous</button>
                                <button type="button"
                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-data-ricefarming-tab"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                    Next</button>
                            </div>
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-data-ricefarming" role="tabpanel"
                            aria-labelledby="pills-data-ricefarming-tab">
                            <div>
                                <h5>Data on Rice Farming</h5>
                                <p class="text-muted">Fill all information below</p>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-3">
                                        <label for="farmSeason" class="form-label">Select Farming Season</label>
                                        <div class="form-check form-check-inline mt-2">
                                            <input class="form-check-input" type="radio" name="season" id="seasonDry" value="yes">
                                            <label class="form-check-label" for="seasonDry">Dry</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="season" id="seasonWet" value="no" checked>
                                            <label class="form-check-label" for="seasonWet">Wet</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="yearTrainingConducted" class="form-label">Year Conducted</label>
                                        <select class="form-control mb-3 select2" aria-label="Default select example">
                                            <option selected disabled hidden>-- SELECT YEAR --</option>
                                            <option value="1">2023</option>
                                            <option value="2">2024</option>
                                            <option value="2">2025</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label for="farmSize" class="form-label">Farm Size</label>
                                            <input type="text" class="form-control" id="farmSize"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="totalHarvest" class="form-label">Total harvest (sacks)</label>
                                            <input type="text" class="form-control" id="totalHarvest"
                                                placeholder="Enter Total Harvest" value="" required>
                                            <div class="invalid-feedback">Please enter total Harvest</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="weightPerSack" class="form-label">Weight per sack</label>
                                            <input type="text" class="form-control" id="weightPerSack"
                                                placeholder="Enter Weight per Sack" value="" required>
                                            <div class="invalid-feedback">Please enter weight per sack</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="pricePerKilo" class="form-label">Price per kilogram</label>
                                            <input type="text" class="form-control" id="pricePerKilo"
                                                placeholder="Enter Price per Kilo" value="" required>
                                            <div class="invalid-feedback">Please enter price per kilo</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="totalIncome" class="form-label">Total income</label>
                                            <input type="text" class="form-control" id="totalIncome"
                                                placeholder="Enter Total Income" value="" required>
                                            <div class="invalid-feedback">Please enter total income</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="totalExpenses" class="form-label">Total expenses</label>
                                            <input type="text" class="form-control" id="totalExpenses"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="farmSize" class="form-label">Other Crops</label>
                                            <input type="text" class="form-control" id="farmSize"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-sm-3">
                                        <label for="farmSeason" class="form-label">Select Farming Season</label>
                                        <div class="form-check form-check-inline mt-2">
                                            <input class="form-check-input" type="radio" name="season" id="seasonDry2" value="yes">
                                            <label class="form-check-label" for="seasonDry2">Dry</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="season" id="seasonWet2" value="no" checked>
                                            <label class="form-check-label" for="seasonWet2">Wet</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="yearTrainingConducted" class="form-label">Year Conducted</label>
                                        <select class="form-control mb-3 select2" aria-label="Default select example">
                                            <option selected disabled hidden>-- SELECT YEAR --</option>
                                            <option value="1">2023</option>
                                            <option value="2">2024</option>
                                            <option value="2">2025</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="mt-3">
                                    <div class="row g-3">
                                        <div class="col-sm-3">
                                            <label for="farmSize" class="form-label">Farm Size</label>
                                            <input type="text" class="form-control" id="farmSize"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="totalHarvest" class="form-label">Total harvest (sacks)</label>
                                            <input type="text" class="form-control" id="totalHarvest"
                                                placeholder="Enter Total Harvest" value="" required>
                                            <div class="invalid-feedback">Please enter total Harvest</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="weightPerSack" class="form-label">Weight per sack</label>
                                            <input type="text" class="form-control" id="weightPerSack"
                                                placeholder="Enter Weight per Sack" value="" required>
                                            <div class="invalid-feedback">Please enter weight per sack</div>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="pricePerKilo" class="form-label">Price per kilogram</label>
                                            <input type="text" class="form-control" id="pricePerKilo"
                                                placeholder="Enter Price per Kilo" value="" required>
                                            <div class="invalid-feedback">Please enter price per kilo</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="totalIncome" class="form-label">Total income</label>
                                            <input type="text" class="form-control" id="totalIncome"
                                                placeholder="Enter Total Income" value="" required>
                                            <div class="invalid-feedback">Please enter total income</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="totalExpenses" class="form-label">Total expenses</label>
                                            <input type="text" class="form-control" id="totalExpenses"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="farmSize" class="form-label">Other Crops</label>
                                            <input type="text" class="form-control" id="farmSize"
                                                placeholder="Enter Farm Size" value="" required>
                                            <div class="invalid-feedback">Please enter farm size</div>
                                        </div>
                                    </div>
                                </div>
                                <di  v class="d-flex align-items-start gap-3 mt-4">
                                    <button type="button" class="btn btn-light btn-label previestab"
                                        data-previous="pills-other-info-tab"><i
                                            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                        Previous</button>
                                    <button type="button"
                                        class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                        data-nexttab="pills-emergency-contact-tab" ><i
                                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                        Next</button>
                                </di>
                            </div>
                        </div>
                        <!-- end tab pane -->

                        <div class="tab-pane fade" id="pills-emergency-contact" role="tabpanel"
                            aria-labelledby="pills-emergency-contact-tab">
                            <div>
                                <h5>Emergency Contact</h5>
                                <p class="text-muted">Fill all information below</p>
                            </div>

                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-3">
                                        <label for="firstName" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="firstName"
                                            placeholder="Enter first name" value="" required>
                                        <div class="invalid-feedback">Please enter a first name</div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="lastName" class="form-label">Middle name</label>
                                        <input type="text" class="form-control" id="lastName"
                                            placeholder="Enter middle name" value="" required>
                                        <div class="invalid-feedback">Please enter a middle name</div>
                                    </div>

                                    <div class="col-sm-3">
                                        <label for="lastName" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="lastName"
                                            placeholder="Enter last name" value="" required>
                                        <div class="invalid-feedback">Please enter a last name</div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="lastName" class="form-label">Suffix</label>
                                        <input type="text" class="form-control" id="lastName"
                                            placeholder="Enter Suffix" value="" required>
                                        <div class="invalid-feedback">Please enter Suffix</div>
                                    </div>
                                </div>


                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="emergencyRelationship" class="form-label">Relationship</label>
                                        <input type="text" class="form-control" id="emergencyRelationship"
                                            placeholder="Enter Relationship" value="" required>
                                        <div class="invalid-feedback">Please enter relationship</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="emergencyPhoneNumber" class="form-label">Telephone / Phone Number</label>
                                        <input type="text" class="form-control" id="emergencyPhoneNumber"
                                            placeholder="Enter phone number" value="" required>
                                        <div class="invalid-feedback">Please enter phone number</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-light btn-label previestab"
                                    data-previous="pills-data-ricefarming-tab"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                    Previous</button>
                                <button type="button"
                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-training-result-tab"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                    Next</button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="pills-training-result" role="tabpanel"
                            aria-labelledby="pills-training-result-tab">
                            <div>

                                <h5>Training Results</h5>
                                <p class="text-muted">Fill all information below</p>
                            </div>

                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <label for="emergencyRelationship" class="form-label">Pre-Test (Written)</label>
                                        <input type="text" class="form-control" id="emergencyRelationship"
                                            placeholder="Enter Pre-Test" value="" required>
                                        <div class="invalid-feedback">Please enter pre-test</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="emergencyPhoneNumber" class="form-label">Post-Test (Written)</label>
                                        <input type="text" class="form-control" id="emergencyPhoneNumber"
                                            placeholder="Enter Post-Test" value="" required>
                                        <div class="invalid-feedback">Please enter post test</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="emergencyPhoneNumber" class="form-label">Total no. of Test items</label>
                                        <input type="text" class="form-control" id="emergencyPhoneNumber"
                                            placeholder="Enter number of test items" value="" required>
                                        <div class="invalid-feedback">Please enter number of test items</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-4">
                                        <label for="gainKnowledge" class="form-label">Gain in Knowledge</label>
                                        <input type="text" class="form-control" id="gainKnowledge"
                                            placeholder="Enter Gain in Knowledge" value="" required>
                                        <div class="invalid-feedback">Please enter gain in knowledge</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="typeOfCertificate" class="form-label">Type of Certificate</label>
                                        <input type="text" class="form-control" id="typeOfCertificate"
                                            placeholder="Enter type of certificate" value="" required>
                                        <div class="invalid-feedback">Please enter type of certificate</div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="certificateNumber" class="form-label">Certificate number</label>
                                        <input type="text" class="form-control" id="certificateNumber"
                                            placeholder="Enter Certificate Number" value="" required>
                                        <div class="invalid-feedback">Please enter certificate number</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="overallTrainingEval" class="form-label">Overall Training Evaluation</label>
                                        <input type="text" class="form-control" id="overallTrainingEval"
                                            placeholder="Enter Overall Training Evaluation" value="" required>
                                        <div class="invalid-feedback">Please enter overall training evaluation</div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="ratingTrainingEval" class="form-label">TMT Rating in Training Evaluation</label>
                                        <input type="text" class="form-control" id="ratingTrainingEval"
                                            placeholder="Enter TMT Rating in Training Evaluation" value="" required>
                                        <div class="invalid-feedback">Please enter TMT Rating in Training Evaluation</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-light btn-label previestab"
                                    data-previous="pills-emergency-contact-tab"><i
                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                                    Previous</button>
                                <button type="button"
                                    class="btn btn-success btn-label right ms-auto nexttab nexttab"
                                    data-nexttab="pills-bill-finish"><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                                    Finish</button>
                            </div>
                        </div>
                        <!-- end tab pane -->
                        <!-- end tab pane -->
                        <div class="tab-pane fade" id="pills-success" role="tabpanel"
                            aria-labelledby="pills-success-tab">
                            <div>
                                <div class="text-center">
                                    <div class="mb-4">
                                        <lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop"
                                            colors="primary:#0ab39c,secondary:#405189"
                                            style="width:120px;height:120px"></lord-icon>
                                    </div>
                                    <h5>Well Done !</h5>
                                    <p class="text-muted">You have Successfully Signed Up</p>
                                </div>
                            </div>
                        </div>
                        <!-- end tab pane -->
                    </div>
                    <!-- end tab content -->
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>

</div>
@endsection
@section('script')
<!-- password -->
<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
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
<script src="{{ URL::asset('admin-js/create-farmers-profile.js') }}"></script>

@include('admin.farmers-profile._includes.script')
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
