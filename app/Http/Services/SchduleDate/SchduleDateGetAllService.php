<?php

namespace App\Http\Services\SchduleDate;

use App\Models\SchduleDate;
use Illuminate\Http\Request;

class SchduleDateGetAllService extends SchduleDateService
{
    private $schduleDateStoreService;

    public function __construct(SchduleDateStoreService $schduleDateStoreService, SchduleDate $schduleDate)
    {
        parent::__construct($schduleDate);
        $this->schduleDateStoreService = $schduleDateStoreService;
    }

    public function boot(Request $request)
    {
        $this->schduleDateStoreService->boot();
        // Fetch all columns from your model's table
        $data = $this->model->latest()->with(["schduleDay" => function ($q) {
            $q->select(['id', 'day']);
        }])->select('*');

        return $this->dataTable($data, "schdule_days", $request);
    }
}
