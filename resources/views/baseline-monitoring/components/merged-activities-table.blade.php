@php
    $mergedRows = [];

    $addRow = function (&$mergedRows, $activity, $particular, $qty, $unit, $total, $purchase = '', $method = '', $remarks = '') {
        if (!isset($mergedRows[$activity])) {
            $mergedRows[$activity] = [];
        }

        foreach ($mergedRows[$activity] as &$row) {
            if (
                $row['particular'] === $particular &&
                $row['purchase'] === $purchase &&
                $row['method'] === $method &&
                $row['remarks'] === $remarks
            ) {
                $row['qty'] += is_numeric($qty) ? $qty : 0;
                $row['total'] += is_numeric($total) ? $total : 0;
                return;
            }
        }

        $mergedRows[$activity][] = compact('particular', 'qty', 'unit', 'total', 'purchase', 'method', 'remarks');
    };

    $data = $seasonData ?? [];
    $labelMap = [
        'land_preparation' => 'Land Preparation',
        'seedbed_preparation' => 'Seedbed Preparation',
        'seedbed_fertilizations' => 'Seedbed Fertilization',
        'seeds_preparation' => 'Seeds Preparation',
        'crop_establishment' => 'Crop Establishment',
    ];

    foreach ($labelMap as $key => $label) {
        $section = $data[$key] ?? null;
        if (!$section) continue;

        // Special handling for crop_establishment
        if ($key === 'crop_establishment') {
            foreach ($section['particulars'] ?? [] as $item) {
                $addRow($mergedRows, $label, $item['activity'], $item['qty'], $item['unit_cost'], $item['total_cost'], '', $section['establishment_type']);
            }
            continue; // ⬅️ Important: skip generic handling
        }

        if (!empty($section['particulars']) && ($section['is_pakyaw'] ?? false) && is_numeric($section['package_cost'])) {
            foreach ($section['particulars'] as $item) {
                $addRow($mergedRows, $label, $item['activity'], '-', '-', '-');
            }
            $addRow($mergedRows, $label, 'Total (Pakyaw Package)', '-', '-', $section['package_cost']);
            continue;
        }

        // Generic activity row addition
        foreach ($section['particulars'] ?? [] as $item) {
            $addRow($mergedRows, $label, $item['activity'], $item['qty'], $item['unit_cost'], $item['total_cost']);
        }

        if ($key === 'seedbed_fertilizations') {
            foreach ($section['fertilizers'] ?? [] as $item) {
                $addRow($mergedRows, $label . ' (Fertilizer)', $item['fertilizer_name'], $item['qty'], $item['unit_cost'], $item['total_cost'], $item['purchase_type']);
            }
        }

        if ($key === 'seeds_preparation') {
            foreach ($section['seed_varieties'] ?? [] as $item) {
                $addRow($mergedRows, 'Seeds (Variety)', $item['variety_name'], $item['qty'], $item['unit_cost'], $item['total_cost'], $item['purchase_type']);
            }
        }
    }


    foreach ($data['fertilizer_applications'] ?? [] as $app) {
        $labelSuffix = isset($app['label']) ? ' - ' . $app['label'] : '';
        $activityLabel = 'Fertilizer' . $labelSuffix; // 👈 matches Water format

        foreach ($app['items'] ?? [] as $item) {
            $addRow($mergedRows, $activityLabel, $item['fertilizer_name'], $item['qty'], $item['unit_cost'], $item['total_cost'], $item['purchase_type']);
        }

        foreach ($app['labors'] ?? [] as $labor) {
            $addRow($mergedRows, $activityLabel, $labor['activity'], $labor['qty'], $labor['unit_cost'], $labor['total_cost']);
        }
    }

    if (
        isset($data['water_management']) &&
        (
            ($data['water_management']['type'] ?? null) === 'nia' ||
            empty($data['water_management']['irrigations'] ?? [])
        )
    ){
        // 👉 Show single package row
        $addRow(
            $mergedRows,
            'Water Management (NIA Package)',
            'NIA Total Cost',
            '-',
            '-',
            $data['water_management']['nia_total_amount'],
            '',
            'nia'
        );
    } else {
         // 👉 Pakyaw supplementary
        if (($data['water_management']['is_package'] ?? false) && is_numeric($data['water_management']['package_total_cost'] ?? null)) {
            $addRow(
                $mergedRows,
                'Water Management (Supplementary Package)',
                'Supplementary Total Cost',
                '-',
                '-',
                $data['water_management']['package_total_cost'],
                '',
                'supplementary'
            );
        }

        // 👉 Show irrigations normally
        foreach ($data['water_management']['irrigations'] ?? [] as $irrigation) {
            $label = 'Water - ' . $irrigation['label'];
            foreach ($irrigation['details'] ?? [] as $detail) {
                $addRow($mergedRows, $label, $detail['activity'], $detail['qty'], $detail['unit_cost'], $detail['total_cost'], '', $irrigation['method']);
            }

            if (!empty($irrigation['nia_total'])) {
                $addRow($mergedRows, $label, 'NIA Total Cost', '-', '-', $irrigation['nia_total'], '', $irrigation['method']);
            }
        }
    }

    // Handle both single and array formats of pesticide applications
    $pestAppsRaw = $data['pesticide_applications'] ?? $data['pesticide_application'] ?? [];
    $pestApps = [];

    if (is_array($pestAppsRaw)) {
        // If it's already an array of apps
        $pestApps = array_is_list($pestAppsRaw) ? $pestAppsRaw : [$pestAppsRaw];
    } else {
        // If it’s a single object, wrap it
        $pestApps = [$pestAppsRaw];
    }

    foreach ($pestApps as $app) {
        $labelSuffix = isset($app['label']) ? ' - ' . $app['label'] : '';
        $activityLabel = 'Pesticide' . $labelSuffix;

        foreach ($app['brand_names'] ?? [] as $brand) {
            $type = $brand['pesticide_type'] ?? 'Unknown';
            $name = $brand['pesticide_name'] ?? 'Unnamed';
            $particular = "$type: $name";
            $addRow($mergedRows, $activityLabel, $particular, '-', '-', '-');
        }

        foreach ($app['details'] ?? [] as $detail) {
            $addRow(
                $mergedRows,
                $activityLabel,
                $detail['activity'],
                $detail['qty'],
                $detail['unit_cost'],
                $detail['total_cost']
            );
        }
    }



@endphp

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Activity</th>
            <th>Particulars</th>
            <th>QTY</th>
            <th>Unit Cost</th>
            <th>Total Cost</th>
            <th>Purchase Type</th>
            <th>Method</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mergedRows as $activity => $rows)
            @foreach ($rows as $index => $row)
                <tr>
                    @if ($index === 0)
                        <td rowspan="{{ count($rows) }}">{{ $activity }}</td>
                    @endif
                    <td>{{ $row['particular'] }}</td>
                    <td>{{ $row['qty'] }}</td>
                    <td>{{ $row['unit'] }}</td>
                    <td>{{ $row['total'] }}</td>
                    <td>{{ $row['purchase'] }}</td>
                    <td>{{ $row['method'] }}</td>
                </tr>
            @endforeach
        @endforeach
        @if (empty($mergedRows))
            <tr><td colspan="7" class="text-center text-muted">No data available for this crop method.</td></tr>
        @endif
    </tbody>
</table>
