<?php

namespace App\Http\Services\SchduleDate;

use Carbon\Carbon;
use App\Models\SchduleDay;
use App\Models\SchduleDate;
use App\Models\SchduleDateTime;
use App\Models\SchduleDayPattern;

class SchduleDateStoreService extends SchduleDateService
{
    public function boot()
    {
        $days = SchduleDay::get(["day", "id"]);
        $dates = [];
        $datesOnly = [];

        foreach ($days as $day) {
            $dates[$day->id] = $this->getDatesForDay($day->day);
        }

        $insert = [];
        foreach ($dates as $day => $date) {
            foreach ($date as $val) {
                $insert[] = [
                    'date' => $val,
                    'schdule_day_id' => $day
                ];
                $datesOnly[] = $val;
            }
        }

        SchduleDate::where("date", "<", date("Y-m-d"))->orWhereNotIn("date", $datesOnly)->delete();

        $uniqueBy = ['date'];

        SchduleDate::upsert($insert, $uniqueBy);

        $dates = SchduleDate::all();
        $times = SchduleDayPattern::all();

        $insert = [];
        $onlyValidTimes = [];

        foreach ($dates as $date) {
            foreach ($times as $time) {
                if ($time->schdule_day_id == $date->schdule_day_id) {
                    $timeFormat = Carbon::parse($date->date)->setTimeFromTimeString($time->time);
                    $insert[] = [
                        'time' => $timeFormat,
                        'doctor_id' => $time->doctor_id,
                        'branch_id' => $time->branch_id,
                        'schdule_date_id' => $date->id,
                    ];

                    $onlyValidTimes[] = $timeFormat;
                }
            }
        }

        $uniqueBy = ['time', 'doctor_id', 'schdule_date_id'];

        SchduleDateTime::whereNotIn("time", $onlyValidTimes)->where("urgent", 0)->delete();
        SchduleDateTime::upsert($insert, $uniqueBy);

        return $dates;
    }
}
