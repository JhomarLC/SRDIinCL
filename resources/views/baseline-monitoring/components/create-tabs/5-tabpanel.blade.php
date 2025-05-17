 <div class="tab-pane fade" id="v-pills-seedbed-fertilization" role="tabpanel"
    aria-labelledby="v-pills-seedbed-fertilization-tab">
    <div>
        <h5>Seedbed Fertilization</h5>
        <p class="text-muted">Fill all information below</p>
    </div>
    <div>
        <div class="row g-3">
           <div class="col-12 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Fertilizer Details</label>
            </div>
        </div>
        <hr class="text-muted">
    </div>
    <div>
        <div class="row g-3">
            <div class="col-sm-12">
                <label for="yearTrainingConducted" class="form-label">Select Fertilizer</label>
                <select class="form-control" id="fertilizer-selector"
                    name="fertilizer[]"
                    data-choices
                    data-choices-removeItem
                    multiple>
                    <option value="Complete (14-14-14-24S)">Complete (14-14-14-24S)</option>
                    <option value="Ammonium Phosphate (16-20-0)">Ammonium Phosphate (16-20-0)</option>
                    <option value="Ammonium Sulphate (21-0-0-24S)">Ammonium Sulphate (21-0-0-24S)</option>
                    <option value="Muriate of Potash (0-0-60)">Muriate of Potash (0-0-60)</option>
                    <option value="Urea (46-0-0)">Urea (46-0-0)</option>
                </select>
            </div>
        </div>
        <div class="col-12 mt-2">
            <label class="form-label text-muted">Others:</label>
            <input class="form-control" id="others-fertilizer" name="others-fertilizer" data-choices data-choices-removeItem type="text"/>
        </div>
        <div id="fertilizer-container" class="mt-3">
    </div>
    </div>
    <div class="mt-3">
        <!-- Regular Inputs -->

        <div id="seedbed-fertilization-regular-fields">
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Seedbed Fertilizer Application</label>
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
                        <input type="number" class="form-control unit-cost soaking-unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" class="form-control total-cost soaking-total-cost" placeholder="Total Cost" disabled/>
                    </div>
                </div>
            </div>

            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meals and Snacks</label>
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
            <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seedbed-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
            </button>
        </div>
    </div>
</div>
<!-- end tab pane-->
