<?php

namespace App\Http\Controllers;

use App\Emuns\PageName;
use App\Services\ArticlesService;

class GroupedController extends Controller
{
    public function __invoke(ArticlesService $service)
    {
        return view('provider')
            ->with([
                'providers' => $service->getGrouped(),
                'callPage' => PageName::Grouped->value,
            ]);
    }
}
