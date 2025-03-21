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

        $(".nexttab").on("click", function (e) {
            e.preventDefault();

            const nextButton = $(this);
            const currentPane = $(".tab-pane.show");
            const step = currentPane.attr("id").replace("pills-", "");

            const formData = new FormData();

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
                        $("#" + nextTabId).click();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        console.warn("❌ Validation Errors:", errors);

                        // Remove existing error states
                        currentPane.find(".is-invalid").removeClass("is-invalid");

                        $.each(errors, function (key, messages) {
                            const input = currentPane.find(`[name="${key}"]`);
                            input.addClass("is-invalid");
                            input.siblings(".invalid-feedback").text(messages[0]);
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
        $("button[data-bs-toggle='pill']").on("click", function () {
            const button = $(this);
            const index = button.data("position");
            const totalTabs = $(".custom-nav li").length - 1;

            const percent = (index / totalTabs) * 100;
            $("#custom-progress-bar .progress-bar").css("width", percent + "%");

            $(".custom-nav .done").removeClass("done");
            $(".custom-nav button").each(function (i) {
                if (i <= index) {
                    $(this).addClass("done");
                }
            });

            form.removeClass("was-validated");
        });

        // Prevent enter key from submitting the entire form
        $(".form-steps").on("submit", function (e) {
            e.preventDefault();
        });
    });
</script>
