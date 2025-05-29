<div class="tab-pane fade" id="v-pills-crop-establishment" role="tabpanel" aria-labelledby="v-pills-crop-establishment-tab" data-activity="crop-establishment" data-has-package="true">
    <div>
        <h5>Crop Establishment</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- Hidden method input (to be toggled via JS) -->
    <input type="hidden" name="method" id="crop-method" value="">

    <!-- DWSR Section -->
    <div id="dwsr-section" class="mt-3" style="display: none;">
        <h6>DWSR (Direct Seeding)</h6>
        <div class="block">
            <label class="form-label">Type of Establishment</label>
            <select class="form-control select2 mt-2" name="establishment_type">
                <option selected disabled hidden>-- SELECT TYPE OF ESTABLISHMENT --</option>
                <option value="Manual">Manual</option>
                <option value="Drumseeder">Drumseeder</option>
                <option value="Spreader">Spreader</option>
                <option value="Others">Others</option>
            </select>
        </div>

        <div class="block mt-3">
            <input type="hidden" name="crop_est_particulars[0][activity]" value="">
            <div class="row p-3 mb-3 rounded bg-light">
                <div class="col-4">
                    <label class="form-label text-muted">Qty</label>
                    <div class="input-step step-primary full-width d-flex">
                        <button type="button" class="minus">–</button>
                        <input type="number" name="crop_est_particulars[0][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                        <button type="button" class="plus">+</button>
                    </div>
                </div>
                <div class="col-4">
                    <label class="form-label text-muted">Unit Cost</label>
                    <input type="number" name="crop_est_particulars[0][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                </div>
                <div class="col-4">
                    <label class="form-label text-muted">Total Cost</label>
                    <input type="number" name="crop_est_particulars[0][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                </div>
            </div>
        </div>
    </div>

    <!-- TPR Section -->
    <div id="tpr-section" class="mt-3" style="display: none;">
        <h6>TPR (Transplanting)</h6>

        <!-- Establishment type -->
        <div class="block">
            <div class="row g-3">
                <label class="form-label mb-0">Type of Establishment</label>
                <div class="col-12 d-flex align-items-center gap-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input labor-type" type="radio" name="establishment_type" id="establishment_type_manual" value="Manual" checked>
                        <label class="form-check-label" for="establishment_type_manual">Manual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input labor-type" type="radio" name="establishment_type" id="establishment_type_mechanical" value="Mechanical">
                        <label class="form-check-label" for="establishment_type_mechanical">Mechanical</label>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted">

        <!-- Pakyaw checkbox -->
        <div class="mt-3">
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" name="is_pakyaw" id="crop-establishment-pakyaw" value="1">
                <label class="form-check-label" for="crop-establishment-pakyaw">Package</label>
            </div>

            <!-- Total cost input for pakyaw -->
            <div class="row g-3 mt-1" id="crop-establishment-pakyaw-total-cost" style="display:none;">
                <hr class="text-muted">
                <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                    <label for="crop-establishment-pakyaw-total-cost-input" class="form-label">Total Cost</label>
                    <input type="number" class="form-control" id="crop-establishment-pakyaw-total-cost-input" placeholder="Enter Total Cost">
                </div>
            </div>

            <!-- Regular activity inputs -->
            <div id="crop-establishment-regular-fields">
                @php $activities = [
                    "Bamboo tie /Lapat (or any), bundle",
                    "Labor: Pulling and hauling of seedlings",
                    "Labor: Manual transplanting",
                    "Labor: Replanting of missing hills",
                    "Service Transplanting",
                    "Replanting",
                    "Meals and snacks"
                ]; @endphp

                @foreach ($activities as $index => $activity)
                <div class="block" {{ Str::contains($activity, ['Labor', 'Bamboo']) ? 'data-tpr-block=manual-only' : '' }}>
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">{{ $activity }}</label>
                            <input name="crop_est_particulars[{{ $index }}][activity]" value="{{ $activity }}" hidden>
                        </div>
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="crop_est_particulars[{{ $index }}][qty]" class="quantity form-control text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Unit Cost</label>
                            <input type="number" name="crop_est_particulars[{{ $index }}][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="crop_est_particulars[{{ $index }}][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                    <hr class="text-muted">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seedbed-prep-tab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
        </button>
    </div>
</div>
