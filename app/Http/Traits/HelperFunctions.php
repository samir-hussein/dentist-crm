<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

trait HelperFunctions
{
    public function dataTable($data, string $tableName, Request $request)
    {
        return DataTables::of($data)
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column
                    $columns = Schema::getColumnListing($tableName); // Replace with your table name
                    $query->where(function ($query) use ($columns, $search) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', "%{$search}%");
                        }
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

    public function dataTableWithAgeColumn($data, string $tableName, Request $request)
    {
        return DataTables::of($data)
            ->addColumn('age', function ($row) {
                // Calculate the age using Carbon and the date_of_birth field
                return Carbon::parse($row->date_of_birth)->age;
            })
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column
                    $columns = Schema::getColumnListing($tableName); // Replace with your table name
                    $query->where(function ($query) use ($columns, $search) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', "%{$search}%");
                        }

                        // Check if the search term is numeric and represents a valid age
                        if (is_numeric($search) && (int)$search > 0) {
                            $age = (int)$search; // Cast to integer

                            // Calculate the date range for the specified age
                            $dateFrom = Carbon::now()->subYears($age + 1)->startOfYear(); // Start of year before the age
                            $dateTo = Carbon::now()->subYears($age)->endOfYear(); // End of the target age year

                            // Filter based on date_of_birth
                            $query->orWhereBetween('date_of_birth', [$dateFrom->toDateString(), $dateTo->toDateString()]);
                        }
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
