<script>
    // VIEW
    $(document).ready(function () {
        $("#eval").DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('training-evaluation-management.get-index', $training_event->id) }}",
            order: [[0, 'desc']],
            columns: [
                { data: 'id', name: 'id', visible: false },
                { data: 'training_content_evaluation', name: 'training_content_evaluation' },
                { data: 'course_management_evaluation', name: 'course_management_evaluation' },
                { data: 'goal_achievement', name: 'goal_achievement' },
                { data: 'overall_quality', name: 'overall_quality' },
                { data: 'status', name: 'status' },
                { data: 'actions', name: 'actions', orderable: false, searchable: false }
            ]
        });

        $('.select2').select2();

        $('td').on('click', function () {
            const radio = $(this).find('input[type="radio"]');
            if (radio.length) {
                radio.prop('checked', true).trigger('change');
            }
        });
    });

</script>
