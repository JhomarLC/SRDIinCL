
<div class="tab-pane fade" id="trainings_tab" role="tabpanel">
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
