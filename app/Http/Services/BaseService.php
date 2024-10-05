<?php

namespace App\Http\Services;

use App\Http\Repositories\BaseRepository;
use App\Http\Traits\HandlerResponse;
use App\Http\Traits\HelperFunctions;

class BaseService extends BaseRepository
{
    use HandlerResponse, HelperFunctions;
}
