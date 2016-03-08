<?php

namespace App\Http\Controllers;

use App\Services\ApiResponse;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class ResourceController
 * @package App\Http\Controllers
 */
abstract class ResourceController extends Controller
{
    public function __construct()
    {
        JWTAuth::parseToken()->authenticate();
    }


    protected abstract function getModel();

    /**
     * Display a listing of the resource.
     *
     * @return mixed
     */
    public function index($internal = false)
    {
        try {
            $model = $this->getModel();
            $models = $model::all()->filter(function ($item) {
                return Gate::allows('read', $item);
            });

            if ($internal) {
                return $models;
            }
            return ApiResponse::respond($models->toArray());
        } catch (\Exception $e) {
            return ApiResponse::respondInternalError();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return mixed
     */
    public function store()
    {
        try {
            $model = $this->getModel();

            if (Gate::denies('create', $model->fill(Request::all()))) {
                return ApiResponse::respondForbidden();
            }

            if (!$model->validate(Request::all())) {
                return ApiResponse::respondValidationError($model->getValidationErrors());
            }

            if ($models = $model::create(Request::all())) {
                return ApiResponse::respond($models, 201);
            } else {
                return ApiResponse::respondBadRequest();
            }
        } catch (\Exception $e) {
            return ApiResponse::respondInternalError(null, [$e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return mixed
     */
    public function show($id, $internal = false)
    {
        try {
            $model = $this->getModel();

            $models = $model::find($id);

            if (!$models) {
                return ApiResponse::respondNotFound();
            }

            if (Gate::denies('read', $models)) {
                return ApiResponse::respondForbidden();
            }

            if ($internal) {
                return $models;
            }
            return ApiResponse::respond($models->toArray());
        } catch (\Exception $e) {
            return ApiResponse::respondInternalError();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return mixed
     */
    public function update($id)
    {
        try {
            $model = $this->getModel();

            $models = $model::find($id);

            if (!$models) {
                return ApiResponse::respondNotFound();
            }

            if (Gate::denies('update', $models)) {
                return ApiResponse::respondForbidden();
            }

            if (!$model->validate(Request::all())) {
                return ApiResponse::respondValidationError($model->getValidationErrors());
            }

            if ($models->update(Request::all())) {
                return ApiResponse::respond($models);
            } else {
                return ApiResponse::respondBadRequest();
            }
        } catch (\Exception $e) {
            return ApiResponse::respondInternalError();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return mixed
     */
    public function destroy($id)
    {
        try {
            $model = $this->getModel();
            $models = $model::find($id);

            if (!$models) {
                return ApiResponse::respondNotFound();
            }

            if (Gate::denies('delete', $models)) {
                return ApiResponse::respondForbidden();
            }

            if ($models->destroy($id)) {
                return ApiResponse::respond($models, 204);
            } else {
                return ApiResponse::respondBadRequest();
            }
        } catch (\Exception $e) {
            return ApiResponse::respondInternalError();
        }
    }

}