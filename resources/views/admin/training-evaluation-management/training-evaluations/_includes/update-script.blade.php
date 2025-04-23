<script>
    $(document).ready(function () {
        $("#updateEvaluationProfile").on("click", function (e) {
            e.preventDefault();
            showLoader("Validating...");

            const formData1 = new FormData();

            // 1. Handle all input fields except radios and checkboxes first
            $('form :input').each(function () {
                const type = $(this).attr('type');
                const name = $(this).attr('name');
                if ((type === 'radio' || type === 'checkbox') && !$(this).is(':checked')) return;
                if ($(this).closest('.training-entry').length > 0) return;
                formData1.append(name, $(this).val() || '');
            });

            // You can include this part if needed:
            formData1.set("is_pwd", $('input[name="is_pwd"]:checked').val() || '');
            formData1.set("disability_type", $("#disability_type").val() || '');

            formData1.set("is_indigenous", $('input[name="is_indigenous"]:checked').val() || '');
            formData1.set("tribe_name", $("#tribe_name").val() || '');

            $.ajax({
                url: "{{ route('speaker-eval.update', [$speaker->id, $speaker_topic->id, $evaluation->id]) }}",
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
                            window.location.href = "{{ url('/admin/speaker-management/' . $speaker->id . '/topics/' . $speaker_topic->id) . '/evaluations'}}";
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
