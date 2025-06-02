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
        // Assign value based on season
        $mc_value = 0;
        if ($season === 'dry-season') {
            $mc_value = 18;
        } elseif ($season === 'wet-season') {
            $mc_value = 20;
        }
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
                <label for="total_yield_caban" class="form-label">Number of Bags</label>
                <input type="text" class="form-control" id="total_yield_caban" name="total_yield_caban" value="{{ old('total_yield_caban', $seasonData->total_yield_caban ?? '') }}"
                    placeholder="Number of Bags" required>
                <div class="invalid-feedback">Please enter number of bags</div>
            </div>
            <div class="col-sm-4">
                <label for="weight_per_caban_kg" class="form-label">Average Weight per Bag</label>
                <input type="text" class="form-control" id="weight_per_caban_kg" name="weight_per_caban_kg" value="{{ old('weight_per_caban_kg', $seasonData->weight_per_caban_kg ?? '') }}"
                    placeholder="Average Weight per Bag" required>
                <div class="invalid-feedback">Please enter average weight per bag</div>
            </div>
             <div class="col-sm-4">
                <label for="yield_tons_per_ha" class="form-label">Total Yield (kg/ha)</label>
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
            <input type="number" hidden name="mc_value" id="mc_value" value="{{ $mc_value }}">
            <div class="col-sm-4">
                <label for="adjusted_yield" class="form-label">Adjusted yield (t/ha)</label>
                <input type="text" class="form-control" id="adjusted_yield" name="adjusted_yield_display"
                    placeholder="0.00" disabled>
                <input type="hidden" name="adjusted_yield" id="adjusted_yield_hidden">
                <div class="invalid-feedback">Please enter farm size</div>
            </div>
            <div class="col-sm-4">
                <label for="gross_income" class="form-label">Gross Income (₱)</label>
                <input type="text" class="form-control" id="gross_income" name="gross_income_display" placeholder="0.00" disabled>
                <input type="hidden" name="gross_income" id="gross_income_hidden">
            </div>
            <div class="col-sm-4">
                <label for="net_income" class="form-label">Net Income (₱)</label>
                <input type="text" class="form-control" id="net_income" name="net_income_display" placeholder="0.00" disabled>
                <input type="hidden" name="net_income" id="net_income_hidden">
            </div>
        </div>
    </div>
    <div class="sticky-next-button d-flex align-items-start gap-3 mt-4">
        <button type="button"
            class="btn btn-success btn-label right ms-auto nexttab nexttab"
            data-nexttab="v-pills-land-prep"><i
                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Next</button>
    </div>
</div>
<!-- end tab pane -->
