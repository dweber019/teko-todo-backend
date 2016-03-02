<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class UserController extends ResourceController
{
    protected function getModel()
    {
        return new User;
    }

}
