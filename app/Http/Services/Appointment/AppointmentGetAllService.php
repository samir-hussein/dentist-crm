<?php

namespace App\Http\Services\Appointment;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class AppointmentGetAllService extends AppointmentService
{
    public function boot(Request $request)
    {
        // Fetch all columns from your model's table
        $data = $this->model->latest()->select('*');

        $tableName = "appointments";

        return DataTables::of($data)
            ->addColumn('patientName', function ($row) {
                return $row->patient->name;
            })
            ->addColumn('patientPhone', function ($row) {
                return $row->patient->phone;
            })
            ->addColumn('patientPhone2', function ($row) {
                return $row->patient->phone2;
            })
            ->addColumn('doctorName', function ($row) {
                return $row->doctor->name;
            })
            ->addColumn('servicesNames', function ($row) {
                return $row->services->map(function ($service) {
                    return $service->name;
                })->implode(' - ');
            })
            ->addColumn('appointment', function ($row) {
                return Carbon::parse($row->time->time)->format('l Y-m-d h:i a');
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

                        // Add search for the added columns
                        $query->orWhereHas('patient', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%")->orWhere("phone", "like", "%{$search}%")->orWhere("phone2", "like", "%{$search}%");
                        });

                        $query->orWhereHas('doctor', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });

                        $query->orWhereHas('services', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
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
