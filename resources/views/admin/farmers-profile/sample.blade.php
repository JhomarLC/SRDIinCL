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
        <div class="col-sm-3" id="disabilitySelectContainer" style="display: none;">
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
        <div class="col-sm-3" id="tribeContainer" style="display: none;">
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
