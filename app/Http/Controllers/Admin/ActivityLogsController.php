<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploymentType;
use App\Models\Position;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.activity-logs.index');
    }

    public function getIndex()
    {
        $data = Activity::with('causer')->orderBy('created_at', 'asc')->get();

        return DataTables::of($data)
            ->addColumn('timestamp', function ($row) {
                return $row->created_at->timestamp; // Returns Unix timestamp for sorting
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format('M d, Y | h:i A');
            })
            ->addColumn('event', function ($row) {
                return match ($row->event) {
                    'activated' => '<span class="badge bg-success">Activated</span>',
                    'deactivated' => '<span class="badge bg-warning">Deactivated</span>',
                    'account_created' => '<span class="badge bg-secondary">Account Created</span>',
                    'account_updated' => '<span class="badge bg-success">Account Updated</span>',
                    default => '<span class="badge bg-secondary">' . ucfirst($row->event) . '</span>',
                };
            })
            ->addColumn('causer_name', function ($row) {
                return $row->causer ? $row->causer->first_name . " " . $row->causer->last_name : 'System';
            })
            ->addColumn('causer_role', function ($row) {
                return $row->causer->role === 'admin'
                ? '<span class="badge bg-danger">' . ucfirst($row->causer->role) . '</span>'
                : '<span class="badge bg-success">' . ucfirst($row->causer->role) . '</span>';

            })
            ->addColumn('description', function ($row) {
                return $row->description;
            })
            ->addColumn('properties', function ($row) {
                // Decode the JSON properties and format them
                $properties = $row->properties;
                $causer = $row->causer ? $row->causer->first_name . $row->causer->last_name : 'System';

                $changes = collect($row->properties['attributes'] ?? [])->keys()->implode(', ');
                $oldValues = collect($row->properties['old'] ?? []);
                $newValues = collect($row->properties['attributes'] ?? []);
                $logMessage = '';

                if ($row->event === 'created') {
                    $logMessage = "{$causer} created a new record.";
                } elseif ($row->event === 'updated') {
                    $changedFields = [];

                    foreach ($newValues as $key => $newValue) {
                        $oldValue = $oldValues->get($key, 'N/A');
                        if ($oldValue !== $newValue) {
                            $changedFields[] = "{$key} (from '{$oldValue}' to '{$newValue}')";
                        }
                    }

                    $logMessage = "{$causer} updated the following fields: " . implode(', ', $changedFields);
                } elseif ($row->event === 'deleted') {
                    $logMessage = "{$causer} deleted the record.";
                } elseif ($row->event === 'restored') {
                    $logMessage = "{$causer} restored the record.";
                } else {
                    $logMessage = $row->description;
                }
                // return $logMessage;
                // $causer = $this->causer ? $this->causer->name : 'System';
                return '<pre>' . json_encode([
                    'description' => $logMessage,
                    'changes' => $properties,
                ], JSON_PRETTY_PRINT) . '</pre>';
            })

            ->rawColumns(['causer_role', 'event', 'description', 'properties']) // Allow HTML in these columns
            ->make(true);
    }
}
