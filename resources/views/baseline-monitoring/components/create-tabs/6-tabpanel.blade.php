
<div class="tab-pane fade" id="v-pills-crop-establishment" role="tabpanel" aria-labelledby="v-pills-crop-establishment-tab">
    <div>
        <h5>Crop Establishment</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- DWSR Section -->
    <div id="dwsr-section" class="mt-3" style="display: none;">
        <h6>DWSR (Direct Seeding)</h6>
        <!-- Put the existing DWSR content here -->
        <!-- Example only -->
        <div class="block">
            <label class="form-label">Type of Establishment</label>
            <select class="form-control select2 mt-2">
                <option selected disabled hidden>-- SELECT TYPE OF ESTABLISHMENT --</option>
                <option value="Manual">Manual</option>
                <option value="Drumseeder">Drumseeder</option>
                <option value="Spreader">Spreader</option>
                <option value="Others">Others</option>
            </select>
            <!-- Qty / Unit Cost / Total -->
        </div>
        <!-- Repeat blocks here... -->
        <div class="row p-3 mt-2 mb-3 rounded bg-light">
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

    <!-- TPR Section -->
    <div id="tpr-section" class="mt-3" style="display: none;">
        <h6>TPR (Transplanting)</h6>
        <!-- Put the existing TPR content here -->
        <div class="block">
            <div class="row g-3">
                <label class="form-label mb-0">Type of Establishment</label>
                <div class="col-12 d-flex align-items-center gap-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input labor-type" type="radio" name="soaking-type" id="soaking-free" value="free" checked>
                        <label class="form-check-label" for="soaking-free">Manual</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input labor-type" type="radio" name="soaking-type" id="soaking-purchase" value="purchase">
                        <label class="form-check-label" for="soaking-purchase">Mechanical</label>
                    </div>
                </div>
            </div>
        </div>
        <hr class="text-muted">
        <div class="mt-3">
            <div class="form-check mb-2">
                <input type="checkbox" class="form-check-input" id="crop-establishment-pakyaw">
                <label class="form-check-label" for="crop-establishment-pakyaw">Package</label>
            </div>

            <!-- Single Total Cost for Pakyaw -->
            <div class="row g-3 mt-1" id="crop-establishment-pakyaw-total-cost" style="display:none;">
                <hr class="text-muted">
                <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                    <label for="landPrepPakyawTotalCost" class="form-label">Total Cost</label>
                    <input type="number" class="form-control" id="landPrepPakyawTotalCost" placeholder="Enter Total Cost">
                </div>
            </div>

            <div id="crop-establishment-regular-fields">
                <div class="block" data-tpr-block="manual-only">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Bamboo tie /Lapat (or any), bundle</label>
                        </div>
                    </div>
                    <div class="row p-3 mb-3 rounded bg-light">
                        <div class="col-4">
                            <label class="form-label text-muted">Qty</label>
                            <div class="input-step step-primary full-width d-flex">
                                <button type="button" class="minus">–</button>
                                <input type="number" class="product-quantity form-control text-center soaking-qty" value="0" min="0" step="1">
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

                <div class="block" data-tpr-block="manual-only">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Pulling and hauling of seedlings</label>
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

                <div class="block" data-tpr-block="manual-only">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Manual transplanting</label>
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

                <div class="block" data-tpr-block="manual-only">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Labor: Replanting of missing hills</label>
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Service Transplanting </label>
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Replanting</label>
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
                    <hr class="text-muted">
                </div>


                <div class="block">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Meals and snacks</label>
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
                    <hr class="text-muted">
                </div>
                <!-- End of each block -->

            </div>
        </div>
        <!-- No changes needed inside, just wrap it -->
        <!-- Include all those blocks: Bamboo Tie, Pulling, Replanting, etc. -->
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
