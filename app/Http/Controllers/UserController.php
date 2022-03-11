<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRegisterPost;

class UserController extends Controller
{
    public function register(UserRegisterPost $request)
    {
        $name = $request->input('name');
        $age = $request->input('age');
    }
}
