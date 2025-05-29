
<div class="tab-pane fade" id="v-pills-fertilizer-management" role="tabpanel" aria-labelledby="v-pills-fertilizer-management-tab" data-activity="fertilizer-management" data-has-package="true">
    <div>
        <h5>Fertilizer Management</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div>
        <div class="row g-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Application Details</label>
                <button type="button" id="add-fertilizer-mgmt-btn" class="btn btn-secondary">
                    <i class="ri-file-add-fill"></i> Add Application
                </button>
            </div>
        </div>
        <hr class="text-muted">
    </div>

    <div class="mt-3">
        <div id="fertilizer-mgmt-wrapper">
            <!-- Initial Application Block -->
            <div class="card fertilizer-application-block mt-4">
                <div class="card-body">
                    <h4>1st Application</h4>

                    <!-- Fertilizer Selection -->
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Select Fertilizer</label>
                            <select class="form-control" id="fertilizer_mgmt_0_selector" name="fertilizer_mgmt[0][fertilizer][]" multiple data-choices data-choices-removeItem>
                                <!-- options -->
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-label text-muted">Others:</label>
                        <input class="form-control" id="fertilizer_mgmt_0_others" name="fertilizer_mgmt[0][others]" type="text" data-choices data-choices-removeItem />
                    </div>

                    <div id="fertilizer_mgmt_0_container" class="mt-3"></div>

                    <!-- Labor Section -->
                    <div class="block mt-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Labor: Fertilizer Application</label>
                            </div>
                            <input type="hidden" name="fertilizer_mgmt[0][activity]" value="Fertilizer Application">
                        </div>

                        <div class="row p-3 mb-3 rounded bg-light">
                            <div class="col-4">
                                <label class="form-label text-muted">Qty</label>
                                <div class="input-step step-primary full-width d-flex">
                                    <button type="button" class="minus">–</button>
                                    <input type="number" name="fertilizer_mgmt[0][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                    <button type="button" class="plus">+</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Unit Cost</label>
                                <input type="number" name="fertilizer_mgmt[0][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Total Cost</label>
                                <input type="number" name="fertilizer_mgmt[0][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                            </div>
                        </div>
                    </div>

                    <!-- Meals and Snacks -->
                    <div class="block">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Meals and Snacks</label>
                            </div>
                            <input type="hidden" name="fertilizer_mgmt[1][activity]" value="Meals and Snacks">
                        </div>

                        <div class="row p-3 mb-3 rounded bg-light">
                            <div class="col-4">
                                <label class="form-label text-muted">Qty</label>
                                <div class="input-step step-primary full-width d-flex">
                                    <button type="button" class="minus">–</button>
                                    <input type="number" name="fertilizer_mgmt[1][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                    <button type="button" class="plus">+</button>
                                </div>
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Unit Cost</label>
                                <input type="number" name="fertilizer_mgmt[1][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                            </div>
                            <div class="col-4">
                                <label class="form-label text-muted">Total Cost</label>
                                <input type="number" name="fertilizer_mgmt[1][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
                <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
            </button>
            <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seedbed-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i> Next
            </button>
        </div>
    </div>

    <!-- Template for Cloning -->
    <template id="fertilizer-mgmt-template">
        <div class="card fertilizer-application-block mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="application-label">Application</h4>
                    <button type="button" class="btn btn-sm btn-danger remove-application-btn">
                        <i class="ri-delete-bin-6-line"></i> Remove
                    </button>
                </div>

                <div>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label class="form-label">Select Fertilizer</label>
                            <select class="form-control" id="fertilizer_mgmt_{index}_selector" name="fertilizer_mgmt[{index}][fertilizer][]" multiple data-choices data-choices-removeItem>
                                <!-- options -->
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-2">
                        <label class="form-label text-muted">Others:</label>
                        <input class="form-control" id="fertilizer_mgmt_{index}_others" name="fertilizer_mgmt[{index}][others]" type="text" data-choices data-choices-removeItem />
                    </div>

                    <div id="fertilizer_mgmt_{index}_container" class="mt-3"></div>
                </div>

                <!-- Labor Section -->
                <div class="block mt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Fertilizer Application</label>
                        </div>
                        <input type="hidden" name="fertilizer_mgmt[{index}][activity]" value="Fertilizer Application">
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="fertilizer_mgmt[{index}][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Unit Cost</label>
                            <input type="number" name="fertilizer_mgmt[{index}][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="fertilizer_mgmt[{index}][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                </div>

                <!-- Meals and Snacks -->
                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meals and Snacks</label>
                        </div>
                        <input type="hidden" name="fertilizer_mgmt[{index}+1][activity]" value="Meals and Snacks">
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="fertilizer_mgmt[{index}+1][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Unit Cost</label>
                            <input type="number" name="fertilizer_mgmt[{index}+1][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="fertilizer_mgmt[{index}+1][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
