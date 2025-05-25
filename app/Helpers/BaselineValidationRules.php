<?php

namespace App\Helpers;

class BaselineValidationRules
{
    public static function rules(string $step = 'all')
    {
        $rules = [
            'land-preparation' => [
                'land_prep_is_pakyaw' => 'required|boolean',

                // If pakyaw (package), require package_cost
                'land_prep_package_cost' => 'required_if:land_prep_is_pakyaw,1|nullable|numeric|min:0',

                // If not pakyaw, validate array inputs
                'land_prep.*.activity' => 'required_if:land_prep_is_pakyaw,0|string|max:255',
                'land_prep.*.qty' => 'required_if:land_prep_is_pakyaw,0|nullable|integer|min:0',
                'land_prep.*.unit_cost' => 'required_if:land_prep_is_pakyaw,0|nullable|numeric|min:0',
                'land_prep.*.total_cost' => 'required_if:land_prep_is_pakyaw,0|nullable|numeric|min:0',
            ],
            'seeds-prep' => [
                'seeds_prep_is_pakyaw' => 'required|boolean',

                'seeds_prep_package_cost' => 'required_if:seeds_prep_is_pakyaw,1|nullable|numeric|min:0',

                'seed_prep.*.activity' => 'required_if:seeds_prep_is_pakyaw,0|string|max:255',
                'seed_prep.*.qty' => 'required_if:seeds_prep_is_pakyaw,0|nullable|integer|min:0',
                'seed_prep.*.unit_cost' => 'required_if:seeds_prep_is_pakyaw,0|nullable|numeric|min:0',
                'seed_prep.*.total_cost' => 'required_if:seeds_prep_is_pakyaw,0|nullable|numeric|min:0',

                // Optional fields
                'seeds_prep_others' => 'nullable|string|max:500',

                'seed_varieties.*.variety_name' => 'required|string|max:255',
                'seed_varieties.*.purchase_type' => 'required|in:free,purchase',
                'seed_varieties.*.qty' => 'nullable|integer|min:0',
                'seed_varieties.*.unit_cost' => 'nullable|numeric|min:0',
                'seed_varieties.*.total_cost' => 'nullable|numeric|min:0',
            ],
        ];

        if ($step === 'all') {
            return array_merge(...array_values($rules));
        }

        return $rules[$step] ?? [];
    }

    public static function messages()
    {
        return [
            'land_prep_package_cost.required_if' => 'Please provide the total cost for the package if pakyaw is selected.',

            'land_prep.*.activity.required_if' => 'Activity name is required when not using pakyaw.',
            'land_prep.*.qty.required_if' => 'Quantity is required when not using pakyaw.',
            'land_prep.*.unit_cost.required_if' => 'Unit cost is required when not using pakyaw.',
            'land_prep.*.total_cost.required_if' => 'Total cost is required when not using pakyaw.',

              // Seeds Prep
            'seeds_prep_package_cost.required_if' => 'Please enter the seeds prep package cost when pakyaw is selected.',
            'seed_prep.*.activity.required_if' => 'Activity name is required when seeds prep is not pakyaw.',
            'seed_prep.*.qty.required_if' => 'Quantity is required for the seeds prep activity.',
            'seed_prep.*.unit_cost.required_if' => 'Unit cost is required for the seeds prep activity.',
            'seed_prep.*.total_cost.required_if' => 'Total cost is required for the seeds prep activity.',

            // Varieties
            'seed_varieties.*.variety_name.required' => 'Variety name is required.',
            'seed_varieties.*.purchase_type.required' => 'Please select Free or Purchase for the variety.',
        ];
    }
}
