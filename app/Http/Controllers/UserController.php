<?php

namespace App\Http\Controllers;

use App\Usecases\User\IndexAction;
use App\Usecases\User\ShowAction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(IndexAction $action): View
    {
        $data = $action();

        return view('users.index', $data);
    }

    public function show($userSlug, ShowAction $action): View
    {
        $data = $action($userSlug);

        return view('users.show', $data);
    }
}
