<?php

namespace App\Http\Controllers;

use App\Models\Tasklist;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests;

class TasklistController extends ResourceController
{
    protected function getModel()
    {
        return new Tasklist;
    }

    public function getTasks($id)
    {
        $tasklist = parent::show($id, true);

        $tasks = $tasklist->tasks->toArray();

        return ApiResponse::respond($tasks);
    }

}
