<div class="tab-pane" id="data_riceFarming_tab" role="tabpanel">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                <h5 class="card-title mb-2 mb-md-0">Data on Rice Farming</h5>
                <div class="text-muted overflow-hidden">
                    <button class="btn btn-success">
                        <i class="ri-file-add-fill"></i>
                        Add Baseline Monitoring
                    </button>
                </div>
            </div>
            @php
                // Group Wet/Dry by year
                $seasonPairs = [];

                foreach ($participant->farming_data as $data) {
                    $key = $data->year_training_conducted;
                    if (!isset($seasonPairs[$key])) {
                        $seasonPairs[$key] = [
                            'Wet Season' => null,
                            'Dry Season' => null,
                        ];
                    }
                    $seasonPairs[$key][$data->season] = $data;
                }
            @endphp

            @foreach($seasonPairs as $year => $seasons)
                {{-- Wet Season --}}
                @if($seasons['Wet Season'])
                <div class="col-12">
                    <div class="card profile-project-card shadow-none profile-project-secondary">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 text-muted overflow-hidden">
                                    <div class="badge bg-secondary-subtle text-secondary fs-12">Wet Season</div>
                                    <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                                        March 16, {{ $seasons['Wet Season']->year_training_conducted }} - September 15, {{ $seasons['Wet Season']->year_training_conducted }}
                                    </span></p>
                                </div>
                            </div>

                            @include('farmers-profile.partials._season_fields', ['data' => $seasons['Wet Season']])
                        </div>
                    </div>
                </div>
                @endif

                {{-- Dry Season --}}
                @if($seasons['Dry Season'])
                <div class="col-12">
                    <div class="card profile-project-card shadow-none profile-project-primary">
                        <div class="card-body p-4">
                            <div class="d-flex">
                                <div class="flex-grow-1 text-muted overflow-hidden">
                                    <div class="badge bg-primary-subtle text-primary fs-12">Dry Season</div>
                                    <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                                        September 16, {{ (int) explode('-', $seasons['Dry Season']->year_training_conducted)[0] ?? ((int) $seasons['Dry']->year_training_conducted + 1) }} - March 15, {{ (int) explode('-', $seasons['Dry Season']->year_training_conducted)[1] ?? ((int) $seasons['Dry']->year_training_conducted + 1) }}
                                    </span></p>
                                </div>
                            </div>

                            @include('farmers-profile.partials._season_fields', ['data' => $seasons['Dry Season']])
                        </div>
                    </div>
                </div>
                @endif

                <hr>
            @endforeach

{{--
            <div class="col-12">
                <div class="card profile-project-card shadow-none profile-project-secondary">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-grow-1 text-muted overflow-hidden">
                                <div class="badge bg-secondary-subtle text-secondary fs-12">Wet Season</div>
                                <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                                        March 16 - September 15 2024</span>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Farm Size :</p>
                                        <input type="text" class="form-control" value="1 hectare" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Yield Caban (sacks) :</p>
                                        <input type="text" class="form-control" value="12" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Weight per Caban (kg) :</p>
                                        <input type="text" class="form-control" value="12" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Price per kilogram :</p>
                                        <input type="text" class="form-control" value="50" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Income :</p>
                                        <input type="text" class="form-control" value="12000" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Cost :</p>
                                        <input type="text" class="form-control" value="5600" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Other Crops :</p>
                                        <input type="text" class="form-control" value="5600" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col-->
            <div class="col-12">
                <div class="card profile-project-card shadow-none profile-project-primary">
                    <div class="card-body p-4">
                        <div class="d-flex">
                            <div class="flex-grow-1 text-muted overflow-hidden">
                                <div class="badge bg-primary-subtle text-primary fs-12">Dry Season</div>
                                <p class="text-muted mb-0 mt-2">Date : <span class="fw-semibold text-body">
                                        September 16 - March 15 2025</span>
                                </p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Farm Size :</p>
                                        <input type="text" class="form-control" value="1 hectare" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Yield Caban (sacks) :</p>
                                        <input type="text" class="form-control" value="12" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Weight per Caban (kg) :</p>
                                        <input type="text" class="form-control" value="12" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->

                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Price per kilogram :</p>
                                        <input type="text" class="form-control" value="50" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Income :</p>
                                        <input type="text" class="form-control" value="12000" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Total Cost :</p>
                                        <input type="text" class="form-control" value="5600" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex mt-4">
                                    <div class="flex-grow-1 overflow-hidden">
                                        <p class="mb-1 fw-bold">Other Crops :</p>
                                        <input type="text" class="form-control" value="5600" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!--end col--> --}}
            {{-- <hr> --}}
        </div>
        <!-- end card body -->
    </div>
    <!-- end card-->
</div>
<!--end tab-pane-->
