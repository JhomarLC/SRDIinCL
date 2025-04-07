
<div class="tab-pane fade" id="trainings_tab" role="tabpanel">
    <div class="card profile-project-card shadow-none profile-project-success">
        @php
            $results = $participant->training_results;
        @endphp
        <div class="card-header d-flex-reverse align-items-center">
            <h5 class="card-title mb-1 flex-grow-1"><strong>{{ $results->training_title_main }}</strong></h5>
            <p class="mb-0 flex-grow-1">{{ $results->training_date_main_formatted }} | {{ $results->training_location_main }}</p>
        </div>
        <div class="card-body">
            <table id="training_results" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>Pre Test Score</th>
                        <th>Post Test Score</th>
                        <th>Total Test Items</th>
                        <th>Gain in Knowledge (GIK)</th>
                        <th>Certificate</th>
                        <th>Overall Training Score</th>
                        <th>Training Rating</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $results = $participant->training_results;
                    @endphp
                        <tr>
                            <td>{{ $results->pre_test_score }}</td>
                            <td>{{ $results->post_test_score }}</td>
                            <td>{{ $results->total_test_items }}</td>
                            <td>{{ $results->gain_in_knowledge }}</td>
                            <td>{{ $results->certificate_type . " - " . $results->certificate_number}} </td>
                            <td>{{ $results->overall_training_eval_score }}</td>
                            <td>{{ $results->trainer_rating }}</td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card profile-project-card shadow-none profile-project-secondary">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0 flex-grow-1">Lists of Past Trainings</h5>
        </div>
        <div class="card-body">
            <table id="trainings" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>Training Title</th>
                        <th>Date</th>
                        <th>Personally Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participant->trainings as $training)
                        <tr>
                            <td>{{ $training->training_title }}</td>
                            <td>{{ $training->training_date_formatted }}</td>
                            <td>{{ $training->personally_paid ? 'Yes' : 'No' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center">No trainings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end tab-pane-->
