<?php

namespace App\Http\Services\LabOrder;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class LabOrderIndexService extends LabOrderService
{
    public function boot()
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        $request = request();

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

        $tableName = $this->model->getTable();

        return DataTables::of($data)
            ->addColumn('patient_name', function ($row) {
                return $row->patient->name;
            })
            ->addColumn('lab', function ($row) {
                return $row->lab->name;
            })
            ->addColumn('sent', function ($row) {
                return $row->sent->format("d-m-Y");
            })
            ->addColumn('received', function ($row) {
                return $row->received?->format("d-m-Y");
            })
            ->addColumn('custom_data', function ($row) {
                return collect($row->custom_data)
                    ->filter() // Remove null values
                    ->map(function ($data) {
                        return $data['name'] . ": " . $data['value'];
                    })
                    ->implode(', ');
            })
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column
                    $columns = Schema::getColumnListing($tableName); // Fetch the table columns

                    $query->where(function ($query) use ($columns, $search) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', "%{$search}%");
                        }

                        // Additional search for related 'day' field (assuming relationship is 'schduleDay')
                        $query->orWhereHas('patient', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });

                        $query->orWhereHas('lab', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
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
