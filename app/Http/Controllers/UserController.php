<?php

namespace App\Http\Controllers;

use App\Usecases\User\ShowAction;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show($userSlug, ShowAction $action): View
    {
        $data = $action($userSlug);

        return view('profile.show', $data);
    }
}
