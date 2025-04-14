<script>
    $(document).ready(function () {
        $("#updateFarmersProfile").on("click", function (e) {
            e.preventDefault();

            const formData1 = new FormData();

            // 1. Handle all input fields except radios and checkboxes first
            $('form :input').each(function () {
                const type = $(this).attr('type');
                const name = $(this).attr('name');

                // Skip unchecked radio/checkbox
                if ((type === 'radio' || type === 'checkbox') && !$(this).is(':checked')) {
                    return;
                }

                // ❌ Skip training-entry to avoid duplication (we’ll handle them explicitly)
                if ($(this).closest('.training-entry').length > 0) {
                    return;
                }

                formData1.append(name, $(this).val() || $(this).data("old-value") || '');
            });

            // 2. Explicitly handle training entries (like trainings attended)
            $('#trainingContainer .training-entry').each(function (index) {
                const $entry = $(this);

                const title = $entry.find(`input[name="training_title[${index}]"]`).val() || '';
                const date = $entry.find(`input[name="training_date[${index}]"]`).val() || '';
                const conductedBy = $entry.find(`input[name="conducted_by[${index}]"]`).val() || '';
                const personallyPaid = $entry.find(`input[name="personally_paid[${index}]"]:checked`).val() || '';

                formData1.set(`training_title[${index}]`, title);
                formData1.set(`training_date[${index}]`, date);
                formData1.set(`conducted_by[${index}]`, conductedBy);
                formData1.set(`personally_paid[${index}]`, personallyPaid);
            });

            // 3. Explicitly handle training result fields
            formData1.set("training_title_main", $("#training_title_main").val() || '');
            formData1.set("training_date_main", $("#training_date_main").val() || '');
            formData1.set("training_location_main", $("#training_location_main").val() || '');
            formData1.set("pre_test_score", $("#pre_test_score").val() || '');
            formData1.set("post_test_score", $("#post_test_score").val() || '');
            formData1.set("total_test_items", $("#total_test_items").val() || '');
            formData1.set("gain_in_knowledge", $("#gain_in_knowledge").val() || '');
            formData1.set("certificate_type", $("#certificate_type").val() || '');
            formData1.set("certificate_number", $("#certificate_number").val() || '');
            // formData1.set("overall_training_eval_score", $("#overall_training_eval_score").val() || '');
            // formData1.set("trainer_rating", $("#trainer_rating").val() || '');

            // 4. Custom logic like is_pwd and is_indigenous
            const isPwd = $('input[name="is_pwd"]:checked').val();
            const disability_type = $("#disability_type").val() || '';
            formData1.set("is_pwd", isPwd || '');
            formData1.set("disability_type", isPwd === "1" ? disability_type : '');

            const isIndigenous = $('input[name="is_indigenous"]:checked').val();
            const tribeName = $("#tribe_name").val() || '';
            formData1.set("is_indigenous", isIndigenous || '');
            formData1.set("tribe_name", isIndigenous === "1" ? tribeName : '');

            console.log("🧾 FormData being sent:");
            for (const pair of formData1.entries()) {
                console.log(`${pair[0]}: ${pair[1]}`);
            }

            $.ajax({
                url: "{{ route('farmers-profile.update', $participant->id) }}",
                type: "POST", // or "PUT" if you're using method spoofing
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "X-HTTP-Method-Override": "PUT" // if using POST with method override
                },
                data: formData1,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log("✅ Server Response:", response);
                    if (response.status === 'success') {
                        showAlertModal(response.status, response.message);
                        setTimeout(function () {
                            window.location.href = "/admin/farmers-profile";
                        }, 1500);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const res = xhr.responseJSON;
                        console.warn("❌ Validation Errors:", res);
                        if (res && res.status && res.message) {
                            showAlertModal(res.status, res.message);
                        } else {
                            showAlertModal("error", "Validation failed. Please check all your inputs.");
                        }
                    } else {
                        showAlertModal("error", "Unexpected error!");
                        console.error("🚨 Unexpected error:", xhr);
                    }
                }
            });
        });
    });
    </script>
