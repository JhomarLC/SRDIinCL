<script>
    // VIEW
    $(document).ready(function () {
        $("#eval").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('speaker-eval.get-index', [$speaker->id, $speaker_topic->id]) }}",
            columns: [
                { data: 'knowledge_score', name: 'knowledge_score' },
                { data: 'teaching_method_score', name: 'teaching_method_score' },
                { data: 'audiovisual_score', name: 'audiovisual_score' },
                { data: 'clarity_score', name: 'clarity_score' },
                { data: 'question_handling_score', name: 'question_handling_score' },
                { data: 'audience_connection_score', name: 'audience_connection_score' },
                { data: 'content_relevance_score', name: 'content_relevance_score' },
                { data: 'goal_achievement_score', name: 'goal_achievement_score' },
                { data: 'additional_feedback', name: 'additional_feedback' },
                { data: 'overall_score', name: 'overall_score' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        $('.select2').select2();
    });

    $(document).ready(function () {
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

        // Load municipalities based on selected province
        $("#province").change(function () {
            let provinceCode = $(this).val();
            $("#municipality").prop("disabled", false).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let municipalityDropdown = $("#municipality");
                    let municipalitiesArray = Object.values(data);

                    municipalitiesArray.forEach(municipality => {
                        municipalityDropdown.append(
                            `<option value="${municipality.code}">${municipality.name}</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Failed to load municipalities:", error);
                }
            });
        });
    });

    $(document).ready(function () {
        const form = $(".form-steps");

        $('input[name="is_pwd"]').on("change", function () {
            if ($(this).val() === "1") {
                $('#disability_type').prop('disabled', false);
            } else {
                $('#disability_type').prop('disabled', true).val('');
                $('#disability_type').removeClass("is-invalid").siblings(".invalid-feedback").text('');
            }
        });

        $('input[name="is_indigenous"]').on("change", function () {
            if ($(this).val() === "1") {
                $('#tribe_name').prop('disabled', false);
            } else {
                $('#tribe_name').prop('disabled', true).val('');
                $('#tribe_name').removeClass("is-invalid").siblings(".invalid-feedback").text('');
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

        $("#submitEvaluationProfile").on("click", function (e) {
            e.preventDefault();

            const steps = [
                "speaker-evaluation",
                "evaluation-personal-info"
            ];

            const formData1 = new FormData();

            const stepForms = {
                "speaker-evaluation": () => {
                    const knowledge_score = $('input[name="knowledge_score"]:checked').val() || "";
                    const teaching_method_score = $('input[name="teaching_method_score"]:checked').val() || "";
                    const audiovisual_score = $('input[name="audiovisual_score"]:checked').val() || "";
                    const clarity_score = $('input[name="clarity_score"]:checked').val() || "";
                    const question_handling_score = $('input[name="question_handling_score"]:checked').val() || "";
                    const audience_connection_score = $('input[name="audience_connection_score"]:checked').val() || "";
                    const content_relevance_score = $('input[name="content_relevance_score"]:checked').val() || "";
                    const goal_achievement_score = $('input[name="goal_achievement_score"]:checked').val() || "";

                    formData1.append("knowledge_score", knowledge_score);
                    formData1.append("teaching_method_score", teaching_method_score);
                    formData1.append("audiovisual_score", audiovisual_score);
                    formData1.append("clarity_score", clarity_score);
                    formData1.append("question_handling_score", question_handling_score);
                    formData1.append("audience_connection_score", audience_connection_score);
                    formData1.append("content_relevance_score", content_relevance_score);
                    formData1.append("goal_achievement_score", goal_achievement_score);

                    formData1.append("knowledge_score_comment", $("#knowledge_score_comment").val() || '');
                    formData1.append("teaching_method_comment", $("#teaching_method_comment").val() || '');
                    formData1.append("audiovisual_comment", $("#audiovisual_comment").val() || '');
                    formData1.append("clarity_comment", $("#clarity_comment").val() || '');
                    formData1.append("question_handling_comment", $("#question_handling_comment").val() || '');
                    formData1.append("audience_connection_comment", $("#audience_connection_comment").val() || '');
                    formData1.append("content_relevance_comment", $("#content_relevance_comment").val() || '');
                    formData1.append("goal_achievement_comment", $("#goal_achievement_comment").val() || '');
                },
                "evaluation-personal-info": () => {
                     // Manually append each field (or dynamically if needed)
                    formData1.append("first_name", $("#first_name").val() || '');
                    formData1.append("middle_name", $("#middle_name").val() || '');
                    formData1.append("last_name", $("#last_name").val() || '');
                    formData1.append("suffix", $("#suffix").val() || '');
                    formData1.append("age_group", $("#age_group").val() || '');
                    formData1.append("gender", $("#gender").val() || '');

                    const isPwd = $('input[name="is_pwd"]:checked').val();
                    const disability_type = $("#disability_type").val() || '';
                    formData1.append("is_pwd", isPwd);
                    formData1.append("disability_type", isPwd === "1" ? disability_type : ""); // Send empty string if No

                    const isIndigenous = $('input[name="is_indigenous"]:checked').val();
                    const tribeName = $("#tribe_name").val() || '';

                    formData1.append("is_indigenous", isIndigenous);
                    formData1.append("tribe_name", $("#tribe_name").val() || '');

                    let provinceCode = $("#province").val() || $("#update_province").val() || '';

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
                            url: "{{ route('speaker-eval.validateStep') }}",
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
                        return false; // Stop loop and submission
                    }
                }

                // All steps validated successfully → Proceed to final submission
                submitFinalForm();
            };

            const submitFinalForm = () => {
                const fullFormData = new FormData();

                // 1. Handle all input fields except radios and checkboxes first
                $('form :input').each(function () {
                    const type = $(this).attr('type');
                    const name = $(this).attr('name');
                    if ((type === 'radio' || type === 'checkbox') && !$(this).is(':checked')) return;
                    if ($(this).closest('.training-entry').length > 0) return;
                    fullFormData.append(name, $(this).val() || '');
                });

                // You can include this part if needed:
                fullFormData.set("is_pwd", $('input[name="is_pwd"]:checked').val() || '');
                fullFormData.set("disability_type", $("#disability_type").val() || '');

                fullFormData.set("is_indigenous", $('input[name="is_indigenous"]:checked').val() || '');
                fullFormData.set("tribe_name", $("#tribe_name").val() || '');
                  // Final AJAX POST
                $.ajax({
                    url: "{{ route('farmers-profile.store') }}",
                    type: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    },
                    data: fullFormData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        showAlertModal("success", response.message);
                        setTimeout(() => window.location.href = "/admin/farmers-profile", 1500);
                    },
                    error: function (xhr) {
                        console.error("❌ Final Submission Error", xhr);
                        showAlertModal("error", "Something went wrong during final submission.");
                    }
                });
            }

            // Start the validation process
            validateSteps();
        })

        $(".nexttab").on("click", function (e) {
            e.preventDefault();

            const nextButton = $(this);
            const currentPane = $(".tab-pane.show");
            const step = currentPane.attr("id").replace("pills-", "");

            const formData = new FormData();

            if (step === "speaker-evaluation") {
                // Manually append each field (or dynamically if needed)
                // formData.append("first_name", $("#firs   t_name").val() || '');

                const knowledge_score = $('input[name="knowledge_score"]:checked').val() || "";
                const teaching_method_score = $('input[name="teaching_method_score"]:checked').val() || "";
                const audiovisual_score = $('input[name="audiovisual_score"]:checked').val() || "";
                const clarity_score = $('input[name="clarity_score"]:checked').val() || "";
                const question_handling_score = $('input[name="question_handling_score"]:checked').val() || "";
                const audience_connection_score = $('input[name="audience_connection_score"]:checked').val() || "";
                const content_relevance_score = $('input[name="content_relevance_score"]:checked').val() || "";
                const goal_achievement_score = $('input[name="goal_achievement_score"]:checked').val() || "";

                formData.append("knowledge_score", knowledge_score);
                formData.append("teaching_method_score", teaching_method_score);
                formData.append("audiovisual_score", audiovisual_score);
                formData.append("clarity_score", clarity_score);
                formData.append("question_handling_score", question_handling_score);
                formData.append("audience_connection_score", audience_connection_score);
                formData.append("content_relevance_score", content_relevance_score);
                formData.append("goal_achievement_score", goal_achievement_score);
                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "evaluation-personal-info") {
                formData.append("first_name", $("#first_name").val() || '');
                formData.append("middle_name", $("#middle_name").val() || '');
                formData.append("last_name", $("#last_name").val() || '');
                formData.append("suffix", $("#suffix").val() || '');
                formData.append("age_group", $("#age_group").val() || '');
                formData.append("gender", $("#gender").val() || '');

                const isPwd = $('input[name="is_pwd"]:checked').val();
                const disability_type = $("#disability_type").val() || '';
                formData.append("is_pwd", isPwd);
                formData.append("disability_type", isPwd === "1" ? disability_type : ""); // Send empty string if No

                const isIndigenous = $('input[name="is_indigenous"]:checked').val();
                const tribeName = $("#tribe_name").val() || '';

                formData.append("is_indigenous", isIndigenous);
                formData.append("tribe_name", $("#tribe_name").val() || '');

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
                url: "{{ route('speaker-eval.validateStep') }}",
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


        // Prevent enter key from submitting the entire form
        $(".form-steps").on("submit", function (e) {
            e.preventDefault();
        });
    })

    $(document).ready(function () {
        // Handle the Edit button click
        $(document).on("click", ".status-activate", function () {
            // Get data from the button attributes
            let userId = $(this).data("id");

            // Populate the modal fields
            $("#unarchive-edit-id").val(userId);

            // Show the modal
            $("#unarchiveTopicModal").modal("show");
        });

        $("#activateTopicForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let topicId = $("#unarchive-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            let speakerId = $("#speaker_id").val();
            $.ajax({
                url: "/admin/speaker-management/" + speakerId + "/topics/" + topicId + "/unarchive",
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#topics").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#unarchiveTopicModal").modal("hide");
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
            let topicId = $(this).data("id");

            // Populate the modal fields
            $("#archive-edit-id").val(topicId);

            // Show the modal
            $("#archiveTopicModal").modal("show");
        });

        $("#archiveTopicForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let topicId = $("#archive-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };
            let speakerId = $("#speaker_id").val();
            $.ajax({
                url: "/admin/speaker-management/" + speakerId + "/topics/" + topicId + "/archive",
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#topics").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#archiveTopicModal").modal("hide"); // Hide modal
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
