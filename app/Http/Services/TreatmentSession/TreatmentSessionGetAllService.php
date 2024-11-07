<?php

namespace App\Http\Services\TreatmentSession;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class TreatmentSessionGetAllService extends TreatmentSessionService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select(['id', 'tooth', 'created_at', 'diagnose_id']);

        if ($request->has("patient")) {
            $data->where("patient_id", $request->patient);
        }

        if ($request->has("tooth") && $request->tooth != "") {
            $data->where("tooth", $request->tooth);
        }

        if ($request->from && $request->from != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->from / 1000;
            $from = Carbon::createFromTimestamp($timestamp)->startOfDay(); // Set to 00:00:00 of the given date
            $data->where('created_at', '>=', $from);
        }

        if ($request->to && $request->to != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->to / 1000;
            $to = Carbon::createFromTimestamp($timestamp)->endOfDay(); // Set to 23:59:59 of the given date
            $data->where('created_at', '<=', $to);
        }

        $tableName = "treatment_details";

        return DataTables::of($data)
            ->addColumn('diagnose', function ($row) {
                return $row->diagnose->name;
            })
            ->addColumn('treatment', function ($row) {
                return $row->invoice[0]->treatment;
            })
            ->addColumn('created_at', function ($row) {
                return $row->created_at->format("Y-m-d");
            })
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column
                    $columns = Schema::getColumnListing($tableName); // Fetch the table columns

                    $query->where(function ($query) use ($columns, $search) {
                        $skippedColumns = ["id", "updated_at", 'diagnose_id'];
                        foreach ($columns as $column) {
                            if (in_array($column, $skippedColumns)) continue;
                            $query->orWhere($column, 'like', "%{$search}%");
                        }

                        // Additional search for related 'day' field (assuming relationship is 'schduleDay')
                        $query->orWhereHas('diagnose', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });

                        $query->orWhereHas('invoice', function ($query) use ($search) {
                            $query->where('treatment', 'like', "%{$search}%");
                        });
                    });
                }
            })

            ->order(function ($query) use ($request) {
                if ($request->has('order')) {
                    $orderColumn = $request->order[0]['column'];
                    $orderDir = $request->order[0]['dir'];
                    $query->orderBy($request->columns[$orderColumn]['data'], $orderDir);
                }
            })
            ->make(true);
    }
}
