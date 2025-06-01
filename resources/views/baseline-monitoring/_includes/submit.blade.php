<script>
$(function () {
    const submitFinalForm = () => {
        const fullFormData = new FormData();

        // Crop Establishment
        const cropMethod = $('#crop-method').val(); // DWSR or TPR

        // Land Preparation Data Only
        const isPakyaw = $("#land-prep-pakyaw").is(":checked") ? 1 : 0;
        fullFormData.append("land_prep_is_pakyaw", isPakyaw);

        if (isPakyaw) {
            const packageCost = $("#package_cost").val() || 0;
            fullFormData.append("land_prep_package_cost", packageCost);
        } else {
            $("#land-prep-regular-fields .block").each(function (index) {
                const activity = $(this).find('input[name^="land_prep["][name$="[activity]"]').val();
                const qty = $(this).find('input[name^="land_prep["][name$="[qty]"]').val() || 0;
                const unitCost = $(this).find('input[name^="land_prep["][name$="[unit_cost]"]').val() || 0;
                const totalCost = parseFloat(qty) * parseFloat(unitCost);

                fullFormData.append(`land_prep[${index}][activity]`, activity);
                fullFormData.append(`land_prep[${index}][qty]`, qty);
                fullFormData.append(`land_prep[${index}][unit_cost]`, unitCost);
                fullFormData.append(`land_prep[${index}][total_cost]`, totalCost || 0);
            });
        }

          // SEEDS PREPARATION
        const isSeedsPakyaw = $("#seeds-prep-pakyaw").is(":checked") ? 1 : 0;
        fullFormData.append("seeds_prep_is_pakyaw", isSeedsPakyaw);

        if (isSeedsPakyaw) {
            const seedsPackageCost = $("#seeds-prep-pakyaw-total-cost-input").val() || 0;
            fullFormData.append("seeds_prep_package_cost", seedsPackageCost);
        } else {
            $("#seeds-prep-regular-fields .block").each(function (index) {
                const activity = $(this).find('input[name$="[activity]"]').val();
                const qty = $(this).find('input[name$="[qty]"]').val() || 0;
                const unitCost = $(this).find('input[name$="[unit_cost]"]').val() || 0;
                const totalCost = parseFloat(qty) * parseFloat(unitCost);

                fullFormData.append(`seed_prep[${index}][activity]`, activity);
                fullFormData.append(`seed_prep[${index}][qty]`, qty);
                fullFormData.append(`seed_prep[${index}][unit_cost]`, unitCost);
                fullFormData.append(`seed_prep[${index}][total_cost]`, totalCost || 0);
            });
        }

        // SEEDS PREPARATION → VARIETIES
        fullFormData.append("seeds_prep_others", $("#others").val() || '');

        $("#variety-container .variety-block").each(function (index) {
            const varietyId = $(this).data("variety-id");
            const varietyName = $(this).data("variety-name");
            const purchaseType = $(this).find(`input[name="purchase_status_${varietyId}"]:checked`).val();

            const qty = $(this).find(".quantity").val() || 0;
            const unitCost = $(this).find(".unit-cost").val() || 0;
            const totalCost = $(this).find(".total-cost").val() || 0;

            fullFormData.append(`seed_varieties[${index}][seed_variety_id]`, varietyId.toString().startsWith("other_") ? "" : varietyId);
            fullFormData.append(`seed_varieties[${index}][variety_name]`, varietyName);
            fullFormData.append(`seed_varieties[${index}][purchase_type]`, purchaseType);
            fullFormData.append(`seed_varieties[${index}][qty]`, qty);
            fullFormData.append(`seed_varieties[${index}][unit_cost]`, unitCost);
            fullFormData.append(`seed_varieties[${index}][total_cost]`, totalCost);
        });

        if (cropMethod === 'TPR') {
            // Seedbed Preparation
            const isSeedbedPakyaw = $("#seedbed-prep-pakyaw").is(":checked") ? 1 : 0;
            fullFormData.append("seedbed_prep_is_pakyaw", isSeedbedPakyaw);

            if (isSeedbedPakyaw) {
                const seedbedPackageCost = $("#seedbed-prep-pakyaw-total-cost-input").val() || 0;
                fullFormData.append("seedbed_prep_package_cost", seedbedPackageCost);
            } else {
                $("#seedbed-prep-regular-fields .block").each(function (index) {
                    const activity = $(this).find('input[name$="[activity]"]').val();
                    const qty = $(this).find('input[name$="[qty]"]').val() || 0;
                    const unitCost = $(this).find('input[name$="[unit_cost]"]').val() || 0;
                    const totalCost = parseFloat(qty) * parseFloat(unitCost);

                    fullFormData.append(`seedbed_prep[${index}][activity]`, activity);
                    fullFormData.append(`seedbed_prep[${index}][qty]`, qty);
                    fullFormData.append(`seedbed_prep[${index}][unit_cost]`, unitCost);
                    fullFormData.append(`seedbed_prep[${index}][total_cost]`, totalCost || 0);
                });
            }

            // Seedbed Fertilization
            $("#seedbed-fertilization-regular-fields .block").each(function (index) {
                const activity = $(this).find('input[name^="seedbed_fert["][name$="[activity]"]').val();
                const qty = $(this).find('input[name^="seedbed_fert["][name$="[qty]"]').val() || 0;
                const unitCost = $(this).find('input[name^="seedbed_fert["][name$="[unit_cost]"]').val() || 0;
                const totalCost = parseFloat(qty) * parseFloat(unitCost);

                fullFormData.append(`seedbed_fertilization[${index}][activity]`, activity);
                fullFormData.append(`seedbed_fertilization[${index}][qty]`, qty);
                fullFormData.append(`seedbed_fertilization[${index}][unit_cost]`, unitCost);
                fullFormData.append(`seedbed_fertilization[${index}][total_cost]`, totalCost || 0);
            });

            // Optional 'Others' input
            const othersFertilizer = $("#others-fertilizer").val()?.trim();
            if (othersFertilizer) {
                fullFormData.append("seedbed_fertilization_others", othersFertilizer);
            }
        }
        // Dynamic Fertilizer List (container)
        $("#fertilizer-container .fertilizer-block").each(function (index) {
            const fertilizerName = $(this).data("fertilizer-name");
            const purchaseType = $(this).find(`input[name^="fertilizer_type_"]:checked`).val() || '';

            const qty = $(this).find(".quantity").val() || 0;
            const unitCost = $(this).find(".unit-cost").val() || 0;
            const totalCost = $(this).find(".total-cost").val() || 0;

            fullFormData.append(`seedbed_fertilizer[${index}][fertilizer_name]`, fertilizerName);
            fullFormData.append(`seedbed_fertilizer[${index}][purchase_type]`, purchaseType);
            fullFormData.append(`seedbed_fertilizer[${index}][qty]`, qty);
            fullFormData.append(`seedbed_fertilizer[${index}][unit_cost]`, unitCost);
            fullFormData.append(`seedbed_fertilizer[${index}][total_cost]`, totalCost);
        });


        // Get establishment type based on method
        const cropEstablishmentType = cropMethod === 'DWSR'
            ? $('#dwsr-section select[name="establishment_type"]').val() || ''
            : $('input[name="establishment_type"]:checked').val() || '';

        const isCropPakyaw = $('#crop-establishment-pakyaw').is(':checked') ? 1 : 0;

        fullFormData.append('crop_est_method', cropMethod);
        fullFormData.append('crop_est_establishment_type', cropEstablishmentType);
        fullFormData.append('crop_est_is_pakyaw', isCropPakyaw);

        if (isCropPakyaw) {
            const totalPackageCost = $('#crop-establishment-pakyaw-total-cost-input').val() || 0;
            fullFormData.append('crop_est_package_total_cost', totalPackageCost);
        } else {
            let partIndex = 0;

            if (cropMethod === 'DWSR') {
                const $block = $('#dwsr-section');
                const activity = $block.find('input[name="crop_est_particulars[0][activity]"]').val()?.trim();
                const qty = $block.find('input[name="crop_est_particulars[0][qty]"]').val() || 0;
                const unitCost = $block.find('input[name="crop_est_particulars[0][unit_cost]"]').val() || 0;
                const totalCost = parseFloat(qty) * parseFloat(unitCost);

                // ✅ Only append if activity is not blank
                if (activity) {
                    fullFormData.append(`crop_est_particulars[${partIndex}][activity]`, activity);
                    fullFormData.append(`crop_est_particulars[${partIndex}][qty]`, qty);
                    fullFormData.append(`crop_est_particulars[${partIndex}][unit_cost]`, unitCost);
                    fullFormData.append(`crop_est_particulars[${partIndex}][total_cost]`, totalCost || 0);
                }
            }

            if (cropMethod === 'TPR') {
                $('#tpr-section .block').each(function () {
                    const $block = $(this);
                    const isManualOnly = $block.is('[data-tpr-block="manual-only"]');
                    if (cropEstablishmentType === 'Mechanical' && isManualOnly) return;

                    const activity = $block.find('input[name$="[activity]"]').val()?.trim();
                    const qty = $block.find('input[name$="[qty]"]').val() || 0;
                    const unitCost = $block.find('input[name$="[unit_cost]"]').val() || 0;
                    const totalCost = parseFloat(qty) * parseFloat(unitCost);

                    if (!activity) return; // ⛔ skip empty rows

                    fullFormData.append(`crop_est_particulars[${partIndex}][activity]`, activity);
                    fullFormData.append(`crop_est_particulars[${partIndex}][qty]`, qty);
                    fullFormData.append(`crop_est_particulars[${partIndex}][unit_cost]`, unitCost);
                    fullFormData.append(`crop_est_particulars[${partIndex}][total_cost]`, totalCost || 0);

                    partIndex++;
                });
            }
        }

        // FERTILIZER MANAGEMENT
        $('#fertilizer-applications-wrapper .fertilizer-application-block').each(function (appIndex) {
            const $block = $(this);
             // --- Application Label ---
            const appLabel = $block.find('.application-label').text().trim();
            fullFormData.append(`fertilizer_management[${appIndex}][label]`, appLabel);

            // --- Selected Fertilizers (Multi-select) ---
            const fertilizers = $block.find('select[name="fertilizer-application[]"]').val() || [];
            fertilizers.forEach((val, idx) => {
                fullFormData.append(`fertilizer_management[${appIndex}][fertilizers][${idx}]`, val);
            });

            // --- 'Others' input ---
            const others = $block.find('input[name="others-fertilizer-application"]').val()?.trim();
            if (others) {
                fullFormData.append(`fertilizer_management[${appIndex}][others]`, others);
            }

            // --- Per-Fertilizer Inputs ---
            $block.find('.fertilizer-block').each(function (itemIndex) {
                const $fert = $(this);
                const fertName = $fert.data("fertilizer-name") || '';
                const purchaseType = $fert.find('input[type="radio"]:checked').val() || '';
                const qty = parseFloat($fert.find(".quantity").val()) || 0;
                const unitCost = parseFloat($fert.find(".unit-cost").val()) || 0;
                const totalCost = parseFloat($fert.find(".total-cost").val()) || 0;

                fullFormData.append(`fertilizer_management[${appIndex}][items][${itemIndex}][fertilizer_name]`, fertName);
                fullFormData.append(`fertilizer_management[${appIndex}][items][${itemIndex}][purchase_type]`, purchaseType);
                fullFormData.append(`fertilizer_management[${appIndex}][items][${itemIndex}][qty]`, qty);
                fullFormData.append(`fertilizer_management[${appIndex}][items][${itemIndex}][unit_cost]`, unitCost);
                fullFormData.append(`fertilizer_management[${appIndex}][items][${itemIndex}][total_cost]`, totalCost);
            });

            // --- Labor: Fertilizer Application ---
            const $fertilizerLaborBlock = $block.find('input[name$="[activity]"][value="Labor: Fertilizer application"]').closest('.block');
            const fertQty = parseFloat($fertilizerLaborBlock.find('.quantity').val()) || 0;
            const fertUnitCost = parseFloat($fertilizerLaborBlock.find('.unit-cost').val()) || 0;
            const fertTotal = fertQty * fertUnitCost;

            fullFormData.append(`fertilizer_management[${appIndex}][fert_application][activity]`, "Labor: Fertilizer application");
            fullFormData.append(`fertilizer_management[${appIndex}][fert_application][qty]`, fertQty);
            fullFormData.append(`fertilizer_management[${appIndex}][fert_application][unit_cost]`, fertUnitCost);
            fullFormData.append(`fertilizer_management[${appIndex}][fert_application][total_cost]`, fertTotal || 0);

            // --- Labor: Meals and Snacks ---
            const $mealsBlock = $block.find('input[name$="[activity]"][value="Meals and Snacks"]').closest('.block');
            const mealsQty = parseFloat($mealsBlock.find('.quantity').val()) || 0;
            const mealsUnitCost = parseFloat($mealsBlock.find('.unit-cost').val()) || 0;
            const mealsTotal = mealsQty * mealsUnitCost;

            fullFormData.append(`fertilizer_management[${appIndex}][meals][activity]`, "Meals and Snacks");
            fullFormData.append(`fertilizer_management[${appIndex}][meals][qty]`, mealsQty);
            fullFormData.append(`fertilizer_management[${appIndex}][meals][unit_cost]`, mealsUnitCost);
            fullFormData.append(`fertilizer_management[${appIndex}][meals][total_cost]`, mealsTotal || 0);
        });

        // WATER MANAGEMENT
        const wmType = $('input[name="water-management-type"]:checked').val(); // 'nia' or 'supplementary'
        const isWmPakyaw = $('#water-management-pakyaw').is(':checked');
        const wmIsPackage = wmType === 'supplementary' ? (isWmPakyaw ? 1 : 0) : 0;

        fullFormData.append('water_management_type', wmType);
        fullFormData.append('water_management_is_package', wmIsPackage);

        if (wmType === 'nia') {
            const total = parseFloat($('#nia-total-cost-input').val()) || 0;
            fullFormData.append('water_management_nia_total', total);
        } else {
            if (wmIsPackage) {
                const total = parseFloat($('#water-management-pakyaw-total-cost input').val()) || 0;
                fullFormData.append('water_management_package_total_cost', total);
            } else {
                $('#irrigation-blocks-container .irrigation-block').each(function (index) {
                    const $block = $(this);
                    const label = $block.find('.irrigation-title').text().trim();
                    const method = $block.find('input[type="radio"]:checked').val() === 'is_nia_both' ? 'nia' : 'supplementary';
                    const irrigationPrefix = `water_irrigations[${index}]`;

                    fullFormData.append(`${irrigationPrefix}[label]`, label);
                    fullFormData.append(`${irrigationPrefix}[method]`, method);

                    if (method === 'nia') {
                        const niaTotal = parseFloat($block.find('.nia-per-irrigation-cost').val()) || 0;
                        fullFormData.append(`${irrigationPrefix}[nia_total]`, niaTotal);
                    } else {
                        $block.find('.supplementary-irrigation-details .block').each(function (detailIndex) {
                            const $detail = $(this);
                            const activity = $detail.find('input[name$="[activity]"]').val()?.trim();
                            const qty = parseInt($detail.find('.quantity').val()) || 0;
                            const unitCost = parseFloat($detail.find('.unit-cost').val()) || 0;
                            const totalCost = parseFloat(qty * unitCost) || 0;

                            const detailPrefix = `${irrigationPrefix}[details][${detailIndex}]`;

                            fullFormData.append(`${detailPrefix}[activity]`, activity);
                            fullFormData.append(`${detailPrefix}[qty]`, qty);
                            fullFormData.append(`${detailPrefix}[unit_cost]`, unitCost);
                            fullFormData.append(`${detailPrefix}[total_cost]`, totalCost);
                        });
                    }
                });
            }
        }

        $('#pesticide-applications-wrapper .pesticide-application-block').each(function (appIndex) {
            const $block = $(this);

            // Skip block if it's totally empty (no pesticide selected and no labor entered)
            const hasPesticide = ($block.find(`select[name^="pesticide_application["]`).val() || []).length > 0;
            const hasLaborQty = $block.find('.quantity').filter(function () {
                return parseFloat($(this).val()) > 0;
            }).length > 0;

            if (!hasPesticide && !hasLaborQty) {
                return; // skip this block
            }

            // Proceed to append this pesticide application
            const appLabel = $block.find('.application-label').text().trim();
            fullFormData.append(`pesticide_management[${appIndex}][label]`, appLabel);

            const pesticides = $block.find(`select[name^="pesticide_application["]`).val() || [];
            pesticides.forEach((val, idx) => {
                fullFormData.append(`pesticide_management[${appIndex}][pesticides][${idx}]`, val);
            });

            const others = $block.find(`input[name^="others-pesticide-application["]`).val()?.trim();
            if (others) {
                fullFormData.append(`pesticide_management[${appIndex}][others]`, others);
            }

            $block.find('.brand-name').each(function () {
                const nameAttr = $(this).attr("name");
                const brandName = $(this).val()?.trim();
                if (nameAttr && brandName) {
                    fullFormData.append(nameAttr, brandName);
                }
            });

            // --- Labor: Chemical Application ---
            const $chemicalBlock = $block.find('input[name$="[activity]"][value="Labor: Chemical Application"]').closest('.block');
            const chemQty = parseFloat($chemicalBlock.find('.quantity').val()) || 0;
            const chemUnitCost = parseFloat($chemicalBlock.find('.unit-cost').val()) || 0;
            const chemTotal = chemQty * chemUnitCost;

            fullFormData.append(`pesticide_management[${appIndex}][chemical][activity]`, "Labor: Chemical Application");
            fullFormData.append(`pesticide_management[${appIndex}][chemical][qty]`, chemQty);
            fullFormData.append(`pesticide_management[${appIndex}][chemical][unit_cost]`, chemUnitCost);
            fullFormData.append(`pesticide_management[${appIndex}][chemical][total_cost]`, chemTotal || 0);

            // --- Labor: Manual Weeding ---
            const $weedingBlock = $block.find('input[name$="[activity]"][value="Labor: Manual Weeding"]').closest('.block');
            const weedQty = parseFloat($weedingBlock.find('.quantity').val()) || 0;
            const weedUnitCost = parseFloat($weedingBlock.find('.unit-cost').val()) || 0;
            const weedTotal = weedQty * weedUnitCost;

            fullFormData.append(`pesticide_management[${appIndex}][weeding][activity]`, "Labor: Manual Weeding");
            fullFormData.append(`pesticide_management[${appIndex}][weeding][qty]`, weedQty);
            fullFormData.append(`pesticide_management[${appIndex}][weeding][unit_cost]`, weedUnitCost);
            fullFormData.append(`pesticide_management[${appIndex}][weeding][total_cost]`, weedTotal || 0);

            // --- Labor: Meals and Snacks ---
            const $mealsBlock = $block.find('input[name$="[activity]"][value="Meals and Snacks"]').closest('.block');
            const mealsQty = parseFloat($mealsBlock.find('.quantity').val()) || 0;
            const mealsUnitCost = parseFloat($mealsBlock.find('.unit-cost').val()) || 0;
            const mealsTotal = mealsQty * mealsUnitCost;

            fullFormData.append(`pesticide_management[${appIndex}][meals][activity]`, "Meals and Snacks");
            fullFormData.append(`pesticide_management[${appIndex}][meals][qty]`, mealsQty);
            fullFormData.append(`pesticide_management[${appIndex}][meals][unit_cost]`, mealsUnitCost);
            fullFormData.append(`pesticide_management[${appIndex}][meals][total_cost]`, mealsTotal || 0);
        });

        // 🔍 Log the contents of the FormData
        console.group("📦 Submitted Form Data");
        for (let [key, value] of fullFormData.entries()) {
            console.log(`${key}:`, value);
        }
        console.groupEnd();
        @php
            $farmingData = $participant->farming_data->where('season', $normalizedSeason)->first();
        @endphp
        // // Submit
        $.ajax({
            url: "{{ route('baseline-monitoring.store', [$farmingData->id, $farmingData->season]) }}",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: fullFormData,
            processData: false,
            contentType: false,
            success: function (response) {
                showAlertModal("success", response.message);
                setTimeout(() => window.location.href = "/baseline-monitoring/" + {{ $participant->id }}, 1500);
            },
            error: function (xhr) {
                hideLoader();
                console.error("❌ Submission Error", xhr);
                showAlertModal("error", "Something went wrong during submission.");
            },
            complete: function () {
                hideLoader();
            }
        });
    };

    $("#submitBaseline").on("click", function (e) {
        e.preventDefault();
        showLoader("Validating...");

        const steps = [
            "land-preparation",
            "seeds-prep",
            "seedbed-prep",
            "seedbed-fertilization",
            "crop-establishment",
            "fertilizer-management",
            "water-management",
            "pest-management"
        ];

        const formData1 = new FormData();

        const stepForms = {
            "land-preparation": () => {
                const isPakyaw = $("#land-prep-pakyaw").is(":checked") ? 1 : 0;
                formData1.append("land_prep_is_pakyaw", isPakyaw);

                if (isPakyaw) {
                    const packageCost = $("#package_cost").val() || 0;
                    formData1.append("land_prep_package_cost", packageCost);
                } else {
                    $("#land-prep-regular-fields .block").each(function (index) {
                        const activity = $(this).find('input[name^="land_prep["][name$="[activity]"]').val();
                        const qty = $(this).find('input[name^="land_prep["][name$="[qty]"]').val() || 0;
                        const unitCost = $(this).find('input[name^="land_prep["][name$="[unit_cost]"]').val() || 0;
                        const totalCost = parseFloat(qty) * parseFloat(unitCost);

                        formData1.append(`land_prep[${index}][activity]`, activity);
                        formData1.append(`land_prep[${index}][qty]`, qty);
                        formData1.append(`land_prep[${index}][unit_cost]`, unitCost);
                        formData1.append(`land_prep[${index}][total_cost]`, totalCost || 0);
                    });
                }
            },
            "seeds-prep": () => {
                const isPakyaw = $("#seeds-prep-pakyaw").is(":checked") ? 1 : 0;
                formData1.append("seeds_prep_is_pakyaw", isPakyaw);

                if (isPakyaw) {
                    const packageCost = $("#seeds-prep-pakyaw-total-cost-input").val() || 0;
                    formData1.append("seeds_prep_package_cost", packageCost);
                } else {
                    $("#seeds-prep-regular-fields .block").each(function (index) {
                        const activity = $(this).find('input[name^="seed_prep["][name$="[activity]"]').val();
                        const qty = $(this).find('input[name^="seed_prep["][name$="[qty]"]').val() || 0;
                        const unitCost = $(this).find('input[name^="seed_prep["][name$="[unit_cost]"]').val() || 0;
                        const totalCost = parseFloat(qty) * parseFloat(unitCost);

                        formData1.append(`seed_prep[${index}][activity]`, activity);
                        formData1.append(`seed_prep[${index}][qty]`, qty);
                        formData1.append(`seed_prep[${index}][unit_cost]`, unitCost);
                        formData1.append(`seed_prep[${index}][total_cost]`, totalCost || 0);
                    });
                }

                // Save 'others' input
                const others = $("#others").val()?.trim();
                if (others) {
                    formData1.append("seeds_prep_others", others);
                }

                // Collect selected varieties (regular + "others")
                $("#variety-container .variety-block").each(function (index) {
                    const varietyId = $(this).data("variety-id");
                    const varietyName = $(this).data("variety-name");
                    const purchaseType = $(this).find(`input[name="purchase_status_${varietyId}"]:checked`).val();

                    const qty = $(this).find(".quantity").val() || 0;
                    const unitCost = $(this).find(".unit-cost").val() || 0;
                    const totalCost = $(this).find(".total-cost").val() || 0;

                    formData1.append(`seed_varieties[${index}][seed_variety_id]`, varietyId.toString().startsWith("other_") ? "" : varietyId);
                    formData1.append(`seed_varieties[${index}][variety_name]`, varietyName);
                    formData1.append(`seed_varieties[${index}][purchase_type]`, purchaseType);
                    formData1.append(`seed_varieties[${index}][qty]`, qty);
                    formData1.append(`seed_varieties[${index}][unit_cost]`, unitCost);
                    formData1.append(`seed_varieties[${index}][total_cost]`, totalCost);
                });
            },
            "seedbed-prep": () => {
                const cropMethod = $('#crop-method').val();
                if (cropMethod !== 'TPR') return;

                const isPakyaw = $("#seedbed-prep-pakyaw").is(":checked") ? 1 : 0;
                formData1.append("seedbed_prep_is_pakyaw", isPakyaw);

                if (isPakyaw) {
                    const packageCost = $("#seedbed-prep-pakyaw-total-cost-input").val() || 0;
                    formData1.append("seedbed_prep_package_cost", packageCost);
                } else {
                    $("#seedbed-prep-regular-fields .block").each(function (index) {
                        const activity = $(this).find('input[name^="seedbed_prep["][name$="[activity]"]').val();
                        const qty = $(this).find('input[name^="seedbed_prep["][name$="[qty]"]').val() || 0;
                        const unitCost = $(this).find('input[name^="seedbed_prep["][name$="[unit_cost]"]').val() || 0;
                        const totalCost = parseFloat(qty) * parseFloat(unitCost);

                        formData1.append(`seedbed_prep[${index}][activity]`, activity);
                        formData1.append(`seedbed_prep[${index}][qty]`, qty);
                        formData1.append(`seedbed_prep[${index}][unit_cost]`, unitCost);
                        formData1.append(`seedbed_prep[${index}][total_cost]`, totalCost || 0);
                    });
                }
            },
            "seedbed-fertilization": () => {
                const cropMethod = $('#crop-method').val();
                if (cropMethod !== 'TPR') return;
                // Seedbed Fertilizer Labor/Activities
                $("#seedbed-fertilization-regular-fields .block").each(function (index) {
                    const activity = $(this).find('input[name^="seedbed_fert["][name$="[activity]"]').val();
                    const qty = $(this).find('input[name^="seedbed_fert["][name$="[qty]"]').val() || 0;
                    const unitCost = $(this).find('input[name^="seedbed_fert["][name$="[unit_cost]"]').val() || 0;
                    const totalCost = parseFloat(qty) * parseFloat(unitCost);

                    formData1.append(`seedbed_fertilization[${index}][activity]`, activity);
                    formData1.append(`seedbed_fertilization[${index}][qty]`, qty);
                    formData1.append(`seedbed_fertilization[${index}][unit_cost]`, unitCost);
                    formData1.append(`seedbed_fertilization[${index}][total_cost]`, totalCost || 0);
                });

                // Optional 'Others' text field
                const others = $("#others-fertilizer").val()?.trim();
                if (others) {
                    formData1.append("seedbed_fertilization_others", others);
                }

                // Fertilizer entries
                $("#fertilizer-container .fertilizer-block").each(function (index) {
                    const fertilizerName = $(this).data("fertilizer-name");
                    const purchaseType = $(this).find(`input[name^="fertilizer_type_"]:checked`).val() || '';

                    const qty = $(this).find(".quantity").val() || 0;
                    const unitCost = $(this).find(".unit-cost").val() || 0;
                    const totalCost = $(this).find(".total-cost").val() || 0;

                    formData1.append(`seedbed_fertilizer[${index}][fertilizer_name]`, fertilizerName);
                    formData1.append(`seedbed_fertilizer[${index}][purchase_type]`, purchaseType);
                    formData1.append(`seedbed_fertilizer[${index}][qty]`, qty);
                    formData1.append(`seedbed_fertilizer[${index}][unit_cost]`, unitCost);
                    formData1.append(`seedbed_fertilizer[${index}][total_cost]`, totalCost);
                });
            },
            // Crop Establishment
            "crop-establishment": () => {
                const cropMethod = $('#crop-method').val(); // DWSR or TPR

                let cropEstablishmentType = '';
                if (cropMethod === 'DWSR') {
                    cropEstablishmentType = $('#dwsr-section select[name="establishment_type"]').val() || '';
                } else {
                    cropEstablishmentType = $('#tpr-section input[name="establishment_type"]:checked').val() || '';
                }

                const isCropPakyaw = $('#crop-establishment-pakyaw').is(':checked') ? 1 : 0;

                formData1.append('crop_est_method', cropMethod);
                formData1.append('crop_est_establishment_type', cropEstablishmentType);
                formData1.append('crop_est_is_pakyaw', isCropPakyaw);

                if (isCropPakyaw) {
                    const totalPackageCost = $('#crop-establishment-pakyaw-total-cost-input').val() || 0;
                    formData1.append('crop_est_package_total_cost', totalPackageCost);
                } else {
                    let partIndex = 0;

                    if (cropMethod === 'DWSR') {
                        const $block = $('#dwsr-section');

                        const activity = $block.find('input[name="crop_est_particulars[0][activity]"]').val();
                        const qty = $block.find('input[name="crop_est_particulars[0][qty]"]').val() || 0;
                        const unitCost = $block.find('input[name="crop_est_particulars[0][unit_cost]"]').val() || 0;
                        const totalCost = parseFloat(qty) * parseFloat(unitCost);

                        formData1.append(`crop_est_particulars[${partIndex}][activity]`, activity);
                        formData1.append(`crop_est_particulars[${partIndex}][qty]`, qty);
                        formData1.append(`crop_est_particulars[${partIndex}][unit_cost]`, unitCost);
                        formData1.append(`crop_est_particulars[${partIndex}][total_cost]`, totalCost || 0);

                    } else if (cropMethod === 'TPR') {
                        $('#tpr-section .block').each(function () {
                            const $block = $(this);
                            const isManualOnly = $block.is('[data-tpr-block="manual-only"]');

                            if (cropEstablishmentType === 'Mechanical' && isManualOnly) return;

                            const activity = $block.find('input[name$="[activity]"]').val();
                            if (!activity?.trim()) return; // ✅ skip empty ones
                            const qty = $block.find('input[name$="[qty]"]').val() || 0;
                            const unitCost = $block.find('input[name$="[unit_cost]"]').val() || 0;
                            const totalCost = parseFloat(qty) * parseFloat(unitCost);

                            formData1.append(`crop_est_particulars[${partIndex}][activity]`, activity);
                            formData1.append(`crop_est_particulars[${partIndex}][qty]`, qty);
                            formData1.append(`crop_est_particulars[${partIndex}][unit_cost]`, unitCost);
                            formData1.append(`crop_est_particulars[${partIndex}][total_cost]`, totalCost || 0);

                            partIndex++;
                        });
                    }
                }
            },
            "fertilizer-management": () => {
                $('#fertilizer-applications-wrapper .fertilizer-application-block').each(function (appIndex) {
                    const $block = $(this);

                    // Fertilizer selections
                    const fertilizers = $block.find('select[name="fertilizer-application[]"]').val() || [];
                    fertilizers.forEach((val, idx) => {
                        formData1.append(`fertilizer_management[${appIndex}][fertilizers][${idx}]`, val);
                    });

                    // Others input
                    const others = $block.find('input[name="others-fertilizer-application"]').val()?.trim();
                    if (others) {
                        formData1.append(`fertilizer_management[${appIndex}][others]`, others);
                    }

                    // Fertilizer items
                    $block.find('.fertilizer-block').each(function (itemIndex) {
                        const $item = $(this);
                        const fertName = $item.data("fertilizer-name");
                        const purchaseType = $item.find('input[type="radio"]:checked').val() || '';
                        const qty = $item.find(".quantity").val() || 0;
                        const unitCost = $item.find(".unit-cost").val() || 0;
                        const totalCost = $item.find(".total-cost").val() || 0;

                        formData1.append(`fertilizer_management[${appIndex}][items][${itemIndex}][fertilizer_name]`, fertName);
                        formData1.append(`fertilizer_management[${appIndex}][items][${itemIndex}][purchase_type]`, purchaseType);
                        formData1.append(`fertilizer_management[${appIndex}][items][${itemIndex}][qty]`, qty);
                        formData1.append(`fertilizer_management[${appIndex}][items][${itemIndex}][unit_cost]`, unitCost);
                        formData1.append(`fertilizer_management[${appIndex}][items][${itemIndex}][total_cost]`, totalCost);
                    });

                    // 🔧 FIXED Labor Section
                    const $laborApp = $block.find('.fertilizer-management-block .block').filter(function () {
                        return $(this).find('.form-label').first().text().includes('Fertilizer application');
                    });
                    const fertQty = $laborApp.find('.quantity').val() || 0;
                    const fertUnitCost = $laborApp.find('.unit-cost').val() || 0;
                    const fertTotal = parseFloat(fertQty) * parseFloat(fertUnitCost);
                    formData1.append(`fertilizer_management[${appIndex}][fert_application][activity]`, "Labor: Fertilizer application");
                    formData1.append(`fertilizer_management[${appIndex}][fert_application][qty]`, fertQty);
                    formData1.append(`fertilizer_management[${appIndex}][fert_application][unit_cost]`, fertUnitCost);
                    formData1.append(`fertilizer_management[${appIndex}][fert_application][total_cost]`, fertTotal || 0);

                    const $laborMeals = $block.find('.fertilizer-management-block .block').filter(function () {
                        return $(this).find('.form-label').first().text().includes('Meals and Snacks');
                    });
                    const mealsQty = $laborMeals.find('.quantity').val() || 0;
                    const mealsUnitCost = $laborMeals.find('.unit-cost').val() || 0;
                    const mealsTotal = parseFloat(mealsQty) * parseFloat(mealsUnitCost);
                    formData1.append(`fertilizer_management[${appIndex}][meals][activity]`, "Meals and Snacks");
                    formData1.append(`fertilizer_management[${appIndex}][meals][qty]`, mealsQty);
                    formData1.append(`fertilizer_management[${appIndex}][meals][unit_cost]`, mealsUnitCost);
                    formData1.append(`fertilizer_management[${appIndex}][meals][total_cost]`, mealsTotal || 0);
                });
            },
            "water-management": () => {
                const wmType = $('input[name="water-management-type"]:checked').val(); // 'nia' or 'supplementary'
                const isWmPakyaw = $('#water-management-pakyaw').is(':checked');
                const wmIsPackage = wmType === 'supplementary' ? (isWmPakyaw ? 1 : 0) : 0;

                formData1.append('water_management_type', wmType);
                formData1.append('water_management_is_package', wmIsPackage);

                if (wmType === 'nia') {
                    const total = parseFloat($('#nia-total-cost-input').val()) || 0;
                    formData1.append('water_management_nia_total', total);
                } else {
                    if (wmIsPackage) {
                        const total = parseFloat($('#water-management-pakyaw-total-cost input').val()) || 0;
                        formData1.append('water_management_package_total_cost', total);
                    } else {
                        $('#irrigation-blocks-container .irrigation-block').each(function (index) {
                            const $block = $(this);
                            const label = $block.find('.irrigation-title').text().trim();
                            const method = $block.find('input[type="radio"]:checked').val() === 'is_nia_both' ? 'nia' : 'supplementary';
                            const irrigationPrefix = `water_irrigations[${index}]`;

                            formData1.append(`${irrigationPrefix}[label]`, label);
                            formData1.append(`${irrigationPrefix}[method]`, method);

                            if (method === 'nia') {
                                const niaTotal = parseFloat($block.find('.nia-per-irrigation-cost').val()) || 0;
                                formData1.append(`${irrigationPrefix}[nia_total]`, niaTotal);
                            } else {
                                $block.find('.supplementary-irrigation-details .block').each(function (detailIndex) {
                                    const $detail = $(this);
                                    const activity = $detail.find('input[name$="[activity]"]').val()?.trim();
                                    const qty = parseInt($detail.find('.quantity').val()) || 0;
                                    const unitCost = parseFloat($detail.find('.unit-cost').val()) || 0;
                                    const totalCost = parseFloat(qty * unitCost) || 0;

                                    const detailPrefix = `${irrigationPrefix}[details][${detailIndex}]`;

                                    formData1.append(`${detailPrefix}[activity]`, activity);
                                    formData1.append(`${detailPrefix}[qty]`, qty);
                                    formData1.append(`${detailPrefix}[unit_cost]`, unitCost);
                                    formData1.append(`${detailPrefix}[total_cost]`, totalCost);
                                });
                            }
                        });
                    }
                }
            },
            "pest-management": () => {
                $('#pesticide-applications-wrapper .pesticide-application-block').each(function (appIndex) {
                    const $block = $(this);

                    // Detect non-empty block
                    const pesticides = $block.find(`select[name^="pesticide_application["]`).val() || [];
                    const hasPesticide = pesticides.length > 0;
                    const hasLaborQty = $block.find('.quantity').filter(function () {
                        return parseFloat($(this).val()) > 0;
                    }).length > 0;

                    if (!hasPesticide && !hasLaborQty) {
                        return; // ❌ skip this application
                    }

                    // ✅ Append Label
                    const appLabel = $block.find('.application-label').text().trim();
                    formData1.append(`pesticide_management[${appIndex}][label]`, appLabel);

                    // ✅ Append Pesticides
                    pesticides.forEach((val, idx) => {
                        formData1.append(`pesticide_management[${appIndex}][pesticides][${idx}]`, val);
                    });

                    // ✅ Append Others
                    const others = $block.find(`input[name^="others-pesticide-application["]`).val()?.trim();
                    if (others) {
                        formData1.append(`pesticide_management[${appIndex}][others]`, others);
                    }

                    // ✅ Append Brand Names
                    $block.find('.brand-name').each(function () {
                        const nameAttr = $(this).attr("name"); // ex. pesticide_management[0][brand_names][Insecticide]
                        const brandName = $(this).val()?.trim();
                        if (!nameAttr || !brandName) return;

                        const match = nameAttr.match(/pesticide_management\[(\d+)\]\[brand_names\]\[([^\]]+)\]/);
                        if (match) {
                            const idx = match[1];
                            const type = match[2];
                            formData1.append(`pesticide_management[${appIndex}][brand_names][${type}]`, brandName);
                        }
                    });

                    // ✅ Append Labor Items
                    const laborTypes = [
                        { key: 'chemical', label: 'Labor: Chemical Application' },
                        { key: 'weeding', label: 'Labor: Manual Weeding' },
                        { key: 'meals', label: 'Meals and Snacks' },
                    ];

                    laborTypes.forEach(({ key, label }) => {
                        const $labBlock = $block.find(`input[value="${label}"]`).closest('.block')
                        const qty = parseFloat($labBlock.find('.quantity').val()) || 0;
                        const unitCost = parseFloat($labBlock.find('.unit-cost').val()) || 0;
                        const totalCost = qty * unitCost;

                        formData1.append(`pesticide_management[${appIndex}][${key}][activity]`, label);
                        formData1.append(`pesticide_management[${appIndex}][${key}][qty]`, qty);
                        formData1.append(`pesticide_management[${appIndex}][${key}][unit_cost]`, unitCost);
                        formData1.append(`pesticide_management[${appIndex}][${key}][total_cost]`, totalCost);
                    });
                });
            }

        };

        const validateSteps = async () => {
            for (let i = 0; i < steps.length; i++) {
                const step = steps[i];
                formData1.set("step", step);
                stepForms[step]();

                try {
                    const result = await $.ajax({
                        url: "{{ route('baseline-monitoring.validateStep') }}",
                        type: "POST",
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        data: formData1,
                        processData: false,
                        contentType: false,
                    });

                    console.log(`✅ Step ${i + 1} valid:`, result);
                } catch (xhr) {
                    if (xhr.status === 422) {
                        showAlertModal("error", `❌ Please review Step ${i + 1} before submitting.`);
                    } else {
                        showAlertModal("error", "Something went wrong during validation.");
                    }
                    hideLoader();
                    return false;
                }
            }

            // All steps validated → Submit
            Object.values(stepForms).forEach(fn => fn());
            submitFinalForm();
        };

        validateSteps();
    });

});
</script>
