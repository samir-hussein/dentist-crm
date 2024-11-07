<?php

namespace App\Http\Services\Invoice;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class InvoiceIndexService extends InvoiceService
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

        $tableName = $this->model->getTable();

        return DataTables::of($data)
            ->addColumn('patient_name', function ($row) {
                return $row->patient->name;
            })
            ->addColumn('date', function ($row) {
                return $row->created_at->format("Y-m-d");
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
