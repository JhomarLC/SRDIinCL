<?php

namespace App\Http\Controllers;

use App\Models\FarmingData;
use App\Models\Participant;
use App\Models\TrainingResults;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Exclude archived participants
        $participantsQuery = Participant::where('status', '!=', 'archived');

        $genderDistribution = (clone $participantsQuery)
            ->select(
                DB::raw("CASE
                            WHEN LOWER(gender) = 'male' THEN 'Men'
                            WHEN LOWER(gender) = 'female' THEN 'Women'
                            ELSE 'Other'
                        END as gender"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw("CASE
                            WHEN LOWER(gender) = 'male' THEN 'Men'
                            WHEN LOWER(gender) = 'female' THEN 'Women'
                            ELSE 'Other'
                        END"))
            ->get();

        // Age Group distribution
        $allAgeGroups = ['below 18', '18-30', '31-45', '46-59', '60 and above'];

        $ageGroupCounts = (clone $participantsQuery)
            ->select('age_group', DB::raw('COUNT(*) as total'))
            ->groupBy('age_group')
            ->pluck('total', 'age_group')
            ->toArray();

        $ageGroupDistribution = [];
        foreach ($allAgeGroups as $group) {
            $ageGroupDistribution[] = [
                'age_group' => $group,
                'total' => $ageGroupCounts[$group] ?? 0
            ];
        }

        $civilStatusDistribution = (clone $participantsQuery)
            ->select('civil_status', DB::raw('COUNT(*) as total'))
            ->groupBy('civil_status')
            ->get();

        // Averages for training results
        $trainingAverages = TrainingResults::whereHas('participant', function ($q) {
                $q->where('status', '!=', 'archived');
            })
            ->selectRaw('
                AVG(pre_test_score) as avg_pre_test,
                AVG(post_test_score) as avg_post_test,
                AVG(gain_in_knowledge) as avg_gik
            ')
            ->first();

        $educationLevelDistribution = (clone $participantsQuery)
            ->select('education_level', DB::raw('COUNT(*) as total'))
            ->groupBy('education_level')
            ->get();

        $yearsInFarmingBuckets = [
            '0-2 years' => [0, 2],
            '3-5 years' => [3, 5],
            '6-10 years' => [6, 10],
            '11-20 years' => [11, 20],
            '21+ years' => [21, null],
        ];

        $farmingExperienceDistribution = [];

        foreach ($yearsInFarmingBuckets as $label => [$min, $max]) {
            $query = (clone $participantsQuery)->whereNotNull('years_in_farming');

            if (!is_null($max)) {
                $query->whereBetween('years_in_farming', [$min, $max]);
            } else {
                $query->where('years_in_farming', '>=', $min);
            }

            $farmingExperienceDistribution[] = [
                'range' => $label,
                'total' => $query->count(),
            ];
        }
        // Count of participants with a disability
        $disabilityCount = (clone $participantsQuery)
            ->where('is_pwd', true)
            ->count();

        $farmOwnershipDistributionRaw = (clone $participantsQuery)
            ->select('farm_role', DB::raw('COUNT(*) as total'))
            ->groupBy('farm_role')
            ->pluck('total', 'farm_role')
            ->toArray();

        $totalFarmOwnership = array_sum($farmOwnershipDistributionRaw);

        $farmOwnershipDistribution = [];

        foreach (['Farm Owner', 'Relative of Farm Owner'] as $role) {
            $count = $farmOwnershipDistributionRaw[$role] ?? 0;
            $percentage = $totalFarmOwnership > 0 ? round(($count / $totalFarmOwnership) * 100, 2) : 0;

            $farmOwnershipDistribution[] = [
                'role' => $role,
                'total' => $count,
                'percentage' => $percentage,
            ];
        }

        $regionData = (clone $participantsQuery)
            ->whereNotNull('region_code')
            ->select('region_code', DB::raw('COUNT(*) as total'))
            ->groupBy('region_code')
            ->with('region') // to get region name
            ->get()
            ->map(function ($item) {
                return [
                    'code' => $item->region_code,
                    'name' => optional($item->region)->name,
                    'count' => $item->total,
                ];
            });

        $provinceData = (clone $participantsQuery)
            ->whereNotNull('province_code')
            ->with('province')
            ->select('province_code', DB::raw('COUNT(*) as total'))
            ->groupBy('province_code')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => optional($item->province)->name, // Match with NAME_1 in GeoJSON
                    'count' => $item->total,
                ];
            });

        $provinceChartData = (clone $participantsQuery)
            ->whereNotNull('province_code')
            ->with('province')
            ->select('province_code', DB::raw('COUNT(*) as total'))
            ->groupBy('province_code')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'label' => optional($item->province)->name ?? 'Unknown',
                    'value' => $item->total,
                ];
            })
            ->sortByDesc('value')
            ->values(); // Reindex for clean JSON

        $openrouterApiKey = config('services.openrouter.api_key');
        return view('index', compact(
            'genderDistribution',
            'ageGroupDistribution',
            'openrouterApiKey',
            'trainingAverages',
            'civilStatusDistribution',
            'educationLevelDistribution',
            'farmingExperienceDistribution',
            'farmOwnershipDistribution',
            'disabilityCount',
            'regionData',
            'provinceData',          // for the map
            'provinceChartData',     // for the bar chart
        ));
    }


}
