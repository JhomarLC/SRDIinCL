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
        $('.select2').select2({
            dropdownParent: $('#addnewaewmodal') // Ensures Select2 dropdown stays inside the modal
        });
        $('.select2').select2({
            dropdownParent: $('#editAEWModal') // Ensures Select2 dropdown stays inside the modal
        });
        flatpickr("#start_date", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
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

            console.log(start_date);

            // Populate the modal fields
            $("#edit_id").val(userId);
            $("#update_first_name").val(firstName);
            $("#update_middle_name").val(middleName);
            $("#update_last_name").val(lastName);
            $("#update_suffix").val(suffix);
            $("#update_email").val(email);
            $("#update_contact_number").val(contact_number);
            // Set values for Flatpickr
            if (start_date) {
                flatpickrStart.setDate(start_date, true);
            } else {
                flatpickrStart.clear(); // Clear if no date
            }

            $("#update_position_id").val(positionId).trigger('change');
            $("#update_employment_type_id").val(employment_typeId).trigger('change');

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

            console.log(formData);

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
