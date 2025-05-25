  <div class="tab-pane fade" id="v-pills-land-preparation" role="tabpanel" aria-labelledby="v-pills-land-preparation-tab">
    <div>
        <h5>Land Preparation</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div class="mt-3">
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="land-prep-pakyaw" name="is_pakyaw">
            <label class="form-check-label" for="land-prep-pakyaw">Package</label>
        </div>

        <!-- Single Total Cost for Pakyaw -->
        <div class="row g-3 mt-1" id="land-prep-pakyaw-total-cost" style="display:none;">
            <hr class="text-muted">
            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                <label for="package_cost" class="form-label">Total Cost</label>
                <input type="number" class="form-control" id="package_cost" name="package_cost" placeholder="Enter Total Cost">
            </div>
        </div>
        <hr class="text-muted">
        <!-- Regular Inputs -->
        <div id="land-prep-regular-fields">
            <!-- Repeatable Block Starts -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Cleaning and repair of dikes</label>
                    </div>
                    <input name="land_prep[0][activity]" value="Cleaning and repair of dikes" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[0][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[0][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[0][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled/>
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Plowing</label>
                    </div>
                    <input name="land_prep[1][activity]" value="Plowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[1][qty]" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[1][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[1][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">
            <!-- End of each block -->

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Side Plowing</label>
                    </div>
                    <input name="land_prep[2][activity]" value="Side Plowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[2][qty]" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[2][unit_cost]"  class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[2][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">
            <!-- End of each block -->

           <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: 1st Harrowing</label>
                    </div>
                    <input name="land_prep[3][activity]" value="1st Harrowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[3][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[3][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[3][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: 2nd Harrowing</label>
                    </div>
                    <input name="land_prep[4][activity]" value="2nd Harrowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[4][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[4][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[4][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: 3rd Harrowing</label>
                    </div>
                    <input name="land_prep[5][activity]" value="3rd Harrowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[5][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[5][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[5][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Final Leveling</label>
                    </div>
                    <input name="land_prep[6][activity]" value="Final Leveling" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[6][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[6][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[6][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Meals and Snacks</label>
                    </div>
                    <input name="land_prep[7][activity]" value="Meals and Snacks" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="land_prep[7][qty]" class="form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="land_prep[7][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="land_prep[7][total_cost]" class="form-control total-cost" placeholder="Total Cost" disabled />
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
