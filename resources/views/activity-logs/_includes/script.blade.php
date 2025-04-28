<script>
    // VIEW
    $(document).ready(function () {
        $('#select_event, #select_role').select2();
        let addressCache = {}; // Initialize cache object

        let table = $("#aews").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, "desc"]],
            columnDefs: [
                {
                    targets: 0,  // First column
                    visible: false  // Hide it completely (won't be shown even when expanded)
                },
                {
                    targets: -1,  // Last column (Properties column)
                    className: "none"  // Hide it by default, shown when expanded
                }
            ],
            ajax: {
                url: "{{ route('activity-logs.get-index') }}",
                data: function (d) {
                    d.event = $("#select_event").val(); // Send selected filter value
                    d.role = $("#select_role").val(); // Send selected filter value
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'created_at', name: 'created_at', orderable: false }, // Placed first
                { data: 'description', name: 'description', orderable: false },
                { data: 'event', name: 'event', orderable: false },
                { data: 'causer_name', name: 'causer_name', orderable: false },
                { data: 'causer_role', name: 'causer_role', orderable: false },
                { data: 'properties', name: 'properties', orderable: false },
            ],
        });
        // Reload table when filter changes
        $("#select_event, #select_role").on("change", function () {
            table.ajax.reload();
        });
    });

</script>
