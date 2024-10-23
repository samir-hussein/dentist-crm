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

    public function dataTableForSchduleDate($data, string $tableName, Request $request)
    {
        return DataTables::of($data)
            ->addColumn('formated_date', function ($row) {
                return $row->date->format("Y-m-d");
            })
            ->addColumn('day', function ($row) {
                return $row->schduleDay->day;
            })
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column
                    $columns = Schema::getColumnListing($tableName); // Fetch the table columns

                    $query->where(function ($query) use ($columns, $search) {
                        $skippedColumns = ["id", "schdule_day_id", "created_at", "updated_at"];
                        foreach ($columns as $column) {
                            if (in_array($column, $skippedColumns)) continue;
                            if ($column !== 'day') {
                                $query->orWhere($column, 'like', "%{$search}%");
                            }
                        }

                        // Additional search for related 'day' field (assuming relationship is 'schduleDay')
                        $query->orWhereHas('schduleDay', function ($query) use ($search) {
                            $query->where('day', 'like', "%{$search}%");
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

    public function dataTableForMedicine($data, string $tableName, Request $request)
    {
        return DataTables::of($data)
            ->filter(function ($query) use ($request, $tableName) {
                if ($request->has('search') && !empty($request->search['value'])) {
                    $search = $request->search['value'];

                    // Loop through all columns and apply search to each column with OR condition
                    $columns = Schema::getColumnListing($tableName);
                    $query->where(function ($query) use ($columns, $search) {
                        foreach ($columns as $column) {
                            $query->orWhere($column, 'like', "%{$search}%");
                        }

                        // Add OR condition to search the related medicineType name
                        $query->orWhereHas('medicineType', function ($query) use ($search) {
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

    public function getDatesForDay(string $day)
    {
        $today = Carbon::now();
        $dates = [];

        $daysMap = [
            'monday' => Carbon::MONDAY,
            'tuesday' => Carbon::TUESDAY,
            'wednesday' => Carbon::WEDNESDAY,
            'thursday' => Carbon::THURSDAY,
            'friday' => Carbon::FRIDAY,
            'saturday' => Carbon::SATURDAY,
            'sunday' => Carbon::SUNDAY,
        ];

        // Loop through the next 30 days
        for ($i = 0; $i <= 30; $i++) {
            $date = $today->copy()->addDays($i);

            if ($date->dayOfWeek === $daysMap[$day]) {
                $dates[] = $date->toDateString();
            }
        }

        // Output the dates
        return $dates;
    }
}
