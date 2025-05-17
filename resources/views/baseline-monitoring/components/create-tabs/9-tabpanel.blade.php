<div class="tab-pane fade" id="v-pills-pest-management" role="tabpanel"
    aria-labelledby="v-pills-pest-management-tab">
    <div>
        <h5>Pest Management</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div>
        <div class="row g-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <label class="form-label mb-0">Pesticide Details</label>
                <button id="add-pesticide-application-btn" class="btn btn-secondary">
                    <i class="ri-file-add-fill"></i> Add Application
                </button>
            </div>
        </div>
        <hr class="text-muted">
    </div>

    <div class="mt-3">
        <div id="pesticide-applications-wrapper">
            <!-- Static Initial Block -->
            <div class="card profile-project-card shadow-none profile-project-primary pesticide-application-block mt-4">
                <div class="card-body">
                    <h4 class="application-label">1st Application</h4>
                    <div>
                        <!-- Pesticide Selection -->
                        <div class="row g-3">
                            <div class="col-sm-12">
                                <label class="form-label">Select Pesticide</label>
                                <select class="form-control" id="pesticide-application-selector-1" name="pesticide-application[]" multiple data-choices data-choices-removeItem>
                                    <option value="Molluscicide">Molluscicide</option>
                                    <option value="Insecticide">Insecticide</option>
                                    <option value="Fungicide">Fungicide</option>
                                    <option value="Rodenticide">Rodenticide</option>
                                    <option value="Herbicide">Herbicide</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 mt-2">
                            <label class="form-label text-muted">Others:</label>
                            <input class="form-control" id="others-pesticide-application-1" name="others-pesticide-application" data-choices data-choices-removeItem type="text" />
                        </div>

                        <div id="pesticide-application-container-1" class="mt-3"></div>
                    </div>

                    <!-- Labor & Meals Sections (Optional, add as needed) -->

                    <!-- Labor Section -->
                    <div class="block">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Labor: Chemical Application</label>
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
                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                            </div>
                        </div>
                    </div>
                    <hr class="text-muted">

                    <div class="block">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Labor: Manual Weeding</label>
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
                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
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
                                <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab" data-previous="v-pills-water-management-tab">
            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="v-pills-harvest-management-tab">
            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next
        </button>
    </div>

    <!-- Template -->
    <template id="pesticide-application-template">
        <div class="card profile-project-card shadow-none profile-project-primary pesticide-application-block mt-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="application-label">{index} Application</h4>
                    <button type="button" class="btn btn-sm btn-danger remove-application-btn">
                        <i class="ri-delete-bin-6-line"></i> Remove
                    </button>
                </div>

                <div class="row g-3 mt-2">
                    <div class="col-sm-12">
                        <label class="form-label">Select Pesticide</label>
                        <select class="form-control" id="pesticide-application-selector-{index}" name="pesticide-application[]" multiple data-choices data-choices-removeItem>
                            <option value="Molluscicide">Molluscicide</option>
                            <option value="Insecticide">Insecticide</option>
                            <option value="Fungicide">Fungicide</option>
                            <option value="Rodenticide">Rodenticide</option>
                            <option value="Herbicide">Herbicide</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 mt-2">
                    <label class="form-label text-muted">Others:</label>
                    <input class="form-control" id="others-pesticide-application-{index}" name="others-pesticide-application" data-choices data-choices-removeItem type="text" />
                </div>

                <div id="pesticide-application-container-{index}" class="mt-3"></div>


                <!-- Labor Section -->
                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Chemical Application</label>
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
                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                        </div>
                    </div>
                </div>
                <hr class="text-muted">

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Manual Weeding</label>
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
                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
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
                            <input type="number" class="form-control total-cost" placeholder="Total Cost" disabled/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>
