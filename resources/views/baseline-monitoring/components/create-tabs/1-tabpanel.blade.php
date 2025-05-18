<div class="tab-pane fade show active" id="v-pills-dry-season-info" role="tabpanel"
    aria-labelledby="v-pills-dry-season-info-tab">
    <div>
        <h5>
            {{ ucwords(str_replace('-', ' ', $season)) }} Baseline Monitoring
        </h5>
        <p class="text-muted">Fill all information below</p>
    </div>
    @php
        // Normalize season value from 'dry-season' to 'Dry Season'
        $normalizedSeason = ucwords(str_replace('-', ' ', $season));
        $seasonData = $filteredFarmingData->first();
    @endphp
    <div class="mt-3">
        <div class="row g-3">
            <div class="col-sm-6">
                <label for="yearTrainingConducted" class="form-label">Year Conducted</label>
               <select class="form-control mb-3 select2" aria-label="Default select example" name="year_range">
                    <option disabled hidden>-- SELECT YEAR --</option>
                    @foreach($yearOptions as $value => $label)
                        <option value="{{ $value }}"
                            @if(old('year_range', $seasonData->year_training_conducted ?? '') == $value) selected @endif>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6">
                <label for="farmSize" class="form-label">Total Rice Area (ha)</label>
                <input type="text" class="form-control" id="farmSize"
                    value="{{ old('farm_size_hectares', $seasonData->farm_size_hectares ?? '') }}"
                    placeholder="Enter Farm Size" required>
                <div class="invalid-feedback">Please enter farm size</div>
            </div>
        </div>
    </div>

    <div>
        <div class="row mt-2 g-3">
            <div class="col-sm-12">
                <label for="farmSeason" class="form-label">Method of Crop Establishment: </label>
                <div class="form-check form-check-inline mt-2">
                    <input class="form-check-input" type="radio" name="method_crop_establishment" id="dwsr" value="DWSR">
                    <label class="form-check-label" for="dwsr">DWSR</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="method_crop_establishment" id="tpr" value="TPR" checked>
                    <label class="form-check-label" for="tpr">TPR</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-3">
        <div class="row g-3">

            <div class="col-sm-4">
                <label for="number_of_bags" class="form-label">Number of Bags</label>
                <input type="text" class="form-control" id="number_of_bags" name="number_of_bags" value="50"
                    placeholder="Number of Bags" required>
                <div class="invalid-feedback">Please enter number of bags</div>
            </div>
            <div class="col-sm-4">
                <label for="avg_weight_per_bag" class="form-label">Average Weight per Bag</label>
                <input type="text" class="form-control" id="avg_weight_per_bag" name="avg_weight_per_bag" value="45"
                    placeholder="Average Weight per Bag" required>
                <div class="invalid-feedback">Please enter average weight per bag</div>
            </div>
            <div class="col-sm-4">
                <label for="yield_tons_per_ha" class="form-label">Total Yield (tons/ha)</label>
                <input type="text" class="form-control" id="yield_tons_per_ha" name="yield_tons_per_ha" value="2.5"
                    placeholder="0.00" required disabled>
                <div class="invalid-feedback">Please enter farm size</div>
            </div>
            <div class="col-sm-4">
                <label for="price_per_kg_fresh" class="form-label">Fresh Price per kg</label>
                <input type="text" class="form-control" id="price_per_kg_fresh" name="price_per_kg_fresh" value="25"
                    placeholder="Fresh price per kg" required>
                <div class="invalid-feedback">Please enter fresh price per kg</div>
            </div>
            <div class="col-sm-4">
                <label for="price_per_kg_dry" class="form-label">Dry Price per kg</label>
                <input type="text" class="form-control" id="price_per_kg_dry" name="price_per_kg_dry" value="20"
                    placeholder="Dry price per kg" required>
                <div class="invalid-feedback">Please enter dry price per kg</div>
            </div>
            <div class="col-sm-4">
                <label for="drying_cost_per_bag" class="form-label">Price of Drying per Bag</label>
                <input type="text" class="form-control" id="drying_cost_per_bag" name="drying_cost_per_bag" value="10"
                    placeholder="Price of Drying per Bag" required>
                <div class="invalid-feedback">Please enter price of dying per bag</div>
            </div>
        </div>
    </div>
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button"
            class="btn btn-success btn-label right ms-auto nexttab nexttab"
            data-nexttab="v-pills-land-prep"><i
                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
    </div>
</div>
<!-- end tab pane -->
