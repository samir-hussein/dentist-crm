<?php

namespace App\Http\Services\SchduleDay;

use App\Models\SchduleDayPattern;

class SchduleDayStoreService extends SchduleDayService
{
    public function boot(array $data)
    {
        $day = $this->model->create($data);

        $insert = [];

        foreach ($data['times'] as $time) {
            $insert[] = [
                'schdule_day_id' => $day->id,
                'time' => $time,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SchduleDayPattern::insert($insert);

        return $this->success();
    }
}
