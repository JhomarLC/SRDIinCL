<script>
    // VIEW
    $(document).ready(function () {
        $("#aews").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            order: [[0, "desc"]],
            columnDefs: [
                { targets: 0, visible: false },
            ],
            ajax: "{{ route('activity-logs.get-index') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'created_at', name: 'created_at', orderable: false }, // Placed first
                { data: 'event', name: 'event', orderable: false },
                { data: 'causer_name', name: 'causer_name', orderable: false },
                { data: 'causer_role', name: 'causer_role', orderable: false },
                { data: 'description', name: 'description', orderable: false },
                { data: 'properties', name: 'properties', orderable: false }
            ]
        });
    });
</script>
