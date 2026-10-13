<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use DB;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('dashboard/index');
    }

    public function getReports(): Response
    {
        return Inertia::render('dashboard/reports');
    }

    public function getReportData(Request $request): Response
    {
        $data = [];
        $tableHeader = [];
        $reportType = camelToPascalWithSpaces($request->reportType);

        if ($request->reportType === 'vacantControlNumbers') {
            $existingControlNumbers = Patient::pluck('control_no')->toArray();
            $completeNumbers = range(1, max($existingControlNumbers));
            $vacantControlNumbers = array_diff($completeNumbers, $existingControlNumbers);
            $data = array_column($vacantControlNumbers, null);
            $tableHeader = [
                [
                    'name'  => 'Vacant Control No',
                    'align' => 'left',
                ],
            ];
        }

        if ($request->reportType === 'duplicatePatientNames') {
            // Query CipherSweet's polymorphic table with corrected string quotes
            $duplicateIds = DB::table('blind_indexes as f')
                ->join('blind_indexes as l', 'f.indexable_id', '=', 'l.indexable_id')
                ->join('blind_indexes as f2', function ($join) {
                    $join->on('f.value', '=', 'f2.value')
                        ->on('f.indexable_id', '<>', 'f2.indexable_id');
                })
                ->join('blind_indexes as l2', function ($join) {
                    $join->on('l.value', '=', 'l2.value')
                        ->on('f2.indexable_id', '=', 'l2.indexable_id');
                })
                ->where('f.indexable_type', (new Patient)->getMorphClass())
                ->where('f.name', 'first_name_index') // Make sure this matches your exact index name
                ->where('l.name', 'last_name_index')  // Make sure this matches your exact index name
                ->where('f2.name', 'first_name_index')
                ->where('l2.name', 'last_name_index')
                ->distinct()
                ->pluck('f.indexable_id'); // Returns array of IDs

            // Pull the full, decrypted patient profiles using Eloquent
            $patients = Patient::whereIn('id', $duplicateIds)
                ->get()
                ->groupBy(function ($patient) {
                    return strtolower($patient->last_name.' '.$patient->first_name);
                })
                ->map(function ($group) {
                    $firstPatient = $group->first();

                    return [
                        'name'       => $firstPatient->last_name.', '.$firstPatient->first_name,
                        'control_no' => $group->pluck('control_no')->toArray(),
                    ];
                })
                ->values()
                ->toArray();

            $tableHeader = [
                [
                    'name'  => 'Patient Name',
                    'align' => 'left',
                ],
                [
                    'name'  => 'Control Numbers',
                    'align' => 'left',
                ],
            ];

            $data = $patients;
        }

        if ($request->reportType === 'emptyControlNumber') {
            $emptyControlNumber = Patient::select('last_name', 'first_name')->where('control_no', null)
                ->get()->toArray();

            $tableHeader = [
                [
                    'name'  => 'Patient Name',
                    'align' => 'left',
                ],
            ];

            $data = $emptyControlNumber;
        }

        if ($request->reportType === 'duplicateControlNumbers') {
            $duplicateControlNumbers = Patient::select('control_no')
                ->groupBy('control_no')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('control_no');

            $duplicates = Patient::whereIn('control_no', $duplicateControlNumbers)
                ->get()
                ->groupBy('control_no')
                ->map(function ($rows, $controlNo) {
                    return [
                        'control_no' => $controlNo,
                        'names'      => $rows->map(function ($row) {
                            return "{$row->last_name}, {$row->first_name}";
                        })->values()->all(),
                    ];
                })
                ->values()
                ->toArray();

            $tableHeader = [
                [
                    'name'  => 'Control No',
                    'align' => 'left',
                ],
                [
                    'name'  => 'Patient Names',
                    'align' => 'left',
                ],
            ];

            $data = $duplicates;
        }

        return Inertia::render('dashboard/report-data', compact('data', 'reportType', 'tableHeader'));
    }
}
