<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests;

class TaskController extends ResourceController
{
    protected function getModel()
    {
        return new Task;
    }

    public function getFavorites()
    {
        $tasks = parent::index(true);
        $favoriteTasks = $tasks->filter(function ($item) {
            return ($item->favorite === true);
        });
        return ApiResponse::respond(array_values($favoriteTasks->toArray()));
    }

    public function getArchived()
    {
        $tasks = parent::index(true);
        $archivedTasks = $tasks->filter(function ($item) {
            return $item->status === 'archived';
        });
        return ApiResponse::respond(array_values($archivedTasks->toArray()));
    }

}
