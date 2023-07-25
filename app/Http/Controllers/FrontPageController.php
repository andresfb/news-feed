<?php

namespace App\Http\Controllers;

use App\Services\ArticlesService;

class FrontPageController extends Controller
{
    public function index(ArticlesService $service)
    {
        $articles = $service->getRandomList();

        dd($articles);

        return view('frontpage')
            ->with('articles', $articles);
    }
}
