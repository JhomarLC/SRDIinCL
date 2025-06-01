<?php

namespace App\Helpers;

class BaselineValidationRules
{
    public static function rules(string $step = 'all')
    {
        $cropEstMethod = request('crop_est_method'); // Get from current request

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
                'seedbed_prep_is_pakyaw' => 'nullable|boolean',
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
                'fertilizer_management.*.label' => 'nullable|string|max:500',
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
            'water-management' => [
                'water_management_type' => 'required|in:nia,supplementary',
                'water_management_is_package' => 'required|boolean',

                // If NIA, require total amount
                'water_management_nia_total' => 'required_if:water_management_type,nia|nullable|numeric|min:0',

                // If supplementary & is_package = 1
                'water_management_package_total_cost' => 'required_if:water_management_is_package,1|nullable|numeric|min:0',

                // Supplementary method → irrigation breakdown
                'water_irrigations.*.label' => 'required_if:water_management_type,supplementary|string|max:255',
                'water_irrigations.*.method' => 'required_if:water_management_type,supplementary|in:nia,supplementary',

                // If method is NIA
                'water_irrigations.*.nia_total' => 'required_if:water_irrigations.*.method,nia|nullable|numeric|min:0',

                // If method is supplementary
                'water_irrigations.*.details.*.activity' => 'required_if:water_irrigations.*.method,supplementary|string|max:255',
                'water_irrigations.*.details.*.qty' => 'nullable|integer|min:0',
                'water_irrigations.*.details.*.unit_cost' => 'nullable|numeric|min:0',
                'water_irrigations.*.details.*.total_cost' => 'nullable|numeric|min:0',
            ],

            'pest-management' => [
                // Application-level
                'pesticide_management.*.pesticides' => 'nullable|array',
                'pesticide_management.*.pesticides.*' => 'nullable|string|max:255',
                'pesticide_management.*.label' => 'required|string|max:255',
                'pesticide_management.*.others' => 'nullable|string|max:500',

                'pesticide_management.*.brand_names' => 'nullable|array',
                'pesticide_management.*.brand_names.*' => 'nullable|string|max:255',

                // Labor - Only required if pesticide or any qty/unit_cost is provided
                'pesticide_management.*.chemical.activity' => 'required_with:pesticide_management.*.chemical.qty,pesticide_management.*.chemical.unit_cost|string|max:255',
                'pesticide_management.*.chemical.qty' => 'nullable|integer|min:0',
                'pesticide_management.*.chemical.unit_cost' => 'nullable|numeric|min:0',
                'pesticide_management.*.chemical.total_cost' => 'nullable|numeric|min:0',

                'pesticide_management.*.weeding.activity' => 'required_with:pesticide_management.*.weeding.qty,pesticide_management.*.weeding.unit_cost|string|max:255',
                'pesticide_management.*.weeding.qty' => 'nullable|integer|min:0',
                'pesticide_management.*.weeding.unit_cost' => 'nullable|numeric|min:0',
                'pesticide_management.*.weeding.total_cost' => 'nullable|numeric|min:0',

                'pesticide_management.*.meals.activity' => 'required_with:pesticide_management.*.meals.qty,pesticide_management.*.meals.unit_cost|string|max:255',
                'pesticide_management.*.meals.qty' => 'nullable|integer|min:0',
                'pesticide_management.*.meals.unit_cost' => 'nullable|numeric|min:0',
                'pesticide_management.*.meals.total_cost' => 'nullable|numeric|min:0',
            ],
            'harvest-management' => [
                'harvest_management_type' => 'required|in:Manual,Mechanical',

                // Mechanical inputs
                'harvest_mechanical.bags' => 'required_if:harvest_management_type,Mechanical|nullable|integer|min:0',
                'harvest_mechanical.avg_bag_weight' => 'required_if:harvest_management_type,Mechanical|nullable|numeric|min:0',
                'harvest_mechanical.price_per_kg' => 'required_if:harvest_management_type,Mechanical|nullable|numeric|min:0',
                'harvest_mechanical.total_cost' => 'required_if:harvest_management_type,Mechanical|nullable|numeric|min:0',

                // Manual inputs
                'harvest_manual.is_package' => 'required_if:harvest_management_type,Manual|boolean',
                'harvest_manual.package_total_cost' => 'required_if:harvest_manual.is_package,1|nullable|numeric|min:0',

                'harvest_manual_items.*.activity' => 'required_if:harvest_manual.is_package,0|string|max:255',
                'harvest_manual_items.*.qty' => 'required_if:harvest_manual.is_package,0|nullable|integer|min:0',
                'harvest_manual_items.*.unit_cost' => 'required_if:harvest_manual.is_package,0|nullable|numeric|min:0',
                'harvest_manual_items.*.total_cost' => 'required_if:harvest_manual.is_package,0|nullable|numeric|min:0',
            ],
            'other-expenses' => [
                'other_expenses.hauling.bags' => 'nullable|integer|min:0',
                'other_expenses.hauling.unit_cost' => 'nullable|numeric|min:0',
                'other_expenses.hauling.total_cost' => 'nullable|numeric|min:0',

                'other_expenses.permanent_labor.bags' => 'nullable|integer|min:0',
                'other_expenses.permanent_labor.avg_bag_weight' => 'nullable|numeric|min:0',
                'other_expenses.permanent_labor.price_per_kg' => 'nullable|numeric|min:0',
                'other_expenses.permanent_labor.percent_share' => 'nullable|numeric|min:0',
                'other_expenses.permanent_labor.total_cost' => 'nullable|numeric|min:0',

                'other_expenses.amilyar.total_cost' => 'nullable|numeric|min:0',
            ],
        ];

        // ✅ Conditionally unset seedbed rules if DWSR
        if ($cropEstMethod === 'DWSR') {
            unset($rules['seedbed-prep']);
            unset($rules['seedbed-fertilization']);
        }

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

            'water_management_type.required' => 'Please select a water management type.',
            'water_management_type.in' => 'Water management type must be either NIA or Supplementary.',
            'water_management_is_package.required' => 'Please specify if water management is pakyaw.',
            'water_management_nia_total.required_if' => 'NIA total cost is required if NIA is selected.',
            'water_management_package_total_cost.required_if' => 'Package cost is required for pakyaw supplementary water management.',

            'water_irrigations.*.label.required_if' => 'Irrigation label is required when using supplementary method.',
            'water_irrigations.*.method.required_if' => 'Irrigation method is required for each irrigation entry.',
            'water_irrigations.*.method.in' => 'Irrigation method must be either NIA or Supplementary.',

            'water_irrigations.*.nia_total.required_if' => 'NIA total cost is required for NIA irrigation.',

            'water_irrigations.*.details.*.activity.required_if' => 'Activity is required for supplementary irrigation.',
            'water_irrigations.*.details.*.qty.integer' => 'Irrigation quantity must be a number.',
            'water_irrigations.*.details.*.unit_cost.numeric' => 'Irrigation unit cost must be a valid number.',
            'water_irrigations.*.details.*.total_cost.numeric' => 'Irrigation total cost must be a valid number.',

            'pesticide_management.*.brand_names.*.string' => 'Each brand name must be a valid string.',
            'pesticide_management.*.brand_names.*.max' => 'Brand names may not exceed 255 characters.',
            'pesticide_management.*.chemical.activity.required_with' => 'Chemical application labor activity is required when quantity or unit cost is provided.',
            'pesticide_management.*.weeding.activity.required_with' => 'Manual weeding labor activity is required when quantity or unit cost is provided.',
            'pesticide_management.*.meals.activity.required_with' => 'Meals and snacks labor activity is required when quantity or unit cost is provided.',

            // Harvest Management
            'harvest_management_type.required' => 'Please select a type of harvesting.',
            'harvest_management_type.in' => 'Harvesting type must be Manual or Mechanical.',

            'harvest_mechanical.bags.required_if' => 'Number of bags is required for mechanical harvesting.',
            'harvest_mechanical.avg_bag_weight.required_if' => 'Average bag weight is required for mechanical harvesting.',
            'harvest_mechanical.price_per_kg.required_if' => 'Price per kilo is required for mechanical harvesting.',
            'harvest_mechanical.total_cost.required_if' => 'Total cost is required for mechanical harvesting.',

            'harvest_manual.is_package.required_if' => 'Please specify if manual harvesting is a package.',
            'harvest_manual.package_total_cost.required_if' => 'Package total cost is required for manual harvesting (package).',

            'harvest_manual_items.*.activity.required_if' => 'Activity name is required for manual harvesting (non-package).',
            'harvest_manual_items.*.qty.required_if' => 'Quantity is required for manual harvesting (non-package).',
            'harvest_manual_items.*.unit_cost.required_if' => 'Unit cost is required for manual harvesting (non-package).',
            'harvest_manual_items.*.total_cost.required_if' => 'Total cost is required for manual harvesting (non-package).',

            // Other Expenses
            'other_expenses.hauling.bags.integer' => 'Hauling bags must be a whole number.',
            'other_expenses.hauling.unit_cost.numeric' => 'Hauling unit cost must be a valid number.',
            'other_expenses.hauling.total_cost.numeric' => 'Hauling total cost must be a valid number.',

            'other_expenses.permanent_labor.bags.integer' => 'Permanent labor bags must be a whole number.',
            'other_expenses.permanent_labor.avg_bag_weight.numeric' => 'Average bag weight must be a valid number.',
            'other_expenses.permanent_labor.price_per_kg.numeric' => 'Price per kilo must be a valid number.',
            'other_expenses.permanent_labor.percent_share.numeric' => 'Percent share must be a valid number.',
            'other_expenses.permanent_labor.total_cost.numeric' => 'Permanent labor total cost must be a valid number.',

            'other_expenses.amilyar.total_cost.numeric' => 'Land ownership fee must be a valid number.',
        ];
    }
}
