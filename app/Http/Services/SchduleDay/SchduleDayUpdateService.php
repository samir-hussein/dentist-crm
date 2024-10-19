<?php

namespace App\Http\Services\SchduleDay;

use App\Models\SchduleDayPattern;
use Illuminate\Database\Eloquent\Model;

class SchduleDayUpdateService extends SchduleDayService
{
    public function boot(Model $model, array $data)
    {
        $model->update($data);

        $model->pattern()->delete();

        $insert = [];

        foreach ($data['times'] as $time) {
            $insert[] = [
                'schdule_day_id' => $model->id,
                'time' => $time,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        SchduleDayPattern::insert($insert);

        return $this->success();
    }
}
