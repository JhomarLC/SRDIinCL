<script>
    $(document).ready(function () {
        $("#updateTrainingEvaluation").on("click", function (e) {
            e.preventDefault();
            showLoader("Validating...");

            const formData1 = new FormData();

            // 1. Handle all input fields except radios and checkboxes first
            $('form :input').each(function () {
                const type = $(this).attr('type');
                const name = $(this).attr('name');
                if ((type === 'radio' || type === 'checkbox') && !$(this).is(':checked')) return;
                if ($(this).closest('.employee-entry').length > 0) return;
                formData1.append(name, $(this).val() || '');
            });

            // Handle add employee entries again
            $('#employeeContainer .employee-entry').each(function (index) {
                const $entry = $(this);
                formData1.set(`employee_name[${index}]`, $entry.find(`input[name="employee_name[${index}]"]`).val() || '');
                formData1.set(`employee_reason[${index}]`, $entry.find(`input[name="employee_reason[${index}]"]`).val() || '');
            });

            // You can include this part if needed:
            formData1.set("recommend_training", $('input[name="recommend_training"]:checked').val() || '');
            formData1.set("recommendation_reason", $("#recommendation_reason").val() || '');

            console.log("🧾 FormData being sent:");
                for (const pair of formData1.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            $.ajax({
                url: "{{ route('training-evaluation-management.update', [$training_event->id, $evaluation->id]) }}",
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
                            window.location.href = "{{ url('/training-evaluation-management/' . $training_event->id . '/evaluations')}}";
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
                },
                complete: function () {
                    hideLoader(); // Always hide when done
                }
            });
        });
    });
    </script>
