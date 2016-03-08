<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\ApiResponse;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends ResourceController
{
    /**
     * @return Task
     */
    protected function getModel()
    {
        return new Task;
    }

    /**
     * @return mixed
     */
    public function getFavorites()
    {
        $tasks = parent::index(true);
        $favoriteTasks = $tasks->filter(function ($item) {
            return ($item->favorite === true);
        });
        return ApiResponse::respond(array_values($favoriteTasks->toArray()));
    }

    /**
     * @return mixed
     */
    public function getArchived()
    {
        $tasks = parent::index(true);
        $archivedTasks = $tasks->filter(function ($item) {
            return $item->status === 'archived';
        });
        return ApiResponse::respond(array_values($archivedTasks->toArray()));
    }

}
