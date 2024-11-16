<?php

namespace App\Http\Services\SchduleDay;

use App\Models\SchduleDayPattern;
use Illuminate\Database\Eloquent\Model;

class SchduleDayUpdateService extends SchduleDayService
{
    public function boot(Model $model, array $data)
    {
        try {
            //code...
            $model->update($data);

            $insert = [];
            $existingPatterns = SchduleDayPattern::where('schdule_day_id', $model->id)->get();

            foreach ($data['times'] as $time) {
                $insert[] = [
                    'schdule_day_id' => $model->id,
                    'time' => $time['time'],
                    'old_time' => isset($time['old_time']) ? $time['old_time'] : null,
                    'doctor_id' => $time['doctor_id'],
                    'branch_id' => $time['branch_id'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Remove the corresponding existing pattern from the list if it's in the insert data
                $existingPatterns = $existingPatterns->filter(function ($pattern) use ($time, $model) {
                    return $pattern->doctor_id == $time['doctor_id'] && $pattern->time == $time['time'] && $pattern->schdule_day_id == $model->id;
                });
            }

            // Delete patterns that were not in the insert array
            $existingPatterns = $existingPatterns->pluck('id')->toArray();

            SchduleDayPattern::where('schdule_day_id', $model->id)
                ->whereNotIn('id', $existingPatterns)
                ->delete();

            foreach ($insert as &$timeData) {
                if ($timeData['old_time']) {
                    SchduleDayPattern::where('schdule_day_id', $model->id)
                        ->where('doctor_id', $timeData['doctor_id'])
                        ->where('time', $timeData['old_time'])  // Matching old_time to update the existing time
                        ->update([
                            'time' => $timeData['time'],
                            'branch_id' => $timeData['branch_id'],
                            'updated_at' => now(),
                        ]);
                }

                unset($timeData['old_time']);
            }

            // Upsert the data
            SchduleDayPattern::upsert($insert, ['schdule_day_id', 'doctor_id', 'time'], ['branch_id', 'updated_at']);


            return $this->success();
        } catch (\Throwable $th) {
            return $this->error("The Doctor Already have this appointment time.", 400);
        }
    }
}
