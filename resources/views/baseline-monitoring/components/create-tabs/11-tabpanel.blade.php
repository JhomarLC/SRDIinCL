<div class="tab-pane fade" id="v-pills-other-expenses" role="tabpanel" aria-labelledby="v-pills-other-expenses-tab">
    <div>
        <h5>Other Expenses</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div class="mt-3">
        <!-- Regular Inputs -->
        <div id="other-regular-fields">
            <!-- Repeatable Block Starts -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Hauling</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Bags</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" class="quantity form-control text-center" value="0" min="0" step="1">
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

            <div class="block" id="permanent-block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Permanent Hired Labor Fee</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class=" row col-12">
                        <div class="col-4">
                            <label class="form-label text-muted">Bags</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="bags form-control text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Avg. Bag Weight (kg)</label>
                            <input type="number" class="form-control avg-bag-weight" placeholder="Avg Bag Weight" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Price per Kilo</label>
                            <input type="number" class="form-control price-per-kg" placeholder="Price per Kilo" />
                        </div>
                    </div>

                    <div class="row col-12 mt-2">
                        <div class="col-6">
                            <label class="form-label text-muted">Percent Share of Total Bags Harvested </label>
                            <input type="number" class="form-control percent-share" placeholder="Percent Share of Total Bags Harvested" />
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" class="form-control total-permanent-cost" placeholder="Total Cost" disabled />
                        </div>
                    </div>

                </div>
            </div>
            <hr class="text-muted">
            <!-- End of each block -->

            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Land Ownership Fee (amilyar)</label>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                        <label for="amilyar-fee" class="form-label">Total Cost</label>
                        <input type="number" class="form-control" id="amilyar-fee" placeholder="Enter Total Cost">
                    </div>
                </div>

            </div>
            <hr class="text-muted">
            <!-- End of each block -->

        </div>

        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button" id="submitBaseline" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Done
            </button>
        </div>
    </div>
</div>
