<?php

namespace App\Http\Controllers;

use App\Services\ArticlesService;
use Illuminate\View\View;

class FrontPageController extends Controller
{
    public function index(ArticlesService $service): View
    {
        return view('frontpage')
            ->with('articles', $service->getRandomList());
    }
}
