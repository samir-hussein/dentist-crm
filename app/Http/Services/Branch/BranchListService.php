<?php

namespace App\Http\Services\Branch;

class BranchListService extends BranchService
{
    public function boot(bool $withDates = false)
    {
        if ($withDates) {
            $data = $this->model->with(
                [
                    'schduleDates' => function ($q) {
                        $q->distinct()->where("is_holiday", 0)->select(['schdule_dates.id', 'date', 'schdule_day_id'])->orderBy('date');
                    },
                    'doctors' => function ($q) {
                        $q->distinct()->select(['name', 'users.id']);
                    }
                ]
            )->get()->map(function ($branch) {
                $branch->schduleDates->map(function ($date) {
                    $date->dateFormated = $date->date->format("l d-m-Y");
                    return $date;
                });
                return $branch;
            });
        } else {
            $data = $this->model->get(['id', 'name']);
        }

        return $data;
    }
}
