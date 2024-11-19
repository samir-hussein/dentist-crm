<?php

namespace App\Http\Interfaces;

use App\Models\Assistant;
use Illuminate\Http\Request;

interface IAssistant
{
    public function all(Request $request);
    public function store(array $requestData);
    public function update(Assistant $assistant, array $requestData);
    public function delete(Assistant $assistant);
    public function findById(Assistant $assistant);
}
