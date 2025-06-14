<div class="tab-pane fade" id="v-pills-other-expenses" role="tabpanel" aria-labelledby="v-pills-other-expenses-tab" data-activity="other-expenses" data-has-package="false">
    <div>
        <h5>Other Expenses</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div class="mt-3">
        <!-- OTHER EXPENSES FIELDS -->
        <div id="other-regular-fields">

            <!-- Hauling -->
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
                            <input type="number" name="other_expenses[hauling][bags]" class="form-control text-center" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="other_expenses[hauling][unit_cost]" class="form-control" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="other_expenses[hauling][total_cost]" class="form-control" placeholder="Total Cost" readonly />
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <!-- Permanent Hired Labor Fee -->
            <div class="block" id="permanent-block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Permanent Hired Labor Fee</label>
                    </div>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="row col-12">
                        <div class="col-4">
                            <label class="form-label text-muted">Bags</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="other_expenses[permanent_labor][bags]" class="form-control text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Avg. Bag Weight (kg)</label>
                            <input type="number" name="other_expenses[permanent_labor][avg_bag_weight]" class="form-control" placeholder="Avg Bag Weight" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Price per Kilo</label>
                            <input type="number" name="other_expenses[permanent_labor][price_per_kg]" class="form-control" placeholder="Price per Kilo" />
                        </div>
                    </div>

                    <div class="row col-12 mt-2">
                        <div class="col-6">
                            <label class="form-label text-muted">Percent Share of Total Bags Harvested</label>
                            <input type="number" name="other_expenses[permanent_labor][percent_share]" class="form-control" placeholder="Percent Share of Total Bags Harvested" />
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="other_expenses[permanent_labor][total_cost]" class="form-control" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text-muted">

            <!-- Land Ownership Fee (Amilyar) -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Land Ownership Fee (Amilyar)</label>
                    </div>
                </div>
                <div class="row g-3 mt-1">
                    <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                        <label for="amilyar-fee" class="form-label">Total Cost</label>
                        <input type="number" name="other_expenses[amilyar][total_cost]" class="form-control" id="amilyar-fee" placeholder="Enter Total Cost">
                    </div>
                </div>
            </div>
            <hr class="text-muted">

        </div>

        <!-- NAVIGATION BUTTON -->
        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button" id="submitBaseline" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Done
            </button>
        </div>
    </div>
</div>
