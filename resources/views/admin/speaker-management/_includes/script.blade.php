<script>
    // VIEW
    $(document).ready(function () {
        $("#speakers").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('speaker-management.get-index') }}",
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'training_title', name: 'training_title' },
                { data: 'total_rating', name: 'total_rating' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });

    // CREATE
    $(document).ready(function () {
        $('#createSpeakerForm').submit(function (e) {
            e.preventDefault();

            // Clear previous errors
            $('.form-control').removeClass('is-invalid'); // Remove red borders
            $('.invalid-feedback').text(''); // Clear error messages

            let formData = {
                first_name: $('#first_name').val(),
                middle_name: $('#middle_name').val(),
                last_name: $('#last_name').val(),
                suffix: $('#suffix').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('speaker-management.store') }}", // Laravel route for storing speaker
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $('#addnewspeakermodal').modal('hide'); // Hide modal
                        $('#createSpeakerForm')[0].reset(); // Reset form
                        $('#speakers').DataTable().ajax.reload(); // Reload DataTable
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
        $(document).on("click", ".editSpeaker", function () {
            // Remove error messages on input change
            $(".form-control").removeClass("is-invalid"); // Remove all error borders
            $(".error-message").text(""); // Clear all error messages

            // Get data from the button attributes
            let userId = $(this).data("id");
            let firstName = $(this).data("first_name");
            let middleName = $(this).data("middle_name");
            let lastName = $(this).data("last_name");
            let suffix = $(this).data("suffix");

            // Populate the modal fields
            $("#edit_id").val(userId);
            $("#update_first_name").val(firstName);
            $("#update_middle_name").val(middleName);
            $("#update_last_name").val(lastName);
            $("#update_suffix").val(suffix);

            // Show the modal
            $("#editSpeakerModal").modal("show");
        });

        $("#updateSpeakerForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#edit_id").val(); // Get the admin ID

            let formData = {
                first_name: $("#update_first_name").val(),
                middle_name: $("#update_middle_name").val(),
                last_name: $("#update_last_name").val(),
                suffix: $("#update_suffix").val(),
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF Token
            };

            $.ajax({
                url: "/admin/speaker-management/" + userId, // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#editSpeakerModal").modal("hide"); // Hide modal
                        $('#updateSpeakerForm')[0].reset(); // Reset form
                        $("#speakers").DataTable().ajax.reload(); // Reload DataTable
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
            $("#unarchive-edit-id").val(userId);

            // Show the modal
            $("#unarchiveAccountModal").modal("show");
        });

        $("#activateAdminForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#unarchive-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/speaker-management/" + userId + "/unarchive", // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#speakers").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#unarchiveAccountModal").modal("hide");
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
            let userId = $(this).data("id");

            // Populate the modal fields
            $("#archive-edit-id").val(userId);

            // Show the modal
            $("#archiveAccountModal").modal("show");
        });

        $("#archiveAdminForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let userId = $("#archive-edit-id").val(); // Get the admin ID

            let formData = {
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "/admin/speaker-management/" + userId + "/archive", // Laravel route for updating admin
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#speakers").DataTable().ajax.reload(); // Reload DataTable
                    }
                    $("#archiveAccountModal").modal("hide"); // Hide modal
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
