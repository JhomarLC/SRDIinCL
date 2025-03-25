<script>
    // VIEW
    $(document).ready(function () {
        $('.select2').select2();
        $("#admins").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin-management.get-index') }}",
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false },

                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });

    $(document).ready(function () {
        $('.select2').select2();

    });

    document.addEventListener('DOMContentLoaded', function () {
        const birthDateInput = document.getElementById('birth_date');
        const ageInput = document.getElementById('age_label');
        const ageGroupInput = document.getElementById('age_group');
        const calculatedAgeInput = document.getElementById('age');

        const today = new Date().toISOString().split('T')[0];
        birthDateInput.setAttribute('max', today); // prevent future dates

        birthDateInput.addEventListener('change', function () {
            const birthDate = new Date(this.value);
            const now = new Date();

             // Reset class first
            birthDateInput.classList.remove('is-invalid');

            if (!this.value || birthDate > now || isNaN(birthDate)) {
                birthDateInput.classList.add('is-invalid');
                birthDateInput.value = '';
                ageInput.value = '';
                ageGroupInput.value = '';
                calculatedAgeInput.value = '';
                return;
            }

            let age = now.getFullYear() - birthDate.getFullYear();
            const monthDiff = now.getMonth() - birthDate.getMonth();
            const dayDiff = now.getDate() - birthDate.getDate();

            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            // Show age in disabled field
            ageInput.value = age + ' years old';
            calculatedAgeInput.value = age;

            // Determine age group
            let group = '';
            if (age <= 18) group = '18 below';
            else if (age <= 30) group = '18-30';
            else if (age <= 45) group = '31-45';
            else if (age <= 59) group = '46-59';
            else group = '60 and above';

            ageGroupInput.value = group;
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
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

        $("#municipality").change(function () {
            let municipalityCode = $(this).val();
            $("#barangay").prop("disabled", false).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`, // FIXED URL
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let barangayDropdown = $("#barangay");
                    let barangaysArray = Object.values(data); // Convert object to array if needed

                    barangaysArray.forEach(barangay => {
                        barangayDropdown.append(
                            `<option value="${barangay.code}">${barangay.name}</option>`
                        );
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Failed to load barangays:", error);
                }
            });
        });

    });

    $(document).ready(function () {
        const form = $(".form-steps");
        // Clear error state on input change or typing
        form.on("input change", "input, select, textarea", function () {
            $(this).removeClass("is-invalid");
            $(this).siblings(".invalid-feedback").text("");
        });

        $('input[name="is_pwd"]').on("change", function () {
            if ($(this).val() === "1") {
                $('#disability').prop('disabled', false);
            } else {
                $('#disability').prop('disabled', true).val('');
                $('#disability').removeClass("is-invalid").siblings(".invalid-feedback").text('');
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

        $(".nexttab").on("click", function (e) {
            e.preventDefault();

            const nextButton = $(this);
            const currentPane = $(".tab-pane.show");
            const step = currentPane.attr("id").replace("pills-", "");

            const formData = new FormData();
            if (step === "personal-info") {
                // Manually append each field (or dynamically if needed)
                formData.append("first_name", $("#first_name").val() || '');
                formData.append("middle_name", $("#middle_name").val() || '');
                formData.append("last_name", $("#last_name").val() || '');
                formData.append("suffix", $("#suffix").val() || '');
                formData.append("nickname", $("#nickname").val() || '');
                formData.append("birth_date", $("#birth_date").val() || '');
                formData.append("age", $("#age").val() || '');
                formData.append("age_group", $("#age_group").val() || '');
                formData.append("gender", $("#gender").val() || '');
                formData.append("civil_status", $("#civil_status").val() || '');
                formData.append("religion", $("#religion").val() || '');
                formData.append("phone_number", $("#phone_number").val() || '');
                formData.append("education_level", $("#education_level").val() || '');

                const isPwd = $('input[name="is_pwd"]:checked').val();
                const disability = $("#disability").val() || '';
                formData.append("is_pwd", isPwd);
                formData.append("disability", isPwd === "1" ? disability : ""); // Send empty string if No

                const isIndigenous = $('input[name="is_indigenous"]:checked').val();
                const tribeName = $("#tribe_name").val() || '';

                formData.append("is_indigenous", isIndigenous);
                formData.append("tribe_name", $("#tribe_name").val() || '');

                formData.append("province", $("#province").val() || '');
                formData.append("municipality", $("#municipality").val() || '');
                formData.append("barangay", $("#barangay").val() || '');
                formData.append("house_number_sitio_purok", $("#house_number_sitio_purok").val() || '');
                formData.append("zip_code", $("#zip_code").val() || '');
                formData.append("primary_sector", $("#primary_sector").val() || '');
                formData.append("years_in_farming", $("#years_in_farming").val() || '');
                formData.append("farmer_association", $("#farmer_association").val() || '');
                formData.append("farm_role", $("#farm_role").val() || '');
                formData.append("rsbsa_number", $("#rsbsa_number").val() || '');

                formData.append("is_pwd", $('input[name="is_pwd"]:checked').val() || '');
                formData.append("is_indigenous", $('input[name="is_indigenous"]:checked').val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "trainings") {
                $("#trainingContainer .training-entry").each(function (index) {
                    const title = $(this).find('[name^="training_title"]').val();
                    const year = $(this).find('[name^="training_year"]').val();
                    const conductedBy = $(this).find('[name^="conducted_by"]').val();
                    const paid = $(this).find(`input[name="personally_paid[${index}]"]:checked`).val();

                    formData.append(`training_title[${index}]`, title || '');
                    formData.append(`training_year[${index}]`, year || '');
                    formData.append(`conducted_by[${index}]`, conductedBy || '');
                    formData.append(`personally_paid[${index}]`, paid || '');
                });

                formData.append("step", step);
                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "other-info") {
                // Manually append each field (or dynamically if needed)
                formData.append("food_restriction", $("#food_restriction").val() || '');
                formData.append("medical_condition", $("#medical_condition").val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "emergency-contact") {
                // Manually append each field (or dynamically if needed)
                formData.append("ec_first_name", $("#ec_first_name").val() || '');
                formData.append("ec_middle_name", $("#ec_middle_name").val() || '');
                formData.append("ec_last_name", $("#ec_last_name").val() || '');
                formData.append("ec_suffix", $("#ec_suffix").val() || '');
                formData.append("ec_relationship", $("#ec_relationship").val() || '');
                formData.append("ec_contact_number", $("#ec_contact_number").val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            if (step === "training-result") {
                // Manually append each field (or dynamically if needed)
                formData.append("pre_test_score", $("#pre_test_score").val() || '');
                formData.append("post_test_score", $("#post_test_score").val() || '');
                formData.append("total_test_items", $("#total_test_items").val() || '');
                formData.append("gain_in_knowledge", $("#gain_in_knowledge").val() || '');
                formData.append("certificate_type", $("#certificate_type").val() || '');
                formData.append("certificate_number", $("#certificate_number").val() || '');
                formData.append("overall_training_eval_score", $("#overall_training_eval_score").val() || '');
                formData.append("trainer_rating", $("#trainer_rating").val() || '');

                formData.append("step", step);

                console.log("🧾 FormData being sent:");
                for (const pair of formData.entries()) {
                    console.log(`${pair[0]}: ${pair[1]}`);
                }
            }

            $.ajax({
                url: "{{ route('participant.validateStep') }}",
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
                            }
                        });

                        // $.each(errors, function (key, messages) {
                        //     const input = currentPane.find(`[name="${key}"]`);
                        //     input.addClass("is-invalid");
                        //     input.siblings(".invalid-feedback").text(messages[0]);
                        // });
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
    });

    $(document).ready(function () {
        initializeSelect2();

        $('#addTrainingBtn').on('click', function () {
            let $firstEntry = $('.training-entry').first();

            // Destroy Select2 before cloning
            $firstEntry.find('.select2').each(function () {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });

            let $clone = $firstEntry.clone();

            // 🧠 Get index based on how many training entries currently exist
            let currentIndex = $('.training-entry').length;

            $clone.find('input, select, textarea').each(function () {
                let $input = $(this);
                let name = $input.attr('name');

                if (!name) return; // skip if no name

                let baseName = name.replace(/\[\d+\]/, ''); // e.g. training_title
                let newName = baseName + '[' + currentIndex + ']';

                // Update name
                $input.attr('name', newName);

                // Handle radios separately
                if ($input.is(':radio')) {
                    let value = $input.val();
                    let newId = newName + '_' + value;

                    $input.attr('id', newId);
                    $input.prop('checked', value === 'no');

                    // Update corresponding label's 'for'
                    let $label = $input.next('label');
                    if ($label.length) {
                        $label.attr('for', newId);
                    }
                } else {
                    $input.val(''); // clear value
                    $input.removeClass('is-invalid'); // clear old validation state
                }
            });

            // Show remove button
            $clone.find('.remove-training').removeClass('d-none');

            // Append clone and <hr>
            $('#trainingContainer').append($clone).append('<hr>');

            // Reinitialize Select2
            $clone.find('.select2').select2({
                placeholder: '-- SELECT YEAR --',
                width: '100%'
            });

            $firstEntry.find('.select2').select2({
                placeholder: '-- SELECT YEAR --',
                width: '100%'
            });
        });

        // Remove training
        $('#trainingContainer').on('click', '.remove-training', function () {
            $(this).closest('.training-entry').next('hr').remove();
            $(this).closest('.training-entry').remove();
        });

        function initializeSelect2() {
            $('.select2').select2({
                placeholder: '-- SELECT YEAR --',
                width: '100%'
            });
        }
    });

    $(document).ready(function () {
        const startYear = 2023;
        const currentYear = new Date().getFullYear();

        const yearDropdowns = [
            {
                dryRadio: '#seasonDry0',
                wetRadio: '#seasonWet0',
                select: '#year_training_conducted0'
            },
            {
                dryRadio: '#seasonDry1',
                wetRadio: '#seasonWet1',
                select: '#year_training_conducted1'
            }
        ];

        function populateYears($select, isDry) {
            $select.empty().append('<option disabled hidden>-- SELECT YEAR --</option>');

            for (let year = startYear; year <= currentYear; year++) {
                let label, value;

                if (isDry) {
                    // Prevent future Dry Season (e.g. 2025-2026 if we're in 2025)
                    if ((year + 1) > currentYear) {
                        break; // or use continue if you want to skip instead of stop
                    }
                    value = `${year}-${year + 1}`;
                    label = `${year} - ${year + 1}`;
                } else {
                    value = `${year}`;
                    label = `${year}`;
                }

                let $option = $('<option>', {
                    value: value,
                    text: label
                });

                // Preselect latest valid option
                if (
                    (!isDry && year === currentYear) ||
                    (isDry && year === currentYear - 1)
                ) {
                    $option.prop('selected', true);
                }

                $select.append($option);
            }
        }
        yearDropdowns.forEach(config => {
            const $dryRadio = $(config.dryRadio);
            const $wetRadio = $(config.wetRadio);
            const $select = $(config.select);

            // Initial population based on default selection
            populateYears($select, $dryRadio.is(':checked'));

            // Change events
            $dryRadio.on('change', function () {
                if ($(this).is(':checked')) {
                    populateYears($select, true);
                }
            });

            $wetRadio.on('change', function () {
                if ($(this).is(':checked')) {
                    populateYears($select, false);
                }
            });
        });
    });
    document.addEventListener('input', function () {
        const pre = parseFloat(document.getElementById('pre_test_score').value) || 0;
        const post = parseFloat(document.getElementById('post_test_score').value) || 0;

        let gik = 0;
        if (post > 0) {
            gik = ((post - pre) / post) * 100;
        }

        document.getElementById('gain_in_knowledge').value = gik.toFixed(2) + ' %';
    });
</script>
