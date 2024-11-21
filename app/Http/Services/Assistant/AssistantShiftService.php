<?php

namespace App\Http\Services\Assistant;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssistantShiftService extends AssistantService
{
    public function boot()
    {
        $request = request();

        $assistant = request("assistant") ?? null;
        $startDate = Carbon::now()->startOfMonth()->toDateString();
        $endDate = Carbon::now()->endOfMonth()->toDateString();

        if ($request->from && $request->from != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->from / 1000;
            $startDate = Carbon::createFromTimestamp($timestamp)->startOfDay();
        }

        if ($request->to && $request->to != "") {
            // Convert milliseconds to seconds and format as date
            $timestamp = $request->to / 1000;
            $endDate = Carbon::createFromTimestamp($timestamp)->endOfDay();
        }

        // Fetch all columns from your model's table
        $query = $this->model->select(
            'assistants.id as assistant_id',
            'assistants.name as assistant_name',
            DB::raw("COALESCE(SUM(CASE WHEN JSON_CONTAINS(shifts.morning_shift, JSON_QUOTE(CAST(assistants.id AS CHAR))) AND shifts.date >= ? AND shifts.date <= ? THEN 1 ELSE 0 END), 0) as total_morning_shifts"),
            DB::raw("COALESCE(SUM(CASE WHEN JSON_CONTAINS(shifts.night_shift, JSON_QUOTE(CAST(assistants.id AS CHAR))) AND shifts.date >= ? AND shifts.date <= ? THEN 1 ELSE 0 END), 0) as total_night_shifts"),
            DB::raw("COALESCE(SUM(CASE WHEN JSON_CONTAINS(shifts.morning_shift, JSON_QUOTE(CAST(assistants.id AS CHAR))) AND shifts.date >= ? AND shifts.date <= ? THEN 1 ELSE 0 END), 0) +
                COALESCE(SUM(CASE WHEN JSON_CONTAINS(shifts.night_shift, JSON_QUOTE(CAST(assistants.id AS CHAR))) AND shifts.date >= ? AND shifts.date <= ? THEN 1 ELSE 0 END), 0) as total_shifts")
        )
            ->leftJoin('shifts', function ($join) {
                $join->on(DB::raw("JSON_CONTAINS(shifts.morning_shift, JSON_QUOTE(CAST(assistants.id AS CHAR)))"), '=', DB::raw('1'))
                    ->orOn(DB::raw("JSON_CONTAINS(shifts.night_shift, JSON_QUOTE(CAST(assistants.id AS CHAR)))"), '=', DB::raw('1'));
            })
            ->addBinding($startDate, 'select')
            ->addBinding($endDate, 'select')
            ->addBinding($startDate, 'select')
            ->addBinding($endDate, 'select')
            ->addBinding($startDate, 'select')
            ->addBinding($endDate, 'select')
            ->addBinding($startDate, 'select')
            ->addBinding($endDate, 'select');

        if ($assistant) {
            $query->where('assistants.id', $assistant);
        }

        return $query->groupBy('assistants.id', 'assistants.name')->get();
    }
}
