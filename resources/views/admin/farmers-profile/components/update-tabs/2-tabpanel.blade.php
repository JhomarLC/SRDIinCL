<div class="tab-pane fade" id="pills-trainings" role="tabpanel" aria-labelledby="pills-trainings-tab">
    <div class="d-flex align-items-center">
        <h5 class="flex-grow-1">Trainings on rice farming attended in the past five (5) years</h5>
        <button id="addTrainingBtn" class="btn btn-secondary">
            <i class="ri-add-line"></i> Add Training
        </button>
    </div>

    <p class="text-muted">Fill all information below</p>
    <!-- Add this wrapper around the form fields -->
    <div id="trainingContainer">
        @forelse($participant->trainings as $index => $training)
        <div class="training-entry position-relative border p-3 mb-4">
            <!-- Inside each .training-entry -->
            <button type="button" class="btn btn-warning btn-sm position-absolute top-0 end-0 m-2 clear-training" data-index="{{ $index }}">
                Clear
            </button>
            <!-- Show Remove button for all except the first training -->
            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-training {{ $index > 0 ? '' : 'd-none' }}">
                Remove
            </button>
            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label for="training_title" class="form-label">Title of the training/workshop</label>
                        <input type="text" class="form-control" id="training_title{{ $index }}" name="training_title[{{ $index }}]"
                               value="{{ old('training_title.' . $index, $training->training_title) }}"
                               placeholder="Enter title of the training/workshop">
                        <div class="invalid-feedback">Please enter training title</div>
                    </div>
                    <div class="col-sm-5">
                        <label for="training_date" class="form-label">Training Date</label>
                        <input type="date" class="form-control" id="training_date{{ $index }}" name="training_date[{{ $index }}]"
                               value="{{ old('training_date.' . $index, $training->training_date) }}">
                        <div class="invalid-feedback">Please select year conducted</div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row g-3">
                    <div class="col-sm-7">
                        <label for="conducted_by" class="form-label">Group or agency that conducted the training</label>
                        <input type="text" class="form-control" id="conducted_by{{ $index }}" name="conducted_by[{{ $index }}]"
                               value="{{ old('conducted_by.' . $index, $training->conducted_by) }}"
                               placeholder="Enter group or agency that conducted the training">
                        <div class="invalid-feedback">Please enter group or agency</div>
                    </div>
                    <div class="col-sm-5">
                        <label for="payForTraining" class="form-label">Did you personally pay for attending the training?</label>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="personally_paid[{{ $index }}]" id="paid_yes_{{ $index }}" value="1" {{ $training->personally_paid == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="paid_yes_{{ $index }}">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="personally_paid[{{ $index }}]" id="paid_no_{{ $index }}" value="0" {{ $training->personally_paid == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="paid_no_{{ $index }}">No</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
             <!-- Empty training entry shown only when no trainings exist -->
            <div class="training-entry position-relative border p-3 mb-4">
                <button type="button" class="btn btn-warning btn-sm position-absolute top-0 end-0 m-2 clear-training" data-index="0">
                    Clear
                </button>
                <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-training d-none">
                    Remove
                </button>
                <div class="mt-3">
                    <div class="row g-3">
                        <div class="col-sm-7">
                            <label for="training_title" class="form-label">Title of the training/workshop</label>
                            <input type="text" class="form-control" id="training_title" name="training_title[0]"
                                placeholder="Enter title of the training/workshop">
                            <div class="invalid-feedback">Please enter training title</div>
                        </div>
                        <div class="col-sm-5">
                            <label for="training_date" class="form-label">Training Date</label>
                            <input type="date" class="form-control" id="training_date" name="training_date[0]">
                            <div class="invalid-feedback">Please select year conducted</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row g-3">
                        <div class="col-sm-7">
                            <label for="conducted_by" class="form-label">Group or agency that conducted the training</label>
                            <input type="text" class="form-control" id="conducted_by" name="conducted_by[0]"
                                placeholder="Enter group of agency that conducted the training">
                            <div class="invalid-feedback">Please enter training title</div>
                        </div>
                        <div class="col-sm-5">
                            <label for="payForTraining" class="form-label">Did you personally pay for attending the training?</label>
                            <div class="form-check form-check-inline mt-2">
                                <input class="form-check-input" type="radio" name="personally_paid[0]" id="paid_yes" value="1">
                                <label class="form-check-label" for="paid_yes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="personally_paid[0]" id="paid_no" value="0">
                                <label class="form-check-label" for="paid_no">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    <hr>

    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-personal-info-tab">
            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="pills-other-info-tab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
        </button>
    </div>
</div>
<!-- end tab pane -->
