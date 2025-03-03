<script>
    // VIEW
    $(document).ready(function () {
        $("#admins").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('admin-management.get-index') }}",
            columns: [
                { data: 'full_name', name: 'full_name' },
                // { data: 'first_name', name: 'first_name' },
                // { data: 'last_name', name: 'last_name' },
                { data: 'suffix', name: 'suffix',  orderable: false, searchable: false },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                // { data: 'updated_at', name: 'updated_at' },
                // { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });

    // CREATE
    $(document).ready(function () {
        $('#createAdminForm').submit(function (e) {
            e.preventDefault();

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
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('admin-management.store') }}", // Laravel route for storing admin
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $('#addnewadminmodal').modal('hide'); // Hide modal
                        $('#createAdminForm')[0].reset(); // Reset form
                        $('#admins').DataTable().ajax.reload(); // Reload DataTable
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
        // Handle the Edit button click
        $(document).on("click", ".editAdmin", function () {
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

            // Populate the modal fields
            $("#edit_id").val(userId);
            $("#update_first_name").val(firstName);
            $("#update_middle_name").val(middleName);
            $("#update_last_name").val(lastName);
            $("#update_suffix").val(suffix);
            $("#update_email").val(email);

            // Show the modal
            $("#editAdminModal").modal("show");
        });

        $("#updateAdminForm").submit(function (e) {
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
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF Token
            };

            $.ajax({
                url: "/admin/admin-management/" + userId, // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#editAdminModal").modal("hide"); // Hide modal
                        $('#updateAdminForm')[0].reset(); // Reset form
                        $("#admins").DataTable().ajax.reload(); // Reload DataTable
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

        $("#activateAdminForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#activate-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/admin-management/" + userId + "/activate", // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#admins").DataTable().ajax.reload(); // Reload DataTable
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

        $("#deactivateAdminForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#deactivate-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/admin-management/" + userId + "/deactivate", // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#admins").DataTable().ajax.reload(); // Reload DataTable
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
