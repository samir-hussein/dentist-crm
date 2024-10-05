<?php

namespace App\Http\Traits;

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
}
