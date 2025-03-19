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
                // { data: 'first_name', name: 'first_name' },
                // { data: 'last_name', name: 'last_name' },
                { data: 'email', name: 'email' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                // { data: 'updated_at', name: 'updated_at' },
                // { data: 'created_at', name: 'created_at' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
    });

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
