<script>
$(function () {
    const submitFinalForm = () => {
        const fullFormData = new FormData();

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
            const seedsPackageCost = $("#seedsPrepPakyawTotalCost").val() || 0;
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

        const steps = ["land-preparation", "seeds-prep"];
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
                    const packageCost = $("#seedsPrepPakyawTotalCost").val() || 0;
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
