<?php

namespace App\Http\Controllers;

use App\Usecases\Search\IndexAction;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request, IndexAction $action)
    {
        $searchData = [
            'keyword' => $request->input('keyword'),
            'tag' => $request->input('tag'),
            'order' => match ($request->input('order')) {
                'asc' => 'asc',
                default => 'desc',
            },
        ];

        $posts = $action($searchData);

        return view('search.index', compact('posts', 'searchData'));
    }
}
