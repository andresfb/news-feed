<?php

namespace App\Http\Controllers;

use App\Services\ArticlesService;
use Illuminate\Contracts\View\View;

class FrontPageController extends Controller
{
    public function index(ArticlesService $service): View
    {
        // TODO: abstract the article view into a component for reuse.
        // TODO: Make the display of the articles a Livewire component.
        // TODO: Add 'Mark Read' button to the articles. Remove the article from the cached list when marked read.
        // TODO: Add a 'Refresh' button to the articles. Refresh the cached list when clicked.

        return view('frontpage')
            ->with('articles', $service->getRandomList());
    }
}
