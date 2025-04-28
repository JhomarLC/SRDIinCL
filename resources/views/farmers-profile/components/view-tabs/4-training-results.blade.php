
<div class="tab-pane fade" id="training_results_tab" role="tabpanel">
    <div class="card profile-project-card shadow-none profile-project-success">
        @php
            $results = $participant->training_results;
        @endphp
        <div class="card-header d-flex-reverse align-items-center">
            <h5 class="card-title mb-1 flex-grow-1"><strong>{{ $results->training_title_main }}</strong></h5>
            <p class="mb-0 flex-grow-1">{{ $results->training_date_main_formatted }} | {{ $results->full_address }}</p>
        </div>
        <div class="card-body">
            <table id="training_results" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                <thead>
                    <tr>
                        <th>Pre Test Score</th>
                        <th>Post Test Score</th>
                        <th>Total Test Items</th>
                        <th>Gain in Knowledge (GIK)</th>
                        <th>Meetings Attended</th>
                        <th>Certificate</th>
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
                            <td>{{ $results->meetings_attended }} / {{ $results->total_no_meetings }} ({{ $results->percentage_meetings_attended }} %)</td>
                            <td>{{ $results->certificate_type . " - " . $results->certificate_number}} </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--end tab-pane-->
