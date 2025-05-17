<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Sex</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(genderLabels, genderCounts, "Farmers by gender", "gender-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="farmers_by_sex"
                    data-colors='["#2986cc", "#c90076"]'
                    class="apex-charts" dir="ltr"></div>
                    <div id="gender-subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Age Group</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="custom_datalabels_bar" data-colors='["#4CAF50", "#2196F3", "#FFC107", "#FF5722", "#9C27B0"]' class="apex-charts" dir="ltr"></div>
                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Civil Status</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(civilStatusLabels, civilStatusCounts, "Farmers by Civil Status", "civil-status-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="farmers_by_civil_status"
                    data-colors='["#3b76e1", "#f7b84b", "#63ad6f", "#f06548", "#5b73e8"]'
                    class="apex-charts" dir="ltr">
                </div>
                <div id="civil-status-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Educational Level</h4>
                <button class="btn btn-sm bg-primary text-white" onclick='generateChartSubtitle(educationLabels, educationCounts, "Farmers by Education", "education-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="farmers_by_education"
                    data-colors='["#556ee6", "#34c38f", "#f1b44c", "#f46a6a", "#50a5f1", "#74788d"]'
                    class="apex-charts" dir="ltr">
                </div>
                <div id="education-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Years in Farming</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(farmingLabels, farmingCounts, "Farming Experience", "farming-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="farmers_by_experience"
                    data-colors='["#f7b84b", "#34c38f", "#556ee6", "#f46a6a", "#50a5f1"]'
                    class="apex-charts" dir="ltr">
                </div>
                <div id="farming-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farm Ownership Status</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ownershipLabels, ownershipPercentages, "Farm Ownership %", "ownership-subtitle", true)'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="farm_ownership_chart"
                    data-colors='["#50a5f1", "#f46a6a"]'
                    class="apex-charts" dir="ltr">
                </div>
                <div id="ownership-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>
     <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Farmers by Province</h4>
            </div>
            <div class="card-body">
                <div id="provinceMap" style="height: 550px;"></div>
            </div>
        </div>
    </div>

    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Province</h4>
                <button class="btn btn-sm bg-success text-white"
                        onclick='generateChartSubtitle(provinceLabels, provinceCounts, "Farmers by Province", "province-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="province_bar_chart"
                    data-colors='["#a1d99b", "#74c476", "#41ab5d", "#238b45", "#006d2c", "#00441b"]'
                    class="apex-charts" dir="ltr">
                </div>
                <div id="province-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>

    {{-- <div class="col-xl-3">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="fw-medium text-muted mb-0">With Disability</p>
                        <h2 class="mt-4 ff-secondary fw-semibold"><span class="counter-value"
                                data-target="{{ number_format($disabilityCount) }}">0</span></h2>
                    </div>
                    <div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-success-subtle rounded-circle fs-2">
                                <i data-feather="target" class="text-success"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div><!-- end card body -->
        </div> <!-- end card-->
    </div> --}}
</div>
