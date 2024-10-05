<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\IEloquent;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements IEloquent
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
}
