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
            'seedbed-prep' => [
                'seedbed_prep_is_pakyaw' => 'required|boolean',
                'seedbed_prep_package_cost' => 'required_if:seedbed_prep_is_pakyaw,1|nullable|numeric|min:0',

                'seedbed_prep.*.activity' => 'required_if:seedbed_prep_is_pakyaw,0|string|max:255',
                'seedbed_prep.*.qty' => 'required_if:seedbed_prep_is_pakyaw,0|nullable|integer|min:0',
                'seedbed_prep.*.unit_cost' => 'required_if:seedbed_prep_is_pakyaw,0|nullable|numeric|min:0',
                'seedbed_prep.*.total_cost' => 'required_if:seedbed_prep_is_pakyaw,0|nullable|numeric|min:0',
            ],
            'seedbed-fertilization' => [
                'seedbed_fertilization.*.activity' => 'nullable|string|max:255',
                'seedbed_fertilization.*.qty' => 'nullable|nullable|integer|min:0',
                'seedbed_fertilization.*.unit_cost' => 'nullable|nullable|numeric|min:0',
                'seedbed_fertilization.*.total_cost' => 'nullable|nullable|numeric|min:0',

                'seedbed_fertilizer.*.fertilizer_name' => 'nullable|string|max:255',
                'seedbed_fertilizer.*.qty' => 'nullable|integer|min:0',
                'seedbed_fertilizer.*.unit_cost' => 'nullable|numeric|min:0',
                'seedbed_fertilizer.*.total_cost' => 'nullable|numeric|min:0',

                'seedbed_fertilization_others' => 'nullable|string|max:500',
            ],
            'crop-establishment' => [
                'crop_est_method' => 'required|in:DWSR,TPR',
                'crop_est_establishment_type' => 'nullable|string|max:255',
                'crop_est_is_pakyaw' => 'required|boolean',
                'crop_est_package_total_cost' => 'required_if:crop_est_is_pakyaw,1|nullable|numeric|min:0',

                'crop_est_particulars.*.activity' => 'required_if:crop_est_is_pakyaw,0|string|max:255',
                'crop_est_particulars.*.qty' => 'required_if:crop_est_is_pakyaw,0|nullable|integer|min:0',
                'crop_est_particulars.*.unit_cost' => 'required_if:crop_est_is_pakyaw,0|nullable|numeric|min:0',
                'crop_est_particulars.*.total_cost' => 'required_if:crop_est_is_pakyaw,0|nullable|numeric|min:0',
            ],
            'fertilizer-management' => [
                // Application-level
                'fertilizer_management.*.fertilizers' => 'nullable|array',
                'fertilizer_management.*.fertilizers.*' => 'nullable|string|max:255',
                'fertilizer_management.*.others' => 'nullable|string|max:500',

                // Labor - Fertilizer Application
                'fertilizer_management.*.fert_application.activity' => 'required|string|max:255',
                'fertilizer_management.*.fert_application.qty' => 'nullable|integer|min:0',
                'fertilizer_management.*.fert_application.unit_cost' => 'nullable|numeric|min:0',
                'fertilizer_management.*.fert_application.total_cost' => 'nullable|numeric|min:0',

                // Labor - Meals and Snacks
                'fertilizer_management.*.meals.activity' => 'required|string|max:255',
                'fertilizer_management.*.meals.qty' => 'nullable|integer|min:0',
                'fertilizer_management.*.meals.unit_cost' => 'nullable|numeric|min:0',
                'fertilizer_management.*.meals.total_cost' => 'nullable|numeric|min:0',
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

              // Seedbed Prep
            'seedbed_prep_package_cost.required_if' => 'Please enter the seedbed package cost when pakyaw is selected.',
            'seedbed_prep.*.activity.required_if' => 'Activity name is required when seedbed prep is not pakyaw.',
            'seedbed_prep.*.qty.required_if' => 'Quantity is required for the seedbed prep activity.',
            'seedbed_prep.*.unit_cost.required_if' => 'Unit cost is required for the seedbed prep activity.',
            'seedbed_prep.*.total_cost.required_if' => 'Total cost is required for the seedbed prep activity.',

            // Optional: general fallback validation messages (if needed)
            'seedbed_fertilization.*.activity.string' => 'Activity must be a string.',
            'seedbed_fertilization.*.qty.integer' => 'Quantity must be a number.',
            'seedbed_fertilization.*.unit_cost.numeric' => 'Unit cost must be a valid number.',
            'seedbed_fertilization.*.total_cost.numeric' => 'Total cost must be a valid number.',

            // 'seedbed_fertilizer.*.purchase_type.required' => 'Please select Free or Purchase for the fertilizer.',

            // Crop Establishment
            'crop_est_method.required' => 'Please select a crop establishment method.',
            'crop_est_method.in' => 'Method must be either DWSR or TPR.',
            'crop_est_is_pakyaw.required' => 'Please indicate if this is a pakyaw (package) method.',
            'crop_est_package_total_cost.required_if' => 'Please enter the total cost for crop establishment if pakyaw is selected.',

            'crop_est_particulars.*.activity.required_if' => 'Activity name is required when crop establishment is not pakyaw.',
            'crop_est_particulars.*.qty.required_if' => 'Quantity is required for the crop establishment activity.',
            'crop_est_particulars.*.unit_cost.required_if' => 'Unit cost is required for the crop establishment activity.',
            'crop_est_particulars.*.total_cost.required_if' => 'Total cost is required for the crop establishment activity.',

            // Fertilizer Management
            'fertilizer_management.*.fert_application.activity.required' => 'Fertilizer application labor activity is required.',
            'fertilizer_management.*.meals.activity.required' => 'Meals and Snacks activity is required.',

            'fertilizer_management.*.fert_application.qty.integer' => 'Fertilizer labor quantity must be a number.',
            'fertilizer_management.*.fert_application.unit_cost.numeric' => 'Fertilizer labor unit cost must be a valid number.',
            'fertilizer_management.*.fert_application.total_cost.numeric' => 'Fertilizer labor total cost must be a valid number.',

            'fertilizer_management.*.meals.qty.integer' => 'Meals quantity must be a number.',
            'fertilizer_management.*.meals.unit_cost.numeric' => 'Meals unit cost must be a valid number.',
            'fertilizer_management.*.meals.total_cost.numeric' => 'Meals total cost must be a valid number.',
        ];
    }
}
