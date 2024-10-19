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
            }
        }

        $uniqueBy = ['date'];

        SchduleDate::upsert($insert, $uniqueBy);

        $dates = SchduleDate::all();
        $times = SchduleDayPattern::all();

        $insert = [];

        foreach ($dates as $date) {
            foreach ($times as $time) {
                if ($time->schdule_day_id == $date->schdule_day_id) {
                    $insert[] = [
                        'time' => Carbon::parse($date->date)->setTimeFromTimeString($time->time),
                        'schdule_date_id' => $date->id,
                    ];
                }
            }
        }

        $uniqueBy = ['time'];

        SchduleDateTime::upsert($insert, $uniqueBy);

        return $dates;
    }
}
