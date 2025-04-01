<div class="row">
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Farm Size :</p>
        <input type="text" class="form-control" value="{{ $data->farm_size_hectares }} hectare(s)" disabled>
    </div>
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Total Yield Caban (sacks) :</p>
        <input type="text" class="form-control" value="{{ $data->total_yield_caban }}" disabled>
    </div>
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Weight per Caban (kg) :</p>
        <input type="text" class="form-control" value="{{ $data->weight_per_caban_kg }}" disabled>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Price per kilogram :</p>
        <input type="text" class="form-control" value="{{ $data->price_per_kg }}" disabled>
    </div>
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Total Income :</p>
        <input type="text" class="form-control" value="{{ $data->total_income }}" disabled>
    </div>
    <div class="col-12 col-md-4 mt-4">
        <p class="mb-1 fw-bold">Total Cost :</p>
        <input type="text" class="form-control" value="{{ $data->total_cost }}" disabled>
    </div>
</div>

<div class="row">
    <div class="col-12 mt-4">
        <p class="mb-1 fw-bold">Other Crops :</p>
        <input type="text" class="form-control" value="{{ $data->other_crops ?? 'N/A' }}" disabled>
    </div>
</div>
