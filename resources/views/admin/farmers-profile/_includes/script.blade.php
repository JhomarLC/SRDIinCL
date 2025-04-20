<script>
    // VIEW
    $(document).ready(function () {
        $("#farmers").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('farmers-profile.get-index') }}",
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'phone_number', name: 'phone_number' },
                { data: 'gender', name: 'gender' },
                { data: 'civil_status', name: 'civil_status' },
                { data: 'address', name: 'address' },
                { data: 'actions', name: 'actions' }
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

        // ADDRESS
        $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let provinceDropdown = $("#ts_province");
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
        $("#ts_province").change(function () {
            let provinceCode = $(this).val();
            $("#ts_municipality").prop("disabled", false).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#ts_barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let municipalityDropdown = $("#ts_municipality");
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

        $("#ts_municipality").change(function () {
            let municipalityCode = $(this).val();
            $("#ts_barangay").prop("disabled", false).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`, // FIXED URL
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let barangayDropdown = $("#ts_barangay");
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

    // UPDATE STEP 1
    $(document).ready(function () {
        // ADDRESS
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

        // Load municipalities based on selected province
        $("#update_province").change(function () {
            let provinceCode = $(this).val();
            $("#update_municipality").prop("disabled", false).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#update_barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let municipalityDropdown = $("#update_municipality");
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

        $("#update_municipality").change(function () {
            let municipalityCode = $(this).val();
            $("#update_barangay").prop("disabled", false).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`, // FIXED URL
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let barangayDropdown = $("#update_barangay");
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
    // UPDATE STEP 6
    $(document).ready(function () {
        // ADDRESS
        $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let provinceDropdown = $("#update_ts_province");
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
        $("#update_ts_province").change(function () {
            let provinceCode = $(this).val();
            $("#update_ts_municipality").prop("disabled", false).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#update_ts_barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let municipalityDropdown = $("#update_ts_municipality");
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

        $("#update_ts_municipality").change(function () {
            let municipalityCode = $(this).val();
            $("#update_ts_barangay").prop("disabled", false).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`, // FIXED URL
                method: "GET",
                dataType: "json",
                success: function (data) {
                    let barangayDropdown = $("#update_ts_barangay");
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
        // Pass the values from Blade to JavaScript
        let provinceCode = "{{ $participant->province_code ?? '' }}";
        let municipalityCode = "{{ $participant->municipality_code  ?? '' }}";
        let barangayCode = "{{ $participant->barangay_code ?? '' }}";

        $("#update_province").html('<option>Loading...</option>').prop("disabled", true);
        $("#update_municipality").html('<option>Loading...</option>').prop("disabled", true);
        $("#update_barangay").html('<option>Loading...</option>').prop("disabled", true);

        // Pass the values from Blade to JavaScript
        let tsprovinceCode = "{{ $participant->training_results->ts_province_code ?? '' }}";
        let tsmunicipalityCode = "{{ $participant->training_results->ts_municipality_code  ?? '' }}";
        let tsbarangayCode = "{{ $participant->training_results->ts_barangay_code ?? '' }}";

        $("#update_ts_province").html('<option>Loading...</option>').prop("disabled", true);
        $("#update_ts_municipality").html('<option>Loading...</option>').prop("disabled", true);
        $("#update_ts_barangay").html('<option>Loading...</option>').prop("disabled", true);

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

                    // ✅ Load Municipality after Province is Selected
                    $.ajax({
                        url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`,
                        method: "GET",
                        dataType: "json",
                        success: function (data) {
                            $("#update_municipality").empty().append('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>').prop("disabled", false);
                            data.forEach(municipality => {
                                $("#update_municipality").append(`<option value="${municipality.code}">${municipality.name}</option>`);
                            });

                            if (municipalityCode) {
                                $("#update_municipality").val(municipalityCode).trigger("change");

                                // ✅ Load Barangay after Municipality is Selected
                                $.ajax({
                                    url: `https://psgc.gitlab.io/api/cities-municipalities/${municipalityCode}/barangays/`,
                                    method: "GET",
                                    dataType: "json",
                                    success: function (data) {
                                        $("#update_barangay").empty().append('<option selected disabled hidden>-- SELECT BARANGAY --</option>').prop("disabled", false);
                                        data.forEach(barangay => {
                                            $("#update_barangay").append(`<option value="${barangay.code}">${barangay.name}</option>`);
                                        });

                                        if (barangayCode) {
                                            $("#update_barangay").val(barangayCode).trigger("change");
                                        }
                                    },
                                    error: function () {
                                        console.error("Failed to load barangays.");
                                    }
                                });
                            }
                        },
                        error: function () {
                            console.error("Failed to load municipalities.");
                        }
                    });
                }
            },
            error: function () {
                console.error("Failed to load provinces.");
            }
        });

        // ✅ Load Province after Region is Selected
        $.ajax({
            url: `https://psgc.gitlab.io/api/provinces/`,
            method: "GET",
            dataType: "json",
            success: function (data) {
                $("#update_ts_province").empty().append('<option selected disabled hidden>-- SELECT PROVINCE --</option>').prop("disabled", false);
                data.forEach(province => {
                    $("#update_ts_province").append(`<option value="${province.code}">${province.name}</option>`);
                });

                if (tsprovinceCode) {
                    $("#update_ts_province").val(tsprovinceCode).trigger("change");

                    // ✅ Load Municipality after Province is Selected
                    $.ajax({
                        url: `https://psgc.gitlab.io/api/provinces/${tsprovinceCode}/cities-municipalities/`,
                        method: "GET",
                        dataType: "json",
                        success: function (data) {
                            $("#update_ts_municipality").empty().append('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>').prop("disabled", false);
                            data.forEach(municipality => {
                                $("#update_ts_municipality").append(`<option value="${municipality.code}">${municipality.name}</option>`);
                            });

                            if (tsmunicipalityCode) {
                                $("#update_ts_municipality").val(tsmunicipalityCode).trigger("change");

                                // ✅ Load Barangay after Municipality is Selected
                                $.ajax({
                                    url: `https://psgc.gitlab.io/api/cities-municipalities/${tsmunicipalityCode}/barangays/`,
                                    method: "GET",
                                    dataType: "json",
                                    success: function (data) {
                                        $("#update_ts_barangay").empty().append('<option selected disabled hidden>-- SELECT BARANGAY --</option>').prop("disabled", false);
                                        data.forEach(barangay => {
                                            $("#update_ts_barangay").append(`<option value="${barangay.code}">${barangay.name}</option>`);
                                        });

                                        if (tsbarangayCode) {
                                            $("#update_ts_barangay").val(tsbarangayCode).trigger("change");
                                        }
                                    },
                                    error: function () {
                                        console.error("Failed to load barangays.");
                                    }
                                });
                            }
                        },
                        error: function () {
                            console.error("Failed to load municipalities.");
                        }
                    });
                }
            },
            error: function () {
                console.error("Failed to load provinces.");
            }
        });

        const form = $(".form-steps");
        // Clear error state on input change or typing
        form.on("input change", "input, select, textarea", function () {
            $(this).removeClass("is-invalid");
            $(this).siblings(".invalid-feedback").text("");
        });

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
                    url: "{{ route('participant.validateAll') }}", // You can also use route('participant.validateStep') in sequence
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
                if ($(this).closest('.training-entry').length > 0) return;
                fullFormData.append(name, $(this).val() || '');
            });

            // Handle training entries again
            $('#trainingContainer .training-entry').each(function (index) {
                const $entry = $(this);
                fullFormData.set(`training_title[${index}]`, $entry.find(`input[name="training_title[${index}]"]`).val() || '');
                fullFormData.set(`training_date[${index}]`, $entry.find(`input[name="training_date[${index}]"]`).val() || '');
                fullFormData.set(`conducted_by[${index}]`, $entry.find(`input[name="conducted_by[${index}]"]`).val() || '');
                fullFormData.set(`personally_paid[${index}]`, $entry.find(`input[name="personally_paid[${index}]"]:checked`).val() || '');
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
                    hideLoader();
                    console.error("❌ Final Submission Error", xhr);
                    showAlertModal("error", "Something went wrong during final submission.");
                },
                complete: function () {
                    hideLoader(); // Always hide when done
                }
            });
        }

        $("#submitFarmersProfile").on("click", function (e) {
            e.preventDefault();

            showLoader("Validating...");

            const steps = [
                "personal-info",
                "trainings",
                "other-info",
                "data-ricefarming",
                "emergency-contact",
                "training-result"
            ];

            const formData1 = new FormData();

            const stepForms = {
                "personal-info": () => {
                     // Manually append each field (or dynamically if needed)
                    formData1.append("first_name", $("#first_name").val() || '');
                    formData1.append("middle_name", $("#middle_name").val() || '');
                    formData1.append("last_name", $("#last_name").val() || '');
                    formData1.append("suffix", $("#suffix").val() || '');
                    formData1.append("nickname", $("#nickname").val() || '');
                    formData1.append("birth_date", $("#birth_date").val() || '');
                    formData1.append("age", $("#age").val() || '');
                    formData1.append("age_group", $("#age_group").val() || '');
                    formData1.append("gender", $("#gender").val() || '');
                    formData1.append("civil_status", $("#civil_status").val() || '');
                    formData1.append("religion", $("#religion").val() || '');
                    formData1.append("phone_number", $("#phone_number").val() || '');
                    formData1.append("education_level", $("#education_level").val() || '');

                    const isPwd = $('input[name="is_pwd"]:checked').val();
                    const disability_type = $("#disability_type").val() || '';
                    formData1.append("is_pwd", isPwd);
                    formData1.append("disability_type", isPwd === "1" ? disability_type : ""); // Send empty string if No

                    const isIndigenous = $('input[name="is_indigenous"]:checked').val();
                    const tribeName = $("#tribe_name").val() || '';

                    formData1.append("is_indigenous", isIndigenous);
                    formData1.append("tribe_name", $("#tribe_name").val() || '');

                    let provinceCode = $("#province").val() || $("#update_province").val() || '';
                    let municipalityCode = $("#municipality").val() || $("#update_municipality").val() || '';
                    let barangayCode = $("#barangay").val() || $("#update_barangay").val() || '';

                    // Appending the values to formData
                    formData1.append("province_code", provinceCode);
                    formData1.append("municipality_code", municipalityCode);
                    formData1.append("barangay_code", barangayCode);

                    formData1.append("house_number_sitio_purok", $("#house_number_sitio_purok").val() || '');
                    formData1.append("zip_code", $("#zip_code").val() || '');
                    formData1.append("primary_sector", $("#primary_sector").val() || '');
                    formData1.append("years_in_farming", $("#years_in_farming").val() || '');
                    formData1.append("farmer_association", $("#farmer_association").val() || '');
                    formData1.append("farm_role", $("#farm_role").val() || '');
                    formData1.append("rsbsa_number", $("#rsbsa_number").val() || '');

                    formData1.append("is_pwd", $('input[name="is_pwd"]:checked').val() || '');
                    formData1.append("is_indigenous", $('input[name="is_indigenous"]:checked').val() || '');

                },
                "trainings": () => {
                    $("#trainingContainer .training-entry").each(function (index) {
                        const title = $(this).find('[name^="training_title"]').val();
                        const year = $(this).find('[name^="training_year"]').val();
                        const conductedBy = $(this).find('[name^="conducted_by"]').val();
                        const paid = $(this).find(`input[name="personally_paid[${index}]"]:checked`).val() || '';

                        formData1.append(`training_title[${index}]`, title || '');
                        formData1.append(`training_year[${index}]`, year || '');
                        formData1.append(`conducted_by[${index}]`, conductedBy || '');
                        formData1.append(`personally_paid[${index}]`, paid || '');
                    });

                },
                "other-info": () => {
                    formData1.append("food_restriction", $("#food_restriction").val() || '');
                    formData1.append("medical_condition", $("#medical_condition").val() || '');
                },
                "data-ricefarming": () => {
                    const entries = [0, 1]; // or dynamic
                    entries.forEach(index => {
                        const season = $(`input[name="season[${index}]"]:checked`).val();
                        const yearConducted = $(`#year_training_conducted${index}`).val() || '';
                        const farmSize = $(`#farm_size_hectares${index}`).val() || '';
                        const totalYield = $(`#total_yield_caban${index}`).val() || '';
                        const weightPerCaban = $(`#weight_per_caban_kg${index}`).val() || '';
                        const pricePerKg = $(`#price_per_kg${index}`).val() || '';
                        const totalIncome = $(`#total_income${index}`).val() || '';
                        const totalCost = $(`#total_cost${index}`).val() || '';
                        const otherCrops = $(`#other_crops${index}`).val() || '';

                        formData1.append(`season[${index}]`, season || '');
                        formData1.append(`year_training_conducted[${index}]`, yearConducted);
                        formData1.append(`farm_size_hectares[${index}]`, farmSize);
                        formData1.append(`total_yield_caban[${index}]`, totalYield);
                        formData1.append(`weight_per_caban_kg[${index}]`, weightPerCaban);
                        formData1.append(`price_per_kg[${index}]`, pricePerKg);
                        formData1.append(`total_income[${index}]`, totalIncome);
                        formData1.append(`total_cost[${index}]`, totalCost);
                        formData1.append(`other_crops[${index}]`, otherCrops);
                    });
                },
                "emergency-contact": () => {
                    // Manually append each field (or dynamically if needed)
                    formData1.append("ec_first_name", $("#ec_first_name").val() || '');
                    formData1.append("ec_middle_name", $("#ec_middle_name").val() || '');
                    formData1.append("ec_last_name", $("#ec_last_name").val() || '');
                    formData1.append("ec_suffix", $("#ec_suffix").val() || '');
                    formData1.append("ec_relationship", $("#ec_relationship").val() || '');
                    formData1.append("ec_contact_number", $("#ec_contact_number").val() || '');
                },
                "training-result": () => {
                    // Manually append each field (or dynamically if needed)
                    formData1.append("training_title_main", $("#training_title_main").val() || '');
                    formData1.append("training_date_main", $("#training_date_main").val() || '');

                    let tsprovinceCode = $("#ts_province").val() || $("#update_province").val() || '';
                    let tsmunicipalityCode = $("#ts_municipality").val() || $("#update_municipality").val() || '';
                    let tsbarangayCode = $("#ts_barangay").val() || $("#update_barangay").val() || '';

                    // Appending the values to formData
                    formData1.append("ts_province_code", tsprovinceCode);
                    formData1.append("ts_municipality_code",tsmunicipalityCode);
                    formData1.append("ts_barangay_code", tsbarangayCode);

                    formData1.append("pre_test_score", $("#pre_test_score").val() || '');
                    formData1.append("post_test_score", $("#post_test_score").val() || '');
                    formData1.append("total_test_items", $("#total_test_items").val() || '');
                    formData1.append("gain_in_knowledge", $("#gain_in_knowledge").val() || '');
                    formData1.append("certificate_type", $("#certificate_type").val() || '');
                    formData1.append("certificate_number", $("#certificate_number").val() || '');
                    // formData1.append("overall_training_eval_score", $("#overall_training_eval_score").val() || '');
                    // formData1.append("trainer_rating", $("#trainer_rating").val() || '');
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
                            url: "{{ route('participant.validateStep') }}",
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
                const disability_type = $("#disability_type").val() || '';
                formData.append("is_pwd", isPwd);
                formData.append("disability_type", isPwd === "1" ? disability_type : ""); // Send empty string if No

                const isIndigenous = $('input[name="is_indigenous"]:checked').val();
                const tribeName = $("#tribe_name").val() || '';

                formData.append("is_indigenous", isIndigenous);
                formData.append("tribe_name", $("#tribe_name").val() || '');

                let provinceCode = $("#province").val() || $("#update_province").val() || '';
                let municipalityCode = $("#municipality").val() || $("#update_municipality").val() || '';
                let barangayCode = $("#barangay").val() || $("#update_barangay").val() || '';

                // Appending the values to formData
                formData.append("province_code", provinceCode);
                formData.append("municipality_code", municipalityCode);
                formData.append("barangay_code", barangayCode);

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
                    const paid = $(this).find(`input[name="personally_paid[${index}]"]:checked`).val() || '';

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

            if (step === "data-ricefarming") {
                // Loop through each record (you have two by default)
                const entries = [0, 1]; // add more indices if needed for dynamic rows

                entries.forEach(index => {
                    const season = $(`input[name="season[${index}]"]:checked`).val();
                    const yearConducted = $(`#year_training_conducted${index}`).val() || '';
                    const farmSize = $(`#farm_size_hectares${index}`).val() || '';
                    const totalYield = $(`#total_yield_caban${index}`).val() || '';
                    const weightPerCaban = $(`#weight_per_caban_kg${index}`).val() || '';
                    const pricePerKg = $(`#price_per_kg${index}`).val() || '';
                    const totalIncome = $(`#total_income${index}`).val() || '';
                    const totalCost = $(`#total_cost${index}`).val() || '';
                    const otherCrops = $(`#other_crops${index}`).val() || '';

                    formData.append(`season[${index}]`, season || '');
                    formData.append(`year_training_conducted[${index}]`, yearConducted);
                    formData.append(`farm_size_hectares[${index}]`, farmSize);
                    formData.append(`total_yield_caban[${index}]`, totalYield);
                    formData.append(`weight_per_caban_kg[${index}]`, weightPerCaban);
                    formData.append(`price_per_kg[${index}]`, pricePerKg);
                    formData.append(`total_income[${index}]`, totalIncome);
                    formData.append(`total_cost[${index}]`, totalCost);
                    formData.append(`other_crops[${index}]`, otherCrops);
                });

                formData.append("step", step);

                console.log("🧾 Rice Farming FormData:");
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
                formData.append("training_title_main", $("#training_title_main").val() || '');
                formData.append("training_date_main", $("#training_date_main").val() || '');

                let tsprovinceCode = $("#ts_province").val() || $("#update_province").val() || '';
                let tsmunicipalityCode = $("#ts_municipality").val() || $("#update_municipality").val() || '';
                let tsbarangayCode = $("#ts_barangay").val() || $("#update_barangay").val() || '';

                // Appending the values to formData
                formData.append("ts_province_code", tsprovinceCode);
                formData.append("ts_municipality_code",tsmunicipalityCode);
                formData.append("ts_barangay_code", tsbarangayCode);

                formData.append("pre_test_score", $("#pre_test_score").val() || '');
                formData.append("post_test_score", $("#post_test_score").val() || '');
                formData.append("total_test_items", $("#total_test_items").val() || '');
                formData.append("gain_in_knowledge", $("#gain_in_knowledge").val() || '');
                formData.append("certificate_type", $("#certificate_type").val() || '');
                formData.append("certificate_number", $("#certificate_number").val() || '');
                // formData.append("overall_training_eval_score", $("#overall_training_eval_score").val() || '');
                // formData.append("trainer_rating", $("#trainer_rating").val() || '');

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
            const selectedValue = $select.data('selected');
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

                // Preselect from server data or fallback to defaults
                if (value == selectedValue ||
                    (!selectedValue && (
                        (!isDry && year === currentYear) ||
                        (isDry && year === currentYear - 1)
                    ))
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

        document.getElementById('gain_in_knowledge_display').value = gik.toFixed(2) + ' %';
        document.getElementById('gain_in_knowledge').value = gik.toFixed(2);
    });

    // Clear fields functionality
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('clear-training')) {
            let index = event.target.getAttribute('data-index');
            // Find the training entry corresponding to this button and clear its fields
            let entry = document.querySelector(`.training-entry:nth-child(${parseInt(index) + 1})`);
            let inputs = entry.querySelectorAll('input');

            inputs.forEach(input => {
                if (input.type === 'radio') {
                    // Uncheck the radio buttons
                    input.checked = false;
                } else {
                    // Clear the value for text and date inputs
                    input.value = '';
                }
            });
        }
    });
</script>
