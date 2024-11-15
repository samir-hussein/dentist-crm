<?php

namespace App\Http\Services\LabOrder;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Exports\LabReportExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class LabOrderReportService extends LabOrderService
{
    public function boot()
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');
        $from = null;
        $to = null;

        $request = request();

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

        if ($request->lab) {
            $data->where('lab_id', $request->lab);
        }

        if ($request->excel) {
            $invoices = $data->get();
            return Excel::download(new LabReportExport($invoices, $from?->format("d-m-Y"), $to?->format("d-m-Y")), 'lab_orders.xlsx');
        }

        $tableName = $this->model->getTable();

        return DataTables::of($data)
            ->addColumn('patient_name', function ($row) {
                return $row->patient->name;
            })
            ->addColumn('patient_code', function ($row) {
                return $row->patient->code;
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
            ->addColumn('date', function ($row) {
                return $row->created_at?->format("d-m-Y");
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
                            $query->where('name', 'like', "%{$search}%")->orWhere("code", 'like', "%{$search}%");
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
