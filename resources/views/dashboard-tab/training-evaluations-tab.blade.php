<div class="row">
    <!-- end col -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Scores per Topic</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div><!-- end card header -->

            <div class="card-body">
                <div id="speaker_topic_scores_1" data-colors='[
                    "#4CAF50", "#2196F3", "#FFC107", "#FF5722", "#9C27B0",
                    "#00BCD4", "#8BC34A", "#E91E63", "#3F51B5", "#CDDC39",
                    "#673AB7", "#009688", "#FF9800", "#607D8B", "#795548",
                    "#B71C1C", "#1A237E", "#006064", "#827717", "#880E4F"
                ]' class="apex-charts" dir="ltr"></div>
                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
    <!-- Chart Containers -->
</div>
