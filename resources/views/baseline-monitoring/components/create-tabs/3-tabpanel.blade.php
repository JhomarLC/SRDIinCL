<div class="tab-pane fade" id="v-pills-seeds-prep" role="tabpanel" aria-labelledby="v-pills-seeds-prep-tab">
    <div>
        <h5>Seeds Preparation</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <div class="mt-3">
        <!-- Package Checkbox -->
        <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="seeds-prep-pakyaw">
            <label class="form-check-label" for="seeds-prep-pakyaw">Package</label>
        </div>

        <!-- Single Total Cost for Pakyaw -->
        <div class="row g-3 mt-1" id="seeds-prep-pakyaw-total-cost" style="display:none;">
            <hr class="text-muted">
            <div class="col-12 bg-light p-3 mb-3 rounded mt-0">
                <label for="seedsPrepPakyawTotalCost" class="form-label">Seeds Prep Cost</label>
                <input type="number" class="form-control" id="seedsPrepPakyawTotalCost" placeholder="Enter Total Cost">
            </div>
        </div>

        <!-- Regular Inputs -->
        <div id="seeds-prep-regular-fields">
        <!-- Soaking -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Soaking</label>
                    </div>
                    <input name="seed_prep[0][activity]" value="Soaking" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="seed_prep[0][qty]" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="seed_prep[0][unit_cost]" class="form-control unit-cost unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="seed_prep[0][total_cost]" class="form-control total-cost total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>

            <hr class="text-muted">

            <!-- Incubation -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Incubation</label>
                    </div>
                    <input name="seed_prep[1][activity]" value="Incubation" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="seed_prep[1][qty]" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="seed_prep[1][unit_cost]" class="form-control unit-cost unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="seed_prep[1][total_cost]" class="form-control total-cost total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>

            <hr class="text-muted">

            <!-- Sowing -->
            <div class="block">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Labor: Sowing</label>
                    </div>
                    <input name="seed_prep[2][activity]" value="Sowing" hidden>
                </div>
                <div class="row p-3 mb-3 rounded bg-light">
                    <div class="col-4">
                        <label class="form-label text-muted">Qty</label>
                        <div class="input-step step-primary full-width d-flex">
                            <button type="button" class="minus">–</button>
                            <input type="number" name="seed_prep[2][qty]" class="product-quantity form-control text-center quantity" value="0" min="0" step="1">
                            <button type="button" class="plus">+</button>
                        </div>
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Unit Cost</label>
                        <input type="number" name="seed_prep[2][unit_cost]" class="form-control unit-cost unit-cost" placeholder="Unit Cost" />
                    </div>
                    <div class="col-4">
                        <label class="form-label text-muted">Total Cost</label>
                        <input type="number" name="seed_prep[2][total_cost]" class="form-control total-cost total-cost" placeholder="Total Cost" disabled />
                    </div>
                </div>
            </div>

            <hr class="text-muted">
        </div>
        <div>
            <div class="row mt-2 g-3">
                <div class="col-sm-12">
                    <label for="yearTrainingConducted" class="form-label">Select Variety</label>
                    <select class="form-control" id="variety-selector"
                        name="varieties[]"
                        data-choices
                        data-choices-removeItem
                        multiple>
                        @foreach ($varieties as $variety)
                            <option
                                value="{{ $variety->id }}"
                                data-name="{{ $variety->name }}{{ $variety->local_name ? ' - ' . $variety->local_name : '' }}">
                                {{ $variety->name }}{{ $variety->local_name ? ' - ' . $variety->local_name : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="variety-container" class="mt-3">
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
</div>
