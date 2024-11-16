<?php

namespace App\Http\Services\SchduleDay;

use App\Models\SchduleDayPattern;

class SchduleDayStoreService extends SchduleDayService
{
    public function boot(array $data)
    {
        try {
            $day = $this->model->firstOrCreate([
                "day" => $data["day"],
            ]);

            $insert = [];

            foreach ($data['times'] as $time) {
                $insert[] = [
                    'schdule_day_id' => $day->id,
                    'time' => $time['time'],
                    'doctor_id' => $time['doctor_id'],
                    'branch_id' => $time['branch_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            SchduleDayPattern::insert($insert);

            return $this->success();
        } catch (\Throwable $th) {
            return $this->error("The Doctor Already have this appointment time.", 400);
        }
    }
}
