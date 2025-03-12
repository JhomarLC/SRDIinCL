<script>
    // VIEW
    $(document).ready(function () {
        $("#aews").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('aews-management.get-index') }}",
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'email', name: 'email' },
                { data: 'position', name: 'position' },
                { data: 'employment_type', name: 'employment_type' },
                { data: 'contact_number', name: 'contact_number' },
                { data: 'job_status', name: 'job_status' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        $('#addnewaewmodal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });

        $('#editAEWModal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });
        // $('.select2').select2({
        //     dropdownParent: $('#editAEWModal') // Ensures Select2 dropdown stays inside the modal
        // });
        flatpickr("#start_date", {
            maxDate: "today",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
    });


    // Address
    $(document).ready(function () {
        // Load regions on page load
        $.ajax({
            url: "https://psgc.gitlab.io/api/regions/",
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data); // Debugging: Check the structure of the response
                let regionDropdown = $("#region");

                // Convert the object values into an array
                let regionsArray = Object.values(data);

                regionsArray.forEach(region => {
                    regionDropdown.append(
                        `<option value="${region.code}">${region.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Failed to load regions:", error);
            }
        });

        // Load provinces based on selected region
        $("#region").change(function () {
            let regionCode = $(this).val();
            $("#province").prop("disabled", false).html('<option selected disabled hidden>-- SELECT PROVINCE --</option>');
            $("#municipality").prop("disabled", true).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`,
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

    // Address Update
    $(document).ready(function () {
        // Load regions on page load
        $.ajax({
            url: "https://psgc.gitlab.io/api/regions/",
            method: "GET",
            dataType: "json",
            success: function (data) {
                console.log(data); // Debugging: Check the structure of the response
                let regionDropdown = $("#update_region");

                // Convert the object values into an array
                let regionsArray = Object.values(data);

                regionsArray.forEach(region => {
                    regionDropdown.append(
                        `<option value="${region.code}">${region.name}</option>`
                    );
                });
            },
            error: function (xhr, status, error) {
                console.error("Failed to load regions:", error);
            }
        });

        // Load provinces based on selected region
        $("#update_region").change(function () {
            let regionCode = $(this).val();
            $("#update_province").prop("disabled", false).html('<option selected disabled hidden>-- SELECT PROVINCE --</option>');
            $("#update_municipality").prop("disabled", true).html('<option selected disabled hidden>-- SELECT MUNICIPALITY --</option>');
            $("#update_barangay").prop("disabled", true).html('<option selected disabled hidden>-- SELECT BARANGAY --</option>');

            $.ajax({
                url: `https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`,
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

    // CREATE
    $(document).ready(function () {
        $('#createAEWForm').submit(function (e) {
            e.preventDefault();
            // Store Flatpickr instances for Edit Modal

            // Clear previous errors
            $('.form-control').removeClass('is-invalid'); // Remove red borders
            $('.invalid-feedback').text(''); // Clear error messages

            let formData = {
                first_name: $('#first_name').val(),
                middle_name: $('#middle_name').val(),
                last_name: $('#last_name').val(),
                suffix: $('#suffix').val(),
                email: $('#email').val(),
                password: $('#password').val(),
                password_confirmation: $('#password_confirmation').val(),

                region: $('#region').val(),
                province: $('#province').val(),
                municipality: $('#municipality').val(),
                barangay: $('#barangay').val(),

                position_id: $('#position_id').val(),
                employment_type_id: $('#employment_type_id').val(),
                contact_number: $('#contact_number').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('aews-management.store') }}", // Laravel route for storing admin
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $('#addnewaewmodal').modal('hide'); // Hide modal
                        $('#createAEWForm')[0].reset(); // Reset form
                        // Reset Select2 to the first option
                        $('#position_id, #employment_type_id').each(function () {
                            $(this).val($(this).find('option:first').val()).trigger('change');
                        });
                        // $('#createAEWForm .select2').val(null).trigger('change'); // Reset all Select2
                        $('#aews').DataTable().ajax.reload(); // Reload DataTable
                    }
                    showAlertModal(response.status, response.message);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(errors);
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $('#' + key).addClass('is-invalid'); // Add red border
                            $('#' + key + '_error').text(value); // Display error message
                        });
                    }
                }
            });
        });

        // Remove error message on input
        $('.form-control').on('input', function () {
            $(this).removeClass('is-invalid'); // Remove red border
            $('#' + $(this).attr('id') + '_error').text(''); // Clear error message
        });
    });

    // UPDATE
    $(document).ready(function () {
        let flatpickrStart = flatpickr("#update_start_date", {
            maxDate: "today",
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
        });
        // Handle the Edit button click
        $(document).on("click", ".editAEW", function () {

            // Remove error messages on input change
            $(".form-control").removeClass("is-invalid"); // Remove all error borders
            $(".error-message").text(""); // Clear all error messages

            // Get data from the button attributes
            let userId = $(this).data("id");
            let firstName = $(this).data("first_name");
            let middleName = $(this).data("middle_name");
            let lastName = $(this).data("last_name");
            let suffix = $(this).data("suffix");
            let email = $(this).data("email");
            let contact_number = $(this).data("contact_number");
            let start_date = $(this).data('start_date');
            let positionId = $(this).data('position');
            let employment_typeId = $(this).data('employment_type');

            let regionCode = $(this).data("region");
            let provinceCode = $(this).data("province");
            let municipalityCode = $(this).data("municipality");
            let barangayCode = $(this).data("barangay");

            // Populate the modal fields
            $("#edit_id").val(userId);
            $("#update_first_name").val(firstName);
            $("#update_middle_name").val(middleName);
            $("#update_last_name").val(lastName);
            $("#update_suffix").val(suffix);
            $("#update_email").val(email);
            $("#update_contact_number").val(contact_number);

            $("#update_position_id").val(positionId).trigger("change");
            $("#update_employment_type_id").val(employment_typeId).trigger("change");

            // Set values for Flatpickr
            if (start_date) {
                flatpickrStart.setDate(start_date, true);
            } else {
                flatpickrStart.clear(); // Clear if no date
            }
            // Show the modal
            $("#editAEWModal").modal("show");
        });


        $("#updateAEWForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#edit_id").val(); // Get the admin ID

            let formData = {
                first_name: $("#update_first_name").val(),
                middle_name: $("#update_middle_name").val(),
                last_name: $("#update_last_name").val(),
                suffix: $("#update_suffix").val(),
                email: $("#update_email").val(),
                password: $('#update_password').val(),
                password_confirmation: $('#update_password_confirmation').val(),
                position_id: $('#update_position_id').val(),
                employment_type_id: $('#update_employment_type_id').val(),
                contact_number: $('#update_contact_number').val(),
                start_date: $('#update_start_date').val(),
                end_date: $('#update_end_date').val(),
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF Token
            };

            $.ajax({
                url: "/admin/aews-management/" + userId, // Laravel route for updating aew
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#editAEWModal").modal("hide"); // Hide modal
                        $('#updateAEWForm')[0].reset(); // Reset form
                        $("#aews").DataTable().ajax.reload(); // Reload DataTable
                    }
                    showAlertModal(response.status, response.message);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(xhr);

                    $(".form-control").removeClass( "is-invalid"); // Reset error borders
                    $(".invalid-feedback").text(""); // Clear previous errors
                    if (errors) {
                        $.each(errors, function (key, value) {
                            $("#update_" + key).addClass('is-invalid'); // Add red border
                            $('#update_' + key + '_error').text(value); // Display error message
                        });
                    }
                }
            });
        });

        // Remove error messages on input change
        $(".form-control").on("input", function () {
            $(this).removeClass("is-invalid"); // Remove error border
            $("#update" + $(this).attr("id") + "_error").text(""); // Clear error message
        });
    });

    $(document).ready(function () {
        // Handle the Edit button click
        $(document).on("click", ".status-activate", function () {
            // Get data from the button attributes
            let userId = $(this).data("id");

            // Populate the modal fields
            $("#activate-edit-id").val(userId);

            // Show the modal
            $("#activateAccountModal").modal("show");
        });

        $("#activateAEWForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#activate-edit-id").val(); // Get the aews ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/aews-management/" + userId + "/activate", // Laravel route for updating aews
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#aews").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#activateAccountModal").modal("hide");
                    showAlertModal(response.status, response.message);

                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    console.log(xhr);
                }
            });
        });

        // Handle the Edit button click
        $(document).on("click", ".status-deactivate", function () {
            // Get data from the button attributes
            let userId = $(this).data("id");

            // Populate the modal fields
            $("#deactivate-edit-id").val(userId);

            // Show the modal
            $("#deactivateAccountModal").modal("show");
        });

        $("#deactivateAEWForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#deactivate-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/aews-management/" + userId + "/deactivate", // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#aews").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#deactivateAccountModal").modal("hide"); // Hide modal
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
