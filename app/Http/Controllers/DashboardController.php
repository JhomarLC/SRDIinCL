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

         // 📌 Total Farmers Registered This Month (calendar month)
        $currentMonthStart = now()->startOfMonth();
        $currentMonthEnd = now(); // up to today

        $totalFarmersThisMonth = Participant::where('status', '!=', 'archived')
            ->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
            ->count();

        // 📌 Total Farmers Registered Last Month (full last month)
        $previousMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        $previousMonthEnd = now()->subMonthNoOverflow()->endOfMonth();

        $totalFarmersPreviousMonth = Participant::where('status', '!=', 'archived')
            ->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
            ->count();

        // 📌 % growth this month vs last month
        if ($totalFarmersPreviousMonth > 0) {
            $farmersGrowthPercentage = (($totalFarmersThisMonth - $totalFarmersPreviousMonth) / $totalFarmersPreviousMonth) * 100;
        } else {
            $farmersGrowthPercentage = null;
        }

        // 📌 Total Farmers Overall
        $totalFarmers = $participantsQuery->count();

        // Farmers by province
        // $farmersByProvince = $participantsQuery->select('province_code', DB::raw('COUNT(*) as total'))
        //     ->groupBy('province_code')
        //     ->get();

        $genderDistribution = (clone $participantsQuery)
            ->select(DB::raw("LOWER(gender) as gender"), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw("LOWER(gender)"))
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

        // Training attendance over time
        $trainingAttendance = TrainingResults::whereHas('participant', function ($q) {
                $q->where('status', '!=', 'archived');
            })
            ->select(DB::raw('YEAR(training_date_main) as year'), DB::raw('COUNT(*) as total'))
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        // Average gain in knowledge
        $averageGainInKnowledge = TrainingResults::whereHas('participant', function ($q) {
                $q->where('status', '!=', 'archived');
            })
            ->avg('gain_in_knowledge');

        // Farm size distribution (bucketed ranges)
        $farmSizeBuckets = FarmingData::whereHas('participant', function ($q) {
                $q->where('status', '!=', 'archived');
            })
            ->select(
                DB::raw("
                    CASE
                        WHEN farm_size_hectares < 1 THEN '0-1 ha'
                        WHEN farm_size_hectares BETWEEN 1 AND 3 THEN '1-3 ha'
                        WHEN farm_size_hectares BETWEEN 3 AND 5 THEN '3-5 ha'
                        ELSE '5+ ha'
                    END as size_range
                "),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('size_range')
            ->get();

        // Average yield per season
        $yieldPerSeason = FarmingData::whereHas('participant', function ($q) {
                $q->where('status', '!=', 'archived');
            })
            ->select(
                'season',
                DB::raw('AVG(total_yield_caban * weight_per_caban_kg) as average_yield_kg')
            )
            ->groupBy('season')
            ->get();
        $openrouterApiKey = config('services.openrouter.api_key');
        return view('index', compact(
            'totalFarmers',
            'farmersGrowthPercentage',
            // 'farmersByProvince',
            'genderDistribution',
            'ageGroupDistribution',
            'trainingAttendance',
            'averageGainInKnowledge',
            'farmSizeBuckets',
            'yieldPerSeason',
            'openrouterApiKey'
        ));
    }


}
