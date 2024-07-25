<?php

namespace App\Http\Controllers;

use App\Usecases\Top\IndexAction;
use Illuminate\View\View;

class TopController extends Controller
{
    public function index(IndexAction $action): View
    {
        $data = $action();

        return view('top.index', [
            'latestPosts' => $data['latestPosts'],
            'randomPosts' => $data['randomPosts'],
            'latestUsers' => $data['latestUsers'],
        ]);
    }
}
