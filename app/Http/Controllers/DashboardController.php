<?php

namespace App\Http\Controllers;

use App\Models\FarmingData;
use App\Models\Municipality;
use App\Models\Participant;
use App\Models\Province;
use App\Models\TrainingResults;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $provinceName = $request->input('province');
        $municipalityName = $request->input('municipality');

        $participantsQuery = Participant::where('status', '!=', 'archived');

        if ($provinceName && $provinceName !== 'all') {
            $participantsQuery->whereHas('province', function ($query) use ($provinceName) {
                $query->where('name', $provinceName);
            });
        }

        if ($municipalityName && $municipalityName !== 'all') {
            $participantsQuery->whereHas('municipality', function ($query) use ($municipalityName) {
                $query->where('name', $municipalityName);
            });
        }

        $provinces = Province::all();
        $municipalities = Municipality::all(); // You can filter this by province later in the view

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

        $openrouterApiKey = config('services.openrouter.api_key');
        return view('index', compact(
            'provinces',
            'municipalities',
            'genderDistribution',
            'ageGroupDistribution',
            'openrouterApiKey',
            'trainingAverages',
            'civilStatusDistribution',
            'educationLevelDistribution',
            'farmingExperienceDistribution',
            'farmOwnershipDistribution',
            'disabilityCount',
            'provinceData',

        ));
    }

}
