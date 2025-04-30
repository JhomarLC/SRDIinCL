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

          // Update
          $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let provinceDropdown = $("#update_province");
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

        let provinceCode = "{{ $evaluation->training_participant_info->province_code ?? '' }}";
        $("#update_province").html('<option>Loading...</option>').prop("disabled", true);

         // ✅ Load Province after Region is Selected
         $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#update_province").empty().append('<option selected disabled hidden>-- SELECT PROVINCE --</option>').prop("disabled", false);
                data.forEach(province => {
                    $("#update_province").append(`<option value="${province.code}">${province.name}</option>`);
                });

                if (provinceCode) {
                    $("#update_province").val(provinceCode).trigger("change");
                }
            },
            error: function () {
                console.error("Failed to load provinces.");
            }
        });
    });

    $(document).ready(function(){
        // 1) Initialize your very first entry as index 0
        $('.employee-entry').first().find('input').each(function(){
            const $in   = $(this);
            const field = $in.attr('name')          // "employee_name[]" or "employee_reason[]"
                            .replace(/\[\]$/, ''); // "employee_name" or "employee_reason"
            $in
            .attr('name', field + '[0]')
            .attr('id',   field + '_0');
            $(`label[for="${$in.attr('id')}"]`).attr('for', field + '_0');
        });
    });

    $(document).on('click', '.add-employee', function () {
        // 2) Clone + rename exactly like training does
        let $firstEntry   = $('.employee-entry').first();
        let currentIndex  = $('.employee-entry').length;   // e.g. 1, 2, 3…
        let $clone        = $firstEntry.clone();

        $clone.find('input').each(function(){
            const $in    = $(this);
            const oldName= $in.attr('name');                 // e.g. "employee_name[0]"
            const base   = oldName.replace(/\[\d+\]/, '');   // "employee_name"
            const newName= `${base}[${currentIndex}]`;       // "employee_name[1]"
            const oldId  = $in.attr('id');                   // e.g. "employee_name_0"
            const newId  = `${base}_${currentIndex}`;        // "employee_name_1"

            // Update the input
            $in
            .attr('name', newName)
            .attr('id',   newId)
            .val('')                     // clear any old value
            .removeClass('is-invalid');  // clear validation state

            // Re-point its <label>
            $clone.find(`label[for="${oldId}"]`)
                .attr('for', newId);
        });

        // show the “remove” button on the clone
        $clone.find('.remove-employee').removeClass('d-none');

        // append it
        $('#employeeContainer').append($clone);
    });

        // Clear & Remove stay the same
    $(document).on('click', '.clear-employee', function () {
        $(this).closest('.employee-entry').find('input').val('');
    });
    $(document).on('click', '.remove-employee', function () {
        $(this).closest('.employee-entry').remove();
    });


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

        async function finalValidationBeforeSubmit(formData) {
            try {
                await $.ajax({
                    url: "{{ route('training-evaluation-management.validateAll') }}", // You can also use route('participant.validateStep') in sequence
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                });

                // ✅ Passed → submit
                submitFinalForm();
            } catch (error) {
                console.log(error);

                if (error.status === 422) {
                    const errors = error.responseJSON.errors;

                    showAlertModal("error", "Please review highlighted tabs and fix errors.");
                    for (const tabKey in errors) {
                        $(`button[data-bs-target="#pills-${tabKey}"]`).addClass("text-danger");
                    }
                } else {
                    showAlertModal("error", "Unexpected validation issue.");
                }
                hideLoader();
            }
        }

        const submitFinalForm = () => {
            const fullFormData = new FormData();

            // 1. Handle all input fields except radios and checkboxes first
            $('form :input').each(function () {
                const type = $(this).attr('type');
                const name = $(this).attr('name');
                if ((type === 'radio' || type === 'checkbox') && !$(this).is(':checked')) return;
                if ($(this).closest('.employee-entry').length > 0) return;
                fullFormData.append(name, $(this).val() || '');
            });

            // Handle add employee entries again
            $('#employeeContainer .employee-entry').each(function (index) {
                const $entry = $(this);
                fullFormData.set(`employee_name[${index}]`, $entry.find(`input[name="employee_name[${index}]"]`).val() || '');
                fullFormData.set(`employee_reason[${index}]`, $entry.find(`input[name="employee_reason[${index}]"]`).val() || '');
            });

            // You can include this part if needed:
            fullFormData.set("recommend_training", $('input[name="recommend_training"]:checked').val() || '');
            fullFormData.set("recommendation_reason", $("#recommendation_reason").val() || '');

            // Final AJAX POST
            $.ajax({
                url: "{{ route('training-evaluation-management.store',$training_event->id) }}",
                type: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                data: fullFormData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showAlertModal("success", response.message);
                    setTimeout(() => {
                        window.location.href = "{{ url('/training-evaluation-management/' . $training_event->id . '/evaluations')}}";
                    }, 1500);
                },
                error: function (xhr) {
                    console.error("❌ Final Submission Error", xhr);
                    showAlertModal("error", "Something went wrong during final submission.");
                },
                complete: function () {
                    hideLoader(); // Always hide when done
                }
            });
        }

        $("#submitTrainingEvaluation").on("click", function (e) {
            e.preventDefault();

            showLoader("Validating...");

            const steps = [
                "training-content",
                "course-management",
                "overall-evaluation",
                "personal-info"
            ];

            const formData1 = new FormData();

            const stepForms = {
                "training-content": () => {
                    const objective_score = $('input[name="objective_score"]:checked').val() || "";
                    const relevance_score = $('input[name="relevance_score"]:checked').val() || "";
                    const content_completeness_score = $('input[name="content_completeness_score"]:checked').val() || "";
                    const lecture_hands_on_score = $('input[name="lecture_hands_on_score"]:checked').val() || "";
                    const sequence_score = $('input[name="sequence_score"]:checked').val() || "";
                    const duration_score = $('input[name="duration_score"]:checked').val() || "";
                    const assessment_method_score = $('input[name="assessment_method_score"]:checked').val() || "";

                    formData1.append("objective_score", objective_score);
                    formData1.append("relevance_score", relevance_score);
                    formData1.append("content_completeness_score", content_completeness_score);
                    formData1.append("lecture_hands_on_score", lecture_hands_on_score);
                    formData1.append("sequence_score", sequence_score);
                    formData1.append("duration_score", duration_score);
                    formData1.append("assessment_method_score", assessment_method_score);

                    formData1.append("objective_comment", $("#objective_comment").val() || '');
                    formData1.append("relevance_comment", $("#relevance_comment").val() || '');
                    formData1.append("content_completeness_comment", $("#content_completeness_comment").val() || '');
                    formData1.append("lecture_hands_on_comment", $("#lecture_hands_on_comment").val() || '');
                    formData1.append("sequence_comment", $("#sequence_comment").val() || '');
                    formData1.append("duration_comment", $("#duration_comment").val() || '');
                    formData1.append("assessment_method_comment", $("#assessment_method_comment").val() || '');

                    formData1.append("low_score_comment_1", $("#low_score_comment_1").val() || '');

                    formData1.append("three_topics", $('input[name="three_topics"]').val() || '');
                },
                "course-management": () => {
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

                    formData1.append("coordination_score", coordination_score);
                    formData1.append("time_management_score", time_management_score);
                    formData1.append("speaker_quality_score", speaker_quality_score);
                    formData1.append("facilitators_score", facilitators_score);
                    formData1.append("support_staff_score", support_staff_score);
                    formData1.append("materials_score", materials_score);
                    formData1.append("facility_score", facility_score);
                    formData1.append("accommodation_score", accommodation_score);
                    formData1.append("food_quality_score", food_quality_score);
                    formData1.append("transportation_score", transportation_score);
                    formData1.append("overall_management_score", overall_management_score);

                    formData1.append("coordination_comment", $("#coordination_comment").val() || '');
                    formData1.append("time_management_comment", $("#time_management_comment").val() || '');
                    formData1.append("speaker_quality_comment", $("#speaker_quality_comment").val() || '');
                    formData1.append("facilitators_comment", $("#facilitators_comment").val() || '');
                    formData1.append("support_staff_comment", $("#support_staff_comment").val() || '');
                    formData1.append("materials_comment", $("#materials_comment").val() || '');
                    formData1.append("facility_comment", $("#facility_comment").val() || '');
                    formData1.append("accommodation_comment", $("#accommodation_comment").val() || '');
                    formData1.append("food_quality_comment", $("#food_quality_comment").val() || '');
                    formData1.append("transportation_comment", $("#transportation_comment").val() || '');
                    formData1.append("overall_management_comment", $("#overall_management_comment").val() || '');

                    formData1.append("low_score_comment_2", $("#low_score_comment_2").val() || '');
                },
                "overall-evaluation": () => {
                     // Manually append each field (or dynamically if needed)
                    formData1.append("goal_achievement", $('input[name="goal_achievement"]:checked').val() || '');
                    formData1.append("overall_quality", $('input[name="overall_quality"]:checked').val() || '');
                    formData1.append("additional_feedback_or_suggestions", $("#additional_feedback_or_suggestions").val() || '');

                    const recommend_training = $('input[name="recommend_training"]:checked').val();
                    const recommendation_reason = $("#recommendation_reason").val() || '';
                    formData1.append("recommend_training", recommend_training);
                    formData1.append("recommendation_reason", recommend_training === "1" ? recommendation_reason : ""); // Send empty string if No

                    formData1.append("preferred_future_trainings", $("#preferred_future_trainings").val() || '');

                    $("#employeeContainer .employee-entry").each(function (index) {
                        const employee_name = $(this).find('[name^="employee_name"]').val();
                        const employee_reason = $(this).find('[name^="employee_reason"]').val();

                        formData1.append(`employee_name[${index}]`, employee_name || '');
                        formData1.append(`employee_reason[${index}]`, employee_reason || '');
                    });
                },
                "personal-info": () => {
                     // Manually append each field (or dynamically if needed)
                    formData1.append("first_name", $("#first_name").val() || '');
                    formData1.append("middle_name", $("#middle_name").val() || '');
                    formData1.append("last_name", $("#last_name").val() || '');
                    formData1.append("suffix", $("#suffix").val() || '');
                    formData1.append("age_group", $('input[name="age_group"]:checked').val() || '');
                    formData1.append("sex", $("#sex").val() || '');

                    let provinceCode = $("#province").val() || '';

                    // Appending the values to formData
                    formData1.append("province_code", provinceCode);
                    formData1.append("primary_sector", $("#primary_sector").val() || '');
                },
            };

            // ✅ Validate each step in sequence
            const validateSteps = async () => {
                for (let i = 0; i < steps.length; i++) {
                    const step = steps[i];
                    formData1.set("step", step); // tell backend which step this is

                    // Prepare FormData for the current step
                    stepForms[step]();

                    try {
                        const result = await $.ajax({
                            url: "{{ route('training-evaluation-management.validateStep') }}",
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
                        return false; // Stop loop and submission
                    }
                }

                // All steps validated successfully → Proceed to final submission
                // submitFinalForm();
                Object.values(stepForms).forEach(fn => fn()); // fill formData1
                finalValidationBeforeSubmit(formData1); // re-use it
            };

            // Start the validation process
            validateSteps();
        })

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

                $("#employeeContainer .employee-entry").each(function (index) {
                    const employee_name = $(this).find('[name^="employee_name"]').val();
                    const employee_reason = $(this).find('[name^="employee_reason"]').val();

                    formData.append(`employee_name[${index}]`, employee_name || '');
                    formData.append(`employee_reason[${index}]`, employee_reason || '');
                });

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

    $(document).ready(function () {
        // Handle the Edit button click
        $(document).on("click", ".status-unarchive", function () {
            // Get data from the button attributes
            let evalId = $(this).data("id");

            // Populate the modal fields
            $("#unarchive-edit-id").val(evalId);

            // Show the modal
            $("#unarchiveEvalModal").modal("show");
        });

        $("#unarchiveEvalForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let trainingEventId = $("#training_event").val();
            let evalId = $("#unarchive-edit-id").val();

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/training-evaluation-management/" + trainingEventId + "/evaluations/" + evalId + '/unarchive',
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#eval").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#unarchiveEvalModal").modal("hide");
                    showAlertModal(response.status, response.message);

                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(xhr);
                }
            });
        });

        // Handle the Edit button click
        $(document).on("click", ".status-archive", function () {
            // Get data from the button attributes
            let evalId = $(this).data("id");

            // Populate the modal fields
            $("#archive-edit-id").val(evalId);

            // Show the modal
            $("#archiveEvalModal").modal("show");
        });

        $("#archiveEvalForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let trainingEventId = $("#training_event").val();
            let evalId = $("#archive-edit-id").val();

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/training-evaluation-management/" + trainingEventId + "/evaluations/" + evalId + '/archive',
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#eval").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#archiveEvalModal").modal("hide"); // Hide modal
                    showAlertModal(response.status, response.message);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(xhr);
                }
            });
        });
    });
</script>
