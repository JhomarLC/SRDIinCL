 <div class="tab-pane fade" id="v-pills-seedbed-prep" role="tabpanel" aria-labelledby="v-pills-seedbed-prep-tab">
    <div>
        <h5>Seedbed Preparation</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div class="mt-3">
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="seedbed-prep-pakyaw">
            <label class="form-check-label" for="seedbed-prep-pakyaw">Package</label>
        </div>

        <!-- Single Total Cost for Pakyaw -->
        <div class="row g-3 mt-1" id="seedbed-prep-pakyaw-total-cost" style="display:none;">
            <hr class="text-muted">
            {{-- <label for="seedbedPrepPakyawTotalCost" class="form-label mt-0">Total Cost</label> --}}
            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                <label for="seedbedPrepPakyawTotalCost" class="form-label">Total Cost</label>
                <input type="number" class="form-control" id="seedbedPrepPakyawTotalCost" placeholder="Enter Total Cost">
            </div>
        </div>

        <hr class="text-muted">

        <!-- Regular Inputs -->
        <div id="seedbed-prep-regular-fields">
            <!-- Repeatable Block Starts -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Plowing</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Harrowing</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">
            <!-- End of each block -->

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Seedbed Construction</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">
            <!-- End of each block -->

        </div>

        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
                <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
            </button>
            <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
            </button>
        </div>
    </div>
</div>
<!-- end tab pane -->
