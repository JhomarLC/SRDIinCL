<div class="row">
    <!-- Goal Achievement Pie -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Goal Achievement</h4>
                <button class="btn btn-sm bg-success text-white"
                        onclick='generateChartSubtitle(goalLabels, goalCounts, "Goal Achievement", "goal-achievement-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="training_goal_achievement"
                    data-colors='["#28a745", "#ffc107", "#dc3545"]'
                    class="apex-charts" dir="ltr"></div>
                <div id="goal-achievement-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>

    <!-- Overall Quality Pie -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Overall Quality</h4>
                <button class="btn btn-sm bg-success text-white"
                        onclick='generateChartSubtitle(qualityLabels, qualityCounts, "Overall Quality", "overall-quality-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body">
                <div id="training_overall_quality"
                    data-colors='["#007bff", "#17a2b8", "#ffc107", "#fd7e14", "#dc3545"]'
                    class="apex-charts" dir="ltr"></div>
                <div id="overall-quality-subtitle" class="mt-1"></div>
            </div>
        </div>
    </div>

    <!-- Avg Scores per Event -->
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Average Evaluation Scores per Training Event</h4>
            </div>
            <div class="card-body">
                <div id="training_scores_bar"
                    data-colors='["#4CAF50", "#FFC107"]'
                    class="apex-charts" dir="ltr"></div>
            </div>
        </div>
    </div>

    <!-- Training Content Evaluation Scores -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Content Evaluation (Avg. Score per Question)</h4>
            </div>
            <div class="card-body">
                <div id="content_question_scores"
                     data-colors='["#4CAF50", "#81C784", "#66BB6A", "#388E3C", "#2E7D32", "#1B5E20", "#A5D6A7"]'
                     class="apex-charts" style="min-height: 400px;"></div>
            </div>
        </div>
    </div>

    <!-- Course Management Evaluation Scores -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Course Management (Avg. Score per Question)</h4>
            </div>
            <div class="card-body">
                <div id="course_question_scores"
                     data-colors='["#FFC107", "#FFD54F", "#FFCA28", "#FFA000", "#FF8F00", "#FF6F00", "#FFE082"]'
                     class="apex-charts" style="min-height: 400px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Trainings by Province</h4>
                {{-- <button class="btn btn-sm bg-success text-white" onclick='generateChartSubtitle(ageGroupLabels, ageGroupCounts, "Farmers by age group", "subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button> --}}
            </div>
            <div class="card-body d-flex">
                <div class="col-xl-6">
                    <div id="trainingMap" style="height: 550px;"></div>
                </div>
                <div class="col-xl-6" id="trainingBarChart">
                    <div id="training_datalabels_bar" class="apex-charts" dir="ltr"></div>
                    <div id="subtitle" class="mt-1"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col-xl-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Trainings by Province</h4>
                <button class="btn btn-sm bg-success text-white"
                    onclick='generateChartSubtitle(trainingLabels, trainingCounts, "Trainings by Province", "training-subtitle")'>
                    <i class="ri-refresh-line"></i> Analyze Data with AI
                </button>
            </div>
            <div class="card-body d-flex">
                <div class="col-xl-6">
                    <div id="trainingMap" style="height: 550px;"></div>
                </div>
                <div class="col-xl-6" id="trainingBarChart">
                    <div id="training_datalabels_bar" class="apex-charts" dir="ltr"></div>
                    <div id="training-subtitle" class="mt-1"></div>
                </div>
            </div>
        </div>
    </div> --}}

</div>

