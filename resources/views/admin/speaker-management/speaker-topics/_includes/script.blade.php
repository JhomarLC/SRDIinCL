<script>
    // VIEW
    $(document).ready(function () {
        $("#topics").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('speaker-topics.get-index', $speaker->id) }}",
            columns: [
                { data: 'topic_discussed', name: 'topic_discussed' },
                { data: 'topic_date', name: 'topic_date' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        $('.select2').select2();
    });

    // CREATE
    $(document).ready(function () {
        $('#createTopicForm').submit(function (e) {
            e.preventDefault();

            // Clear previous errors
            $('.form-control').removeClass('is-invalid'); // Remove red borders
            $('.invalid-feedback').text(''); // Clear error messages

            let formData = {
                topic_discussed: $('#topic_discussed').val(),
                topic_date: $('#topic_date').val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            };

            $.ajax({
                url: "{{ route('speaker-topics.store', $speaker->id) }}", // Laravel route for storing speaker
                type: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $('#addnewtopicmodal').modal('hide'); // Hide modal
                        $('#createTopicForm')[0].reset(); // Reset form
                        $('#topics').DataTable().ajax.reload(); // Reload DataTable
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
        $(document).on("click", ".editTopic", function () {
            // Remove error messages on input change
            $(".form-control").removeClass("is-invalid"); // Remove all error borders
            $(".error-message").text(""); // Clear all error messages

            // Get data from the button attributes
            let topicId = $(this).data("id");
            let topic_discussed = $(this).data("topic_discussed");
            let topic_date = $(this).data("topic_date");

            // Populate the modal fields
            $("#edit_id").val(topicId);
            // $("#update_topic_discussed").val(topic_discussed);
            $("#update_topic_discussed").val(topic_discussed).trigger('change');

            $("#update_topic_date").val(topic_date);

            // Show the modal
            $("#editTopicModal").modal("show");
        });

        $("#updateTopicForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let topicId = $("#edit_id").val(); // Get the admin ID

            let formData = {
                topic_discussed: $("#update_topic_discussed").val(),
                topic_date: $("#update_topic_date").val(),
                _token: $('meta[name="csrf-token"]').attr("content") // CSRF Token
            };

            let speakerId = $("#speaker_id").val();
            $.ajax({
                url: "/admin/speaker-management/" + speakerId + "/topics/" + topicId,
                type: "PUT",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        $("#editTopicModal").modal("hide"); // Hide modal
                        $('#updateTopicForm')[0].reset(); // Reset form
                        $("#topics").DataTable().ajax.reload(); // Reload DataTable
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
