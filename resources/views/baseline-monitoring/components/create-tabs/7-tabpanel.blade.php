<div class="tab-pane fade" id="v-pills-fertilizer-management" role="tabpanel"
     aria-labelledby="v-pills-fertilizer-management-tab"
     data-activity="fertilizer-management" data-has-package="false">

    <div>
        <h5>Fertilizer Management</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div>
        <div class="row g-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Application Details</label>
                <button type="button" id="add-application-btn" class="btn btn-secondary">
                    <i class="ri-file-add-fill"></i> Add Application
                </button>
            </div>
        </div>
        <hr class="text-muted">
    </div>

    <div class="mt-3">
        <div id="fertilizer-applications-wrapper">
            <!-- Initial Application Block (index = 1) -->
            <div class="card profile-project-card shadow-none profile-project-primary fertilizer-application-block mt-4">
                <div class="card-body">
                    <h4 class="application-label">1st Application</h4>
                    <div>
                        <!-- Fertilizer Selection -->
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label class="form-label">Select Fertilizer</label>
                                <select class="form-control" id="fertilizer-application-selector-1"
                                        name="fertilizer-application[]" multiple data-choices data-choices-removeItem>
                                    <option value="Complete (14-14-14-12S)">Complete (14-14-14-12S)</option>
                                    <option value="Urea (46-0-0)">Urea (46-0-0)</option>
                                    <option value="Muriate of Potash (0-0-60)">Muriate of Potash (0-0-60)</option>
                                    <option value="AmmoSul (21-0-0-24)">AmmoSul (21-0-0-24)</option>
                                    <option value="AmmoPhos (16-20-0)">AmmoPhos (16-20-0)</option>
                                    <option value="AmmoPhos (18-46-0)">AmmoPhos (18-46-0)</option>
                                    <option value="SoloPhos (0-18-0)">SoloPhos (0-18-0)</option>
                                    <option value="Copper Sulfate">Copper Sulfate</option>
                                    <option value="Zinc Sulfate">Zinc Sulfate</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-label text-muted">Others:</label>
                            <input class="form-control" id="others-fertilizer-application-1"
                                   name="others-fertilizer-application" type="text" />
                        </div>

                        <div id="fertilizer-application-container-1" class="mt-3"></div>
                    </div>

                    <div class="fertilizer-management-block">
                        <!-- Labor: Fertilizer Application -->
                        <div class="block mt-3">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Labor: Fertilizer application</label>
                                    <input name="fert_management[1][0][activity]" value="Labor: Fertilizer application" hidden>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" name="fert_management[1][0][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" name="fert_management[1][0][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" name="fert_management[1][0][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                                </div>
                            </div>
                        </div>

                        <!-- Labor: Meals and Snacks -->
                        <div class="block">
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Meals and Snacks</label>
                                    <input name="fert_management[1][1][activity]" value="Meals and Snacks" hidden>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" name="fert_management[1][1][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                        <button type="button" class="plus">+</button>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Unit Cost</label>
                                    <input type="number" name="fert_management[1][1][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                                </div>
                                <div class="col-4">
                                    <label class="form-label text-muted">Total Cost</label>
                                    <input type="number" name="fert_management[1][1][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
                <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
            </button>
            <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seedbed-prep-tab">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
            </button>
        </div>
    </div>

    <!-- Template for cloning more applications -->
    <template id="fertilizer-application-template">
        <div class="card profile-project-card shadow-none profile-project-primary fertilizer-application-block mt-4">
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
                            <select class="form-control" id="fertilizer-application-selector-{index}"
                                    name="fertilizer-application[]" multiple data-choices data-choices-removeItem>
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
                        <input class="form-control" id="others-fertilizer-application-{index}"
                               name="others-fertilizer-application" type="text" />
                    </div>

                    <div id="fertilizer-application-container-{index}" class="mt-3"></div>
                </div>

                <!-- Labor: Fertilizer Application -->
                <div class="block mt-3">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Fertilizer application</label>
                            <input name="fert_management[{index}][0][activity]" value="Labor: Fertilizer application" hidden>
                        </div>
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="fert_management[{index}][0][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Unit Cost</label>
                            <input type="number" name="fert_management[{index}][0][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="fert_management[{index}][0][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                </div>

                <!-- Labor: Meals and Snacks -->
                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meals and Snacks</label>
                            <input name="fert_management[{index}][1][activity]" value="Meals and Snacks" hidden>
                        </div>
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" name="fert_management[{index}][1][qty]" class="form-control quantity text-center" value="0" min="0" step="1">
                                <button type="button" class="plus">+</button>
                            </div>
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Unit Cost</label>
                            <input type="number" name="fert_management[{index}][1][unit_cost]" class="form-control unit-cost" placeholder="Unit Cost" />
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted">Total Cost</label>
                            <input type="number" name="fert_management[{index}][1][total_cost]" class="form-control total-cost" placeholder="Total Cost" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
