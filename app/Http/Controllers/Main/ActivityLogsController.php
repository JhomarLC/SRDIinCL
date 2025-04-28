<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use App\Models\Position;
use Cache;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('activity-logs.index');
    }

    private function getPsgcName($code, $type)
    {
        // Cache each API response for 24 hours to avoid repeated calls
        return Cache::remember("psgc_{$type}_{$code}", 86401, function () use ($code, $type) {
            $url = "https://psgc.gitlab.io/api/{$type}/{$code}";

            try {
                $response = Http::withoutVerifying()->get($url);
                if ($response->successful()) {
                    return $response->json()['name'];
                }
            } catch (Exception $e) {
                return 'Unknown'; // Default value if API fails
            }

            return 'Unknown';
        });
    }

    public function getIndex(Request $request)
    {
        $query = Activity::query();

        if ($request->filled('event')) {
            $query->where('event', $request->input('event')); // Exact match instead of LIKE
        }
        if ($request->filled('role')) {
            $query->whereHas('causer', function ($q) use ($request) {
                $q->where('role', $request->input('role')); // Filtering based on causer role
            });
        }

        $query->with('causer')->orderBy('created_at', 'desc')->get();

        return DataTables::eloquent($query->with('causer'))
            ->addColumn('timestamp', function ($row) {
                return $row->created_at->timestamp; // Returns Unix timestamp for sorting
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('M d, Y | h:i A');
            })
            ->addColumn('description', function ($row) {
                $description = $row->description; // Original log message

                // Only show changes if event is 'accosunt_updated'
                return  $description;
            })
            ->addColumn('event', function ($row) {
                return match ($row->event) {
                    'activated' => '<span class="badge badge-label bg-success text-uppercase"><i class="mdi mdi-circle-medium"></i>Activated</span>',
                    'logged_in' => '<span class="badge badge-label bg-secondary text-uppercase"><i class="mdi mdi-circle-medium"></i> Logged In</span>',
                    'logged_out' => '<span class="badge badge-label bg-danger text-uppercase"><i class="mdi mdi-circle-medium"></i> Logged Out</span>',
                    'deactivated' => '<span class="badge badge-label bg-danger text-uppercase"><i class="mdi mdi-circle-medium"></i> Deactivated</span>',
                    'account_created' => '<span class="badge badge-label bg-secondary text-uppercase"><i class="mdi mdi-circle-medium"></i> Account Created</span>',
                    'account_updated' => '<span class="badge badge-label bg-success text-uppercase"><i class="mdi mdi-circle-medium"></i> Account Updated</span>',
                    default => '<span class="badge badge-label bg-secondary text-uppercase"><i class="mdi mdi-circle-medium"></i> ' . ucfirst($row->event) . '</span>',
                };
            })
            ->addColumn('causer_name', function ($row) {
                return $row->causer ? $row->causer->first_name . " " . $row->causer->last_name : 'System';
            })
            ->addColumn('causer_role', function ($row) {
                return $row->causer->role === 'admin'
                ? '<span class="badge bg-danger-subtle text-danger text-uppercase">' . ucfirst($row->causer->role) . '</span>'
                : '<span class="badge bg-success-subtle text-success text-uppercase">' . ucfirst($row->causer->role) . '</span>';

            })
            ->addColumn('properties', function ($row) {
                // Decode JSON properties safely
                $properties = json_decode($row->properties, true);

                $changes = [];

                // Handle User field changes
                if (!empty($properties['user']) && is_array($properties['user'])) {
                    foreach ($properties['user'] as $field => $change) {
                        if (is_array($change) && array_key_exists('old', $change) && array_key_exists('new', $change)){
                            $oldValue = $change['old'] ?? 'N/A';
                            $newValue = $change['new'] ?? 'N/A';

                            $changes[] = ucfirst(str_replace('_', ' ', $field)) . ":
                            <div class='badge text-danger'> $oldValue </div>
                            ➝
                            <div class='badge bg-success-subtle text-success'> $newValue </div>";
                        }
                    }
                }
                if (!empty($properties['status']) && is_array($properties['status'])) {
                    if (isset($properties['status']['old'], $properties['status']['new'])) {
                        $oldValue = $properties['status']['old'] ?? 'N/A';
                        $newValue = $properties['statuurl: s']['new'] ?? 'N/A';

                        $changes[] = "Status:
                        <div class='badge text-danger'>$oldValue</div>
                        ➝
                        <div class='badge bg-success-subtle text-success'>$newValue</div>";
                    }
                }

                // Handle Profile field changes
                if (!empty($properties['profile']) && is_array($properties['profile'])) {
                    foreach ($properties['profile'] as $field => $change) {
                        if (is_array($change) && isset($change['old'], $change['new'])) {
                            $oldValue = $change['old'] ?? 'N/A';
                            $newValue = $change['new'] ?? 'N/A';

                            // Detect foreign keys and replace with actual names
                            if ($field == 'position_id') {
                                $oldValue = Position::find($change['old'])->position_name ?? 'Unknown';
                                $newValue = Position::find($change['new'])->position_name ?? 'Unknown';
                            }

                            if ($field == 'employment_type_id') {
                                $oldValue = EmploymentType::find($change['old'])->employment_name ?? 'Unknown';
                                $newValue = EmploymentType::find($change['new'])->employment_name ?? 'Unknown';
                            }

                            // 🔹 Format old & new values if they are dates
                            if ($field == 'start_date') {
                                try {
                                    $oldValue = $change['old'] ? Carbon::parse($change['old'])->format('M d, Y ') : 'N/A';
                                    $newValue = $change['new'] ? Carbon::parse($change['new'])->format('M d, Y') : 'N/A';
                                } catch (Exception $e) {
                                    // Fallback if date parsing fails
                                    $oldValue = $change['old'] ?? 'N/A';
                                    $newValue = $change['new'] ?? 'N/A';
                                }
                            }

                            $changes[] = ucfirst(str_replace('_', ' ', $field)) . ":
                            <div class='badge text-danger'> $oldValue </div>
                            ➝
                            <div class='badge bg-success-subtle text-success'> $newValue </div>";

                        }
                    }
                }

                // Format changes with line breaks
                $formattedChanges = !empty($changes) ? "<br><br>" . implode("<br>", $changes) : "";

                return $row->event == 'account_updated' ? $formattedChanges : $row->description;
            })
            ->rawColumns(['causer_role', 'event', 'description', 'properties']) // Allow HTML in these columns
            ->make(true);
    }
}
