
<!-- START: Water Management Tab -->
<div class="tab-pane fade show" id="v-pills-water-management" role="tabpanel" aria-labelledby="v-pills-water-management-tab">
    <div>
        <h5>Water Management</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- Irrigation Type -->
    <div class="row g-3">
        <div class="col-12 d-flex align-items-center gap-3">
            <label class="form-check-label">Type of Irrigation</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-nia" value="nia">
                <label class="form-check-label" for="water-management-nia">NIA</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input irrigation-type" type="radio" name="water-management-type" id="water-management-supplementary" value="supplementary" checked>
                <label class="form-check-label" for="water-management-supplementary">Supplementary</label>
            </div>
        </div>
    </div>
    <hr class="text-muted">

    <!-- NIA Total Cost (Per Application) -->
    <div class="row g-3 mt-1" id="water-management-nia-total-cost" style="display:none;">
        <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
            <label class="form-label">NIA Total Amount</label>
            <input type="number" class="form-control" placeholder="Enter Total Cost">
        </div>
    </div>

    <!-- Supplementary Package Section -->
    <div class="mt-3" id="water-management-regular-fields">
        <div class="row mb-2">
            <div class="col d-flex align-items-center justify-content-between">
                <!-- Checkbox on the left -->
                <div class="form-check mb-0">
                    <input type="checkbox" class="form-check-input" id="water-management-pakyaw">
                    <label class="form-check-label" for="water-management-pakyaw">Package</label>
                </div>

                <!-- Button on the right -->
                <button type="button" class="btn btn-secondary add-irrigation">
                    <i class="ri-file-add-fill"></i> Add Irrigation
                </button>
            </div>
        </div>

        <!-- Package Total Cost -->
        <div class="row g-3 mt-1" id="water-management-pakyaw-total-cost" style="display:none;">
            <hr class="text-muted">
            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                <label class="form-label">Total Cost</label>
                <input type="number" class="form-control" placeholder="Enter Total Cost">
            </div>
        </div>

        <!-- All Irrigation Blocks -->
        <div id="irrigation-blocks-container">
            <div class="card profile-project-card shadow-none profile-project-primary irrigation-block">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div class="mt-1 irrigation-column">
                                <h4 class="irrigation-title">1st Irrigation</h4>
                                <div class="irrigation-methods mt-2">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_both_type_1" id="is_nia_both_1" value="is_nia_both">
                                        <label class="form-check-label" for="is_nia_both_1">NIA</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_both_type_1" id="is_suplementary_both_1" value="is_suplementary_both" checked>
                                        <label class="form-check-label" for="is_suplementary_both_1">Supplementary</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NIA Cost Per Irrigation -->
                    <div class="row g-3 mt-2 nia-total-cost-irrigation" style="display: none;">
                        <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                            <label class="form-label">NIA Total Amount</label>
                            <input type="number" class="form-control" placeholder="Enter Total Cost">
                        </div>
                    </div>

                    <!-- Supplementary Breakdown -->
                    <div class="supplementary-irrigation-details">
                        <div class="block">
                            <div class="row g-3 mt-2">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <label class="form-label">Irrigation fee (NIS/CIS)</label>
                                    <select class="form-select form-select-sm irrigation-source-selector" style="width:auto; display:none;">
                                        <option value="nia">NIA</option>
                                        <option value="supplementary">Supplementary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
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

                        <!-- Fuel Cost -->
                        <div class="block">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <label class="form-label">Fuel cost (STW), liters</label>
                                    <select class="form-select form-select-sm irrigation-source-selector" style="width:auto; display:none;">
                                        <option value="nia">NIA</option>
                                        <option value="supplementary">Supplementary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
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

                        <!-- Labor -->
                        <div class="block">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <label class="form-label">Labor: Irrigation</label>
                                    <select class="form-select form-select-sm irrigation-source-selector" style="width:auto; display:none;">
                                        <option value="nia">NIA</option>
                                        <option value="supplementary">Supplementary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
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

                        <!-- Meals -->
                        <div class="block">
                            <div class="row g-3">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <label class="form-label">Meals and Snacks</label>
                                    <select class="form-select form-select-sm irrigation-source-selector" style="width:auto; display:none;">
                                        <option value="nia">NIA</option>
                                        <option value="supplementary">Supplementary</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row p-3 mb-3 rounded bg-light">
                                <div class="col-4">
                                    <label class="form-label text-muted">Qty</label>
                                    <div class="input-step step-primary full-width d-flex">
                                        <button type="button" class="minus">–</button>
                                        <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
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
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
        </button>
    </div>
</div>
<!-- END: Water Management Tab -->
