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
                <div id="speaker_topic_scores" data-colors='[
                    "#4CAF50", "#2196F3", "#FFC107", "#FF5722", "#9C27B0",
                    "#00BCD4", "#8BC34A", "#E91E63", "#3F51B5", "#CDDC39",
                    "#673AB7", "#009688", "#FF9800", "#607D8B", "#795548",
                    "#B71C1C", "#1A237E", "#006064", "#827717", "#880E4F"
                ]' class="apex-charts" dir="ltr"></div>
                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
     <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Scores per question</h4>
                <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div><!-- end card header -->
            <div class="card-body">
                <div id="speaker_question_scores"
                    class="apex-charts"
                    data-colors='["#00b894", "#0984e3", "#6c5ce7", "#fdcb6e", "#d63031", "#e84393", "#fab1a0", "#2d3436"]'
                    style="min-height: 1000px;">
                </div>

                <div id="subtitle" class="mt-1"></div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div>
</div>
