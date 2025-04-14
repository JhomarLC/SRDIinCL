<script>
    $('.select2').select2();


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

</script>
