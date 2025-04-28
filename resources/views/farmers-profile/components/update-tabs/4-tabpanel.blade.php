<div class="tab-pane fade" id="pills-data-ricefarming" role="tabpanel" aria-labelledby="pills-data-ricefarming-tab">
    <div>
        <h5>Data on Rice Farming</h5>
        <p class="text-muted">Fill all information below</p>
    </div>

    <!-- Record 1 -->
    <div class="mt-3">
        <div class="card profile-project-card shadow-none profile-project-secondary">
            <div class="card-body p-4">
                <div class="d-flex">
                    <div class="flex-grow-1 text-muted overflow-hidden">
                        <div class="badge bg-secondary-subtle text-secondary fs-12">Wet Season</div>
                        <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                            March 16 - September 15
                        </span></p>
                    </div>
                    <input class="form-check-input" type="radio" name="season[0]" id="seasonDry0" value="Dry Season" {{ old('season[0]', $participant->farming_data[0]->season ?? '') == 'Dry Season' ? 'checked' : '' }} hidden>
                    <input class="form-check-input" type="radio" name="season[0]" id="seasonWet0" value="Wet Season" {{ old('season[0]', $participant->farming_data[0]->season ?? '') == 'Wet Season' ? 'checked' : '' }} hidden>
                    <div class="col-sm-3">
                        <label for="year_training_conducted0" class="form-label">Year Conducted</label>
                            <select class="form-control mb-3 select2"
                                id="year_training_conducted0"
                                name="year_training_conducted[0]"
                                data-selected="{{ old('year_training_conducted[0]', $participant->farming_data[0]->year_training_conducted ?? '') }}">
                            <option disabled hidden selected>-- SELECT YEAR --</option>
                        </select>
                        <div class="invalid-feedback">Please select year</div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row g-3">
                        <div class="col-sm-3">
                            <label for="farm_size_hectares0" class="form-label">Farm Size</label>
                            <input type="text" class="form-control" id="farm_size_hectares0" name="farm_size_hectares[0]" placeholder="Enter Farm Size" value="{{ old('farm_size_hectares[0]', $participant->farming_data[0]->farm_size_hectares ?? '') }}">
                            <div class="invalid-feedback">Please enter farm size</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_yield_caban0" class="form-label">Total yield caban (sacks)</label>
                            <input type="text" class="form-control" id="total_yield_caban0" name="total_yield_caban[0]" placeholder="Enter Total Yield Caban (Sacks)" value="{{ old('total_yield_caban[0]', $participant->farming_data[0]->total_yield_caban ?? '') }}">
                            <div class="invalid-feedback">Please enter total yield caban (sacks)</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="weight_per_caban_kg0" class="form-label">Weight per caban (kg)</label>
                            <input type="text" class="form-control" id="weight_per_caban_kg0" name="weight_per_caban_kg[0]" placeholder="Enter Weight per caban (kg)" value="{{ old('weight_per_caban_kg[0]', $participant->farming_data[0]->weight_per_caban_kg ?? '') }}">
                            <div class="invalid-feedback">Please enter weight per caban (kg)</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="price_per_kg0" class="form-label">Price per kilogram</label>
                            <input type="text" class="form-control" id="price_per_kg0" name="price_per_kg[0]" placeholder="Enter Price per kilogram" value="{{ old('price_per_kg[0]', $participant->farming_data[0]->price_per_kg ?? '') }}">
                            <div class="invalid-feedback">Please enter price per kilogram</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_income0" class="form-label">Total income</label>
                            <input type="text" class="form-control" id="total_income0" name="total_income[0]" placeholder="Fill the baseline after creating farmers profile." disabled>
                            <div class="invalid-feedback">Please enter total income</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_cost0" class="form-label">Total Cost</label>
                            <input type="text" class="form-control" id="total_cost0" name="total_cost[0]" placeholder="Fill the baseline after creating farmers profile." disabled>
                            <div class="invalid-feedback">Please enter total cost</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="other_crops0" class="form-label">Other Crops</label>
                            <input type="text" class="form-control" id="other_crops0" name="other_crops[0]" placeholder="Enter Other Crops" value="{{ old('other_crops[0]', $participant->farming_data[0]->other_crops ?? '') }}">
                            <div class="invalid-feedback">Please enter other crops</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <hr>

    <!-- Record 2 -->
    <div class="mt-3">
        <div class="card profile-project-card shadow-none profile-project-success">
            <div class="card-body p-4">
                <div class="d-flex">
                    <div class="flex-grow-1 text-muted overflow-hidden">
                        <div class="badge bg-success-subtle text-success fs-12">Dry Season</div>
                        <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                            September 16 - March 15
                        </span></p>
                    </div>
                    <input class="form-check-input" type="radio" name="season[1]" id="seasonDry1" value="Dry Season" {{ old('season[1]', $participant->farming_data[1]->season ?? '') == 'Dry Season' ? 'checked' : '' }} hidden>
                    <input class="form-check-input" type="radio" name="season[1]" id="seasonWet1" value="Wet Season" {{ old('season[1]', $participant->farming_data[1]->season ?? '') == 'Wet Season' ? 'checked' : '' }} hidden>
                    <div class="col-sm-3">
                        <label for="year_training_conducted1" class="form-label">Year Conducted</label>
                        <select class="form-control mb-3 select2"
                                id="year_training_conducted1"
                                name="year_training_conducted[1]"
                                data-selected="{{ old('year_training_conducted[1]', $participant->farming_data[1]->year_training_conducted ?? '') }}">
                            <option disabled hidden selected>-- SELECT YEAR --</option>
                        </select>
                        <div class="invalid-feedback">Please select year</div>
                    </div>
                </div>
                <div class="mt-3">
                    <div class="row g-3">
                        <div class="col-sm-3">
                            <label for="farm_size_hectares1" class="form-label">Farm Size</label>
                            <input type="text" class="form-control" id="farm_size_hectares1" name="farm_size_hectares[1]" placeholder="Enter Farm Size" value="{{ old('farm_size_hectares[1]', $participant->farming_data[1]->farm_size_hectares ?? '') }}">
                            <div class="invalid-feedback">Please enter farm size</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="total_yield_caban1" class="form-label">Total yield caban (sacks)</label>
                            <input type="text" class="form-control" id="total_yield_caban1" name="total_yield_caban[1]" placeholder="Enter Total Yield Caban (Sacks)" value="{{ old('total_yield_caban[1]', $participant->farming_data[1]->total_yield_caban ?? '') }}">
                            <div class="invalid-feedback">Please enter total yield caban (sacks)</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="weight_per_caban_kg1" class="form-label">Weight per caban (kg)</label>
                            <input type="text" class="form-control" id="weight_per_caban_kg1" name="weight_per_caban_kg[1]" placeholder="Enter Weight per caban (kg)" value="{{ old('weight_per_caban_kg[1]', $participant->farming_data[1]->weight_per_caban_kg ?? '') }}">
                            <div class="invalid-feedback">Please enter weight per caban (kg)</div>
                        </div>
                        <div class="col-sm-3">
                            <label for="price_per_kg1" class="form-label">Price per kilogram</label>
                            <input type="text" class="form-control" id="price_per_kg1" name="price_per_kg[1]" placeholder="Enter Price per kilogram" value="{{ old('price_per_kg[1]', $participant->farming_data[1]->price_per_kg ?? '') }}">
                            <div class="invalid-feedback">Please enter price per kilogram</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_income1" class="form-label">Total income</label>
                            <input type="text" class="form-control" id="total_income1" name="total_income[1]" placeholder="Fill the baseline after creating farmers profile." disabled>
                            <div class="invalid-feedback">Please enter total income</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_cost1" class="form-label">Total Cost</label>
                            <input type="text" class="form-control" id="total_cost1" name="total_cost[1]" placeholder="Fill the baseline after creating farmers profile" disabled>
                            <div class="invalid-feedback">Please enter total cost</div>
                        </div>
                        <div class="col-sm-4">
                            <label for="other_crops1" class="form-label">Other Crops</label>
                            <input type="text" class="form-control" id="other_crops1" name="other_crops[1]" placeholder="Enter Other Crops" value="{{ old('other_crops[1]', $participant->farming_data[1]->other_crops ?? '') }}">
                            <div class="invalid-feedback">Please enter other crops</div>
                        </div>
                    </div>
                </div>
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
