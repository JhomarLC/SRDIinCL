<script>


$(function () {
    $('#submit-form-btn').on('click', function () {
        const payload = collectFarmingFormData();
        console.log("🧾 Final Collected Payload:", payload);

        $.ajax({
            url: "{{ route('baseline-monitoring.store', ['id' => $participant->id, 'season' => $season]) }}",
            type: 'POST',
            data: JSON.stringify(payload),
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log("✅ Saved successfully:", response);
                alert("Data saved successfully!");
            },
            error: function(xhr) {
                console.error("❌ Error saving data:", xhr.responseJSON || xhr);
                alert("An error occurred while saving.");
            }
        });
    });

    function collectFarmingFormData() {
        const payload = {};

        // 🔹 Season Info
        payload.baseline = {
            year: $('select[name="year_range"]').val(),
            farm_size_hectares: $('#farmSize').val(),
            method_crop_establishment: $('input[name="method_crop_establishment"]:checked').val(),
            number_of_bags: $('#number_of_bags').val(),
            avg_weight_per_bag: $('#avg_weight_per_bag').val(),
            price_per_kg_fresh: $('#price_per_kg_fresh').val(),
            price_per_kg_dry: $('#price_per_kg_dry').val(),
            drying_cost_per_bag: $('#drying_cost_per_bag').val()
        };

        // 🔹 Land Preparation
        payload.land_preparation = {
            category: "Land Preparation",
            is_pakyaw: $('#land-prep-pakyaw').is(':checked'),
            total_cost: $('#package_cost').val(),
            details: []
        };

        $('#land-prep-regular-fields .block').each(function () {
            const activity = $(this).find('input[name$="[activity]"]').val();
            const qty = parseFloat($(this).find('input.quantity').val());
            const unit_cost = parseFloat($(this).find('input.unit-cost').val());
            if (!isNaN(qty) && !isNaN(unit_cost)) {
                payload.land_preparation.details.push({
                    activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                });
            }
        });

        // 🔹 Seeds Preparation
        payload.seeds_preparation = {
            category: "Seeds Preparation",
            is_pakyaw: $('#seeds-prep-pakyaw').is(':checked'),
            total_cost: $('#seedsPrepPakyawTotalCost').val(),
            details: []
        };

        $('#seeds-prep-regular-fields .block').each(function () {
            const activity = $(this).find('input[name$="[activity]"]').val();
            const qty = parseFloat($(this).find('input.quantity').val());
            const unit_cost = parseFloat($(this).find('input.unit-cost').val());
            if (!isNaN(qty) && !isNaN(unit_cost)) {
                payload.seeds_preparation.details.push({
                    activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                });
            }
        });

        // 🔹 Seedbed Preparation
        payload.seedbed_preparation = {
            category: "Seedbed Preparation",
            is_pakyaw: $('#seedbed-prep-pakyaw').is(':checked'),
            total_cost: $('#seedbedPrepPakyawTotalCost').val(),
            details: []
        };

        $('#seedbed-prep-regular-fields .block').each(function () {
            const activity = $(this).find('label.form-label').text().trim();
            const qty = parseFloat($(this).find('input.quantity').val());
            const unit_cost = parseFloat($(this).find('input.unit-cost').val());
            if (!isNaN(qty) && !isNaN(unit_cost)) {
                payload.seedbed_preparation.details.push({
                    activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                });
            }
        });

        // 🔹 Crop Establishment
        const methodEst = $('input[name="soaking-type"]:checked').val();
        const isPakyaw = $('#crop-establishment-pakyaw').is(':checked');
        const pakyawTotalCost = $('#landPrepPakyawTotalCost').val();

        payload.crop_establishment = {
            category: "Crop Establishment",
            method: methodEst,
            is_pakyaw: isPakyaw,
            total_cost: pakyawTotalCost,
            details: []
        };

        if (!isPakyaw) {
            $('#crop-establishment-regular-fields .block').each(function () {
                const activity = $(this).find('label.form-label').first().text().trim();
                const qty = parseFloat($(this).find('input.quantity').val());
                const unit_cost = parseFloat($(this).find('input.unit-cost').val());
                if (!isNaN(qty) && !isNaN(unit_cost)) {
                    payload.crop_establishment.details.push({
                        activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                    });
                }
            });
        }

        // 🔹 Fertilizer Applications (NEW!)
        payload.fertilizer_applications = [];

        $('#fertilizer-applications-wrapper .fertilizer-application-block').each(function (i) {
            const application = {
                round_number: i + 1,
                details: []
            };

            $(this).find('.block').each(function () {
                const activity = $(this).find('label.form-label').first().text().trim();
                const qty = parseFloat($(this).find('input.quantity').val());
                const unit_cost = parseFloat($(this).find('input.unit-cost').val());

                if (!isNaN(qty) && !isNaN(unit_cost)) {
                    application.details.push({
                        activity,
                        qty,
                        unit_cost,
                        total_cost: (qty * unit_cost).toFixed(2)
                    });
                }
            });

            if (application.details.length > 0) {
                payload.fertilizer_applications.push(application);
            }
        });

        // 🔹 Water Management
        const isWaterPakyaw = $('#water-management-pakyaw').is(':checked');
        const wmTotalCost = $('#water-management-pakyaw-total-cost input').val();

        payload.water_management = {
            category: "Water Management",
            is_pakyaw: isWaterPakyaw,
            total_cost: wmTotalCost,
            events: []
        };

        $('#irrigation-blocks-container .irrigation-block').each(function (i) {
            const round_number = i + 1;
            const type = $(this).find('input[type="radio"]:checked').val() === 'is_nia_both' ? 'NIA' : 'Supplementary';
            const event = {
                round_number,
                irrigation_type: type,
                is_pakyaw: false,
                total_cost: 0,
                details: []
            };

            $(this).find('.supplementary-irrigation-details .block').each(function () {
                const activity = $(this).find('label.form-label').first().text().trim();
                const qty = parseFloat($(this).find('input.quantity').val());
                const unit_cost = parseFloat($(this).find('input.unit-cost').val());
                if (!isNaN(qty) && !isNaN(unit_cost)) {
                    event.details.push({
                        activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                    });
                }
            });

            payload.water_management.events.push(event);
        });

        // 🔹 Pest Management
        payload.pest_management = {
            category: "Pest Management",
            is_pakyaw: false,
            details: []
        };

        $('#pesticide-applications-wrapper .pesticide-application-block').each(function (i) {
            const round_number = i + 1;

            $(this).find('.block').each(function () {
                const activity = $(this).find('label.form-label').first().text().trim();
                const qty = parseFloat($(this).find('input.quantity').val());
                const unit_cost = parseFloat($(this).find('input.unit-cost').val());
                if (!isNaN(qty) && !isNaN(unit_cost)) {
                    payload.pest_management.details.push({
                        round_number,
                        activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                    });
                }
            });
        });

        // 🔹 Harvest Management
        const harvestMethod = $('input[name="harvesting-type"]:checked').val();
        const isManualPakyaw = $('#manual-package-checkbox').is(':checked');
        const manualTotalCost = $('#manualPackageTotalCost').val();

        payload.harvest = {
            category: "Harvest",
            method: harvestMethod,
            is_pakyaw: isManualPakyaw,
            total_cost: manualTotalCost,
            details: []
        };

        if (harvestMethod === "Mechanical") {
            const bags = parseFloat($('#mechanical-block .bags').val());
            const avg_weight = parseFloat($('#mechanical-block .avg-bag-weight').val());
            const price_kg = parseFloat($('#mechanical-block .price-per-kg').val());
            if (!isNaN(bags) && !isNaN(avg_weight) && !isNaN(price_kg)) {
                payload.harvest.details.push({
                    activity: "Mechanical Harvesting",
                    qty: bags,
                    unit_cost: (avg_weight * price_kg).toFixed(2),
                    total_cost: (bags * avg_weight * price_kg).toFixed(2)
                });
            }
        } else {
            $('#manual-fields .block').each(function () {
                const activity = $(this).find('label.form-label').first().text().trim();
                const qty = parseFloat($(this).find('input.quantity').val());
                const unit_cost = parseFloat($(this).find('input.unit-cost').val());
                if (!isNaN(qty) && !isNaN(unit_cost)) {
                    payload.harvest.details.push({
                        activity, qty, unit_cost, total_cost: (qty * unit_cost).toFixed(2)
                    });
                }
            });
        }

        return payload;
    }

});

</script>
