<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Farmers by Sex</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(genderLabels, genderCounts, "Farmers by gender", "gender-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data
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
                    <i class="ri-refresh-line"></i> Analyze Data
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="custom_datalabels_bar" data-colors='["#4CAF50", "#2196F3", "#FFC107", "#FF5722", "#9C27B0"]' class="apex-charts" dir="ltr"></div>
                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- end col -->
</div>
