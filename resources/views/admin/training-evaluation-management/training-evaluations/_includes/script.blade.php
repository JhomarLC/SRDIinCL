<script>
    // VIEW
    $(document).ready(function () {
        $("#eval").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('training-evaluation-management.get-index', $training_event->id) }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id', visible: false },
                { data: 'training_content_evaluation', name: 'training_content_evaluation' },
                { data: 'course_management_evaluation', name: 'course_management_evaluation' },
                { data: 'goal_achievement', name: 'goal_achievement' },
                { data: 'overall_quality', name: 'overall_quality' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $('.select2').select2();

        $('td').on('click', function () {
            const radio = $(this).find('input[type="radio"]');
            if (radio.length) {
                radio.prop('checked', true).trigger('change');
            }
        });

        // ADDRESS
        $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let provinceDropdown = $("#province");
                let provincesArray = Object.values(data);

                provincesArray.forEach(province => {
                    provinceDropdown.append(
                        `<option value="${province.code}">${province.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Failed to load provinces:", error);
            }
        });
    });

    function updateProgressBarToTab(index) {
        const totalLength = $("#custom-progress-bar li").length - 1;
        const percent = (index / totalLength) * 100;
        $("#custom-progress-bar .progress-bar").css("width", percent + "%");

        const form = $(".form-steps");
        const doneTabs = form.find(".custom-nav .done");
        if (doneTabs.length > 0) {
            doneTabs.removeClass("done");
        }

        // Mark all previous tabs as done
        form.find('button[data-bs-toggle="pill"]').each(function (j) {
            if (j <= index) {
                if ($(this).hasClass("active")) {
                    $(this).removeClass("done");
                } else {
                    $(this).addClass("done");
                }
            }
        });
    }


    $(document).ready(function () {
        const form = $(".form-steps");

        $('input[name="recommend_training"]').on("change", function () {
            if ($(this).val() === "1") {
                $('#recommendation_reason').prop('disabled', false);
            } else {
                $('#recommendation_reason').prop('disabled', true).val('');
                $('#recommendation_reason').removeClass("is-invalid").siblings(".invalid-feedback").text('');
            }
        });

        form.on("change", "input[type='radio']", function () {
            const name = $(this).attr("name");
            const radios = $(`input[name="${name}"]`);

            // Remove error class from all radios with the same name
            radios.removeClass("is-invalid");

            // Also remove the error message from the first td (criteria column) if any
            const row = $(this).closest("tr");
            row.find("td:first .invalid-feedback").remove(); // assuming you injected it here
        });

        // Clear error state on input change or typing
        form.on("input change", "input, select, textarea", function () {
            $(this).removeClass("is-invalid");
            $(this).siblings(".invalid-feedback").text("");
            $(this).closest('.col-sm-6').find(".invalid-feedback").text("");
        });


        $(".nexttab").on("click", function (e) {
            e.preventDefault();

            const nextButton = $(this);
            const currentPane = $(".tab-pane.show");
            const step = currentPane.attr("id").replace("pills-", "");

            const formData = new FormData();

            if (step === "training-content") {
                const objective_score = $('input[name="objective_score"]:checked').val() || "";
                const relevance_score = $('input[name="relevance_score"]:checked').val() || "";
                const content_completeness_score = $('input[name="content_completeness_score"]:checked').val() || "";
                const lecture_hands_on_score = $('input[name="lecture_hands_on_score"]:checked').val() || "";
                const sequence_score = $('input[name="sequence_score"]:checked').val() || "";
                const duration_score = $('input[name="duration_score"]:checked').val() || "";
                const assessment_method_score = $('input[name="assessment_method_score"]:checked').val() || "";

                formData.append("objective_score", objective_score);
                formData.append("relevance_score", relevance_score);
                formData.append("content_completeness_score", content_completeness_score);
                formData.append("lecture_hands_on_score", lecture_hands_on_score);
                formData.append("sequence_score", sequence_score);
                formData.append("duration_score", duration_score);
                formData.append("assessment_method_score", assessment_method_score);

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "course-management") {
                const coordination_score = $('input[name="coordination_score"]:checked').val() || "";
                const time_management_score = $('input[name="time_management_score"]:checked').val() || "";
                const speaker_quality_score = $('input[name="speaker_quality_score"]:checked').val() || "";
                const facilitators_score = $('input[name="facilitators_score"]:checked').val() || "";
                const support_staff_score = $('input[name="support_staff_score"]:checked').val() || "";
                const materials_score = $('input[name="materials_score"]:checked').val() || "";
                const facility_score = $('input[name="facility_score"]:checked').val() || "";
                const accommodation_score = $('input[name="accommodation_score"]:checked').val() || "";
                const food_quality_score = $('input[name="food_quality_score"]:checked').val() || "";
                const transportation_score = $('input[name="transportation_score"]:checked').val() || "";
                const overall_management_score = $('input[name="overall_management_score"]:checked').val() || "";

                formData.append("coordination_score", coordination_score);
                formData.append("time_management_score", time_management_score);
                formData.append("speaker_quality_score", speaker_quality_score);
                formData.append("facilitators_score", facilitators_score);
                formData.append("support_staff_score", support_staff_score);
                formData.append("materials_score", materials_score);
                formData.append("facility_score", facility_score);
                formData.append("accommodation_score", accommodation_score);
                formData.append("food_quality_score", food_quality_score);
                formData.append("transportation_score", transportation_score);
                formData.append("overall_management_score", overall_management_score);

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "overall-evaluation") {
                const goal_achievement = $('input[name="goal_achievement"]:checked').val() || "";
                const overall_quality = $('input[name="overall_quality"]:checked').val() || "";
                formData.append("goal_achievement", goal_achievement);
                formData.append("overall_quality", overall_quality);

                formData.append("additional_feedback_or_suggestions", $("#additional_feedback_or_suggestions").val() || '');

                const recommend_training = $('input[name="recommend_training"]:checked').val();
                const recommendation_reason = $("#recommendation_reason").val() || '';
                formData.append("recommend_training", recommend_training);
                formData.append("recommendation_reason", recommend_training === "1" ? recommendation_reason : ""); // Send empty string if No

                formData.append("preferred_future_trainings", $("#preferred_future_trainings").val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "personal-info") {
                formData.append("first_name", $("#first_name").val() || '');
                formData.append("middle_name", $("#middle_name").val() || '');
                formData.append("last_name", $("#last_name").val() || '');
                formData.append("suffix", $("#suffix").val() || '');
                formData.append("age_group", $('input[name="age_group"]:checked').val() || '');
                formData.append("sex", $("#sex").val() || '');

                let provinceCode = $("#province").val() || $("#update_province").val() || '';

                // Appending the values to formData
                formData.append("province_code", provinceCode);

                formData.append("primary_sector", $("#primary_sector").val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            $.ajax({
                url: "{{ route('training-evaluation-management.validateStep') }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    console.log("✅ Server Response:", response);
                    if (response.success) {
                        // Move to the next tab
                        const nextTabId = nextButton.data("nexttab");
                        const nextButtonEl = $(`button#${nextTabId}`); // assumes the tab buttons have an ID like this
                        const nextIndex = parseInt(nextButtonEl.attr("data-position"));

                        nextButtonEl.tab("show"); // Use Bootstrap's tab function to switch properly
                        updateProgressBarToTab(nextIndex);
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        console.warn("❌ Validation Errors:", errors);

                        // Remove existing error states
                        currentPane.find(".is-invalid").removeClass("is-invalid");

                        $.each(errors, function (key, messages) {
                            const bracketKey = key.replace(/\.(\d+)/g, "[$1]"); // convert dot to bracket notation
                            const input = currentPane.find(`[name="${bracketKey}"]`);

                            if (input.length) {
                                input.addClass("is-invalid");
                                input.siblings(".invalid-feedback").text(messages[0]);
                                input.closest('.col-sm-6').find('.invalid-feedback').text(messages[0]).show();

                                const firstTd = input.closest("tr").find("td:first");
                                firstTd.append(`<div class="invalid-feedback d-block">${messages[0]}</div>`);

                                // Highlight the radio group if it's a radio input
                                if (input.attr("type") === "radio") {
                                    input.addClass("is-invalid");
                                } else {
                                    input.addClass("is-invalid");
                                    input.siblings(".invalid-feedback").text(messages[0]).show();
                                }
                            }
                        });
                    } else {
                        console.error("🚨 Unexpected error:", xhr);
                    }
                }
            });
        });

        // Previous tab logic
        $(".previestab").on("click", function () {
            const prevTab = $(this).data("previous");
            $("#" + prevTab).click();
        });

        // Tab step progress bar logic
        form.find('button[data-bs-toggle="pill"]').each(function (index) {
            const $button = $(this);
            $button.attr("data-position", index);

            $button.on("click", function () {
                form.removeClass("was-validated");

                const getProgressBar = $button.data("progressbar");
                const index = parseInt($button.attr("data-position"));

                if (getProgressBar) {
                    updateProgressBarToTab(index);
                }
            });
        });

    })

</script>
