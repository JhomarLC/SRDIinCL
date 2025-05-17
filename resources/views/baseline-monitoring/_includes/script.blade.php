<script>
    // VIEW
    var userRole = "{{ Auth::user()->role }}";
    var aewProvinceCode = "{{ Auth::user()->profile?->province ?? '' }}";
    var aewMunicipalityCode = "{{ Auth::user()->profile?->municipality ?? '' }}";
    var provincialUser = @json(Auth::user()->isProvincialAew());
    var municipalityUser = @json(Auth::user()->isMunicipalAew());

    $(document).ready(function () {
        var table = $("#baseline").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: "{{ route('baseline-monitoring.get-index') }}",
                // data: function (d) {
                //     d.date_range = $('#dateRange').val();
                //     d.province = $('#province').val();
                // }
            },
            columns: [
                { data: 'full_name', name: 'full_name' },
                { data: 'address', name: 'address' },
                // { data: 'season', name: 'season' },
                { data: 'wet_season', name: 'wet_season' },
                { data: 'dry_season', name: 'dry_season' },
                { data: 'actions', name: 'actions' }
            ]
        });
        $('#dateRange, #province').on('change', function () {
            table.ajax.reload();
        });

        $('#dateRange').on('change', function () {
            table.ajax.reload();
        });

        $('#resetFiltersBtn').on('click', function () {
        // Reset province to "All Province"
        $('#province').val('').trigger('change');

        // Reset date range
        $('#dateRange').val('');

        // Reload DataTable
        table.ajax.reload();

        $('#province').select2({
            width: '100%'
        });
    });
});

</script>
