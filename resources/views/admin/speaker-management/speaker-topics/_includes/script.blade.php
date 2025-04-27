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
                { data: 'topic_location', name: 'topic_location' },
                { data: 'average_evaluation_score', name: 'average_evaluation_score' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });
        $('.select2').select2();

        $('#addnewtopicmodal').on('shown.bs.modal', function () {
            $(this).find('.select2').select2({
                dropdownParent: $(this)
            });
        });
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


    // UPDATE
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
                province_code: $('#province').val(),
                municipality_code: $('#municipality').val(),
                barangay_code: $('#barangay').val(),
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

            let provinceCode = $(this).data("province");
            let municipalityCode = $(this).data("municipality");
            let barangayCode = $(this).data("barangay");

            // Populate the modal fields
            $("#edit_id").val(topicId);
            // $("#update_topic_discussed").val(topic_discussed);
            $("#update_topic_discussed").val(topic_discussed).trigger('change');

            $("#update_topic_date").val(topic_date);

            $("#update_province").html('<option>Loading...</option>').prop("disabled", true);
            $("#update_municipality").html('<option>Loading...</option>').prop("disabled", true);
            $("#update_barangay").html('<option>Loading...</option>').prop("disabled", true);

             // ✅ Load Province First
             $.ajax({
                url: "https://psgc.gitlab.io/api/provinces/",
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

            // Show the modal
            $("#editTopicModal").modal("show");
        });

        $("#updateTopicForm").submit(function (e) {
            e.preventDefault(); // Prevent default form submission

            let topicId = $("#edit_id").val(); // Get the admin ID

            let formData = {
                topic_discussed: $("#update_topic_discussed").val(),
                topic_date: $("#update_topic_date").val(),
                province_code: $('#update_province').val(),
                municipality_code: $('#update_municipality').val(),
                barangay_code: $('#update_barangay').val(),
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
