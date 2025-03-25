<div class="tab-pane fade" id="pills-data-ricefarming" role="tabpanel" aria-labelledby="pills-data-ricefarming-tab">
    <div>
        <h5>Data on Rice Farming</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- Record 1 -->
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3">
                <label class="form-label">Select Farming Season</label>
                <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" type="radio" name="season[0]" id="seasonDry0" value="yes">
                    <label class="form-check-label" for="seasonDry0">Dry</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="season[0]" id="seasonWet0" value="no" checked>
                    <label class="form-check-label" for="seasonWet0">Wet</label>
                </div>
            </div>
            <div class="col-sm-3">
                <label for="year_training_conducted0" class="form-label">Year Conducted</label>
                <select class="form-control mb-3 select2" id="year_training_conducted0" name="year_training_conducted[0]">
                    <option selected disabled hidden>-- SELECT YEAR --</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <div class="row g-3">
                <div class="col-sm-3">
                    <label for="farm_size_hectares0" class="form-label">Farm Size</label>
                    <input type="text" class="form-control" id="farm_size_hectares0" name="farm_size_hectares[0]" placeholder="Enter Farm Size">
                    <div class="invalid-feedback">Please enter farm size</div>
                </div>
                <div class="col-sm-3">
                    <label for="total_yield_caban0" class="form-label">Total yield caban (sacks)</label>
                    <input type="text" class="form-control" id="total_yield_caban0" name="total_yield_caban[0]" placeholder="Enter Total Yield Caban (Sacks)">
                    <div class="invalid-feedback">Please enter total yield caban (sacks)</div>
                </div>
                <div class="col-sm-3">
                    <label for="weight_per_caban_kg0" class="form-label">Weight per caban (kg)</label>
                    <input type="text" class="form-control" id="weight_per_caban_kg0" name="weight_per_caban_kg[0]" placeholder="Enter Weight per caban (kg)">
                    <div class="invalid-feedback">Please enter weight per caban (kg)</div>
                </div>
                <div class="col-sm-3">
                    <label for="price_per_kg0" class="form-label">Price per kilogram</label>
                    <input type="text" class="form-control" id="price_per_kg0" name="price_per_kg[0]" placeholder="Enter Price per kilogram">
                    <div class="invalid-feedback">Please enter price per kilogram</div>
                </div>
                <div class="col-sm-4">
                    <label for="total_income0" class="form-label">Total income</label>
                    <input type="text" class="form-control" id="total_income0" name="total_income[0]" placeholder="Enter Total Income">
                    <div class="invalid-feedback">Please enter total income</div>
                </div>
                <div class="col-sm-4">
                    <label for="total_cost0" class="form-label">Total Cost</label>
                    <input type="text" class="form-control" id="total_cost0" name="total_cost[0]" placeholder="Enter Total Cost">
                    <div class="invalid-feedback">Please enter total cost</div>
                </div>
                <div class="col-sm-4">
                    <label for="other_crops0" class="form-label">Other Crops</label>
                    <input type="text" class="form-control" id="other_crops0" name="other_crops[0]" placeholder="Enter Other Crops">
                    <div class="invalid-feedback">Please enter other crops</div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Record 2 -->
    <div class="row g-3">
        <div class="col-sm-3">
            <label class="form-label">Select Farming Season</label>
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="season[1]" id="seasonDry1" value="yes" checked>
                <label class="form-check-label" for="seasonDry1">Dry</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="season[1]" id="seasonWet1" value="no">
                <label class="form-check-label" for="seasonWet1">Wet</label>
            </div>
        </div>
        <div class="col-sm-3">
            <label for="year_training_conducted1" class="form-label">Year Conducted</label>
            <select class="form-control mb-3 select2" id="year_training_conducted1" name="year_training_conducted[1]">
                <option selected disabled hidden>-- SELECT YEAR --</option>
            </select>
        </div>
    </div>

    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-3">
                <label for="farm_size_hectares1" class="form-label">Farm Size</label>
                <input type="text" class="form-control" id="farm_size_hectares1" name="farm_size_hectares[1]" placeholder="Enter Farm Size">
                <div class="invalid-feedback">Please enter farm size</div>
            </div>
            <div class="col-sm-3">
                <label for="total_yield_caban1" class="form-label">Total yield caban (sacks)</label>
                <input type="text" class="form-control" id="total_yield_caban1" name="total_yield_caban[1]" placeholder="Enter Total Yield Caban (Sacks)">
                <div class="invalid-feedback">Please enter total yield caban (sacks)</div>
            </div>
            <div class="col-sm-3">
                <label for="weight_per_caban_kg1" class="form-label">Weight per caban (kg)</label>
                <input type="text" class="form-control" id="weight_per_caban_kg1" name="weight_per_caban_kg[1]" placeholder="Enter Weight per caban (kg)">
                <div class="invalid-feedback">Please enter weight per caban (kg)</div>
            </div>
            <div class="col-sm-3">
                <label for="price_per_kg1" class="form-label">Price per kilogram</label>
                <input type="text" class="form-control" id="price_per_kg1" name="price_per_kg[1]" placeholder="Enter Price per kilogram">
                <div class="invalid-feedback">Please enter price per kilogram</div>
            </div>
            <div class="col-sm-4">
                <label for="total_income1" class="form-label">Total income</label>
                <input type="text" class="form-control" id="total_income1" name="total_income[1]" placeholder="Enter Total Income">
                <div class="invalid-feedback">Please enter total income</div>
            </div>
            <div class="col-sm-4">
                <label for="total_cost1" class="form-label">Total Cost</label>
                <input type="text" class="form-control" id="total_cost1" name="total_cost[1]" placeholder="Enter Total Cost">
                <div class="invalid-feedback">Please enter total cost</div>
            </div>
            <div class="col-sm-4">
                <label for="other_crops1" class="form-label">Other Crops</label>
                <input type="text" class="form-control" id="other_crops1" name="other_crops[1]" placeholder="Enter Other Crops">
                <div class="invalid-feedback">Please enter other crops</div>
            </div>
        </div>
    </div>

    <!-- Navigation Buttons -->
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label previestab" data-previous="pills-other-info-tab">
            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i> Previous
        </button>
        <button type="button" class="btn btn-success btn-label right ms-auto nexttab" data-nexttab="pills-emergency-contact-tab">
            Next <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
        </button>
    </div>
</div>
