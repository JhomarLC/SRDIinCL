<div class="tab-pane fade" id="v-pills-harvest-management" role="tabpanel" aria-labelledby="v-pills-harvest-management-tab">
    <div>
        <h5>Harvest Management</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- Harvesting Type Selector -->
    <div class="row g-3">
        <div class="col-12 d-flex align-items-center gap-3">
            <label class="form-label mb-0">Type of Harvesting</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input harvesting-type" type="radio" name="harvesting-type" id="manual-harvesting" value="Manual">
                <label class="form-check-label" for="manual-harvesting">Manual</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input harvesting-type" type="radio" name="harvesting-type" id="mechanical-harvesting" value="Mechanical" checked>
                <label class="form-check-label" for="mechanical-harvesting">Mechanical</label>
            </div>
        </div>
    </div>

    <hr class="text-muted">

    <!-- MECHANICAL BLOCK -->
    <div class="block" id="mechanical-block">
        <div class="row g-3 mt-2">
            <div class="col-12">
                <label class="form-label">Mechanical Harvesting</label>
            </div>
        </div>
        <div class="row p-3 mb-3 rounded bg-light">
            <div class="col-3">
                <label class="form-label text-muted">Bags</label>
                <div class="input-step step-primary full-width d-flex">
                    <button type="button" class="minus">–</button>
                    <input type="number" class="product-quantity form-control text-center" value="0" min="0" step="1">
                    <button type="button" class="plus">+</button>
                </div>
            </div>
            <div class="col-3">
                <label class="form-label text-muted">Avg. Bag Weight</label>
                <input type="number" class="form-control unit-cost" placeholder="Avg Bag Weight" />
            </div>
            <div class="col-3">
                <label class="form-label text-muted">Price per Kilo</label>
                <input type="number" class="form-control unit-cost" placeholder="Price per Kilo" />
            </div>
            <div class="col-3">
                <label class="form-label text-muted">Total Cost</label>
                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled />
            </div>
        </div>
    </div>

    <hr class="text-muted">

    <!-- PACKAGE OPTION -->
    <div class="mt-3">
        <div class="form-check mb-2" id="manual-package-checkbox-container">
            <input type="checkbox" class="form-check-input" id="manual-package-checkbox">
            <label class="form-check-label" for="manual-package-checkbox">Package</label>
        </div>

        <!-- TOTAL COST WHEN PACKAGE IS SELECTED -->
        <div class="row g-3 mt-1" id="manual-package-total-cost" style="display:none;">
            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                <label for="manualPackageTotalCost" class="form-label">Total Cost</label>
                <input type="number" class="form-control" id="manualPackageTotalCost" placeholder="Enter Total Cost">
            </div>
        </div>

        <hr class="text-muted">

        <!-- MANUAL INPUT FIELDS -->
        <div id="manual-fields">
            <!-- REPEATABLE INPUT BLOCK EXAMPLE -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Manual Harvesting</label>
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

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Manual Harvesting</label>
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

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Threshing</label>
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

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Hauling</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Sacks, ordinary</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Sacks, laminated</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Twine, bundle</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Twine needle, pc</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Soft Thread, roll</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Needle, pc</label>
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

                <div class="block">
                    <div class="row g-3 mt-2">
                        <div class="col-12">
                            <label class="form-label">Meals and Snacks</label>
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
            </div>
            <!-- Repeat more blocks as needed... -->
        </div>
    </div>

    <!-- NAVIGATION BUTTONS -->
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-dry-season-info-tab">
            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-seeds-prep-tab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
        </button>
    </div>
</div>
