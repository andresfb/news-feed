<?php

namespace App\Http\Controllers;

use App\Services\ArchiveService;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    public function __invoke(Request $request, ArchiveService $service)
    {
        $params = $request->validate([
            'provider' => ['required', 'integer', 'exists:providers,id'],
        ]);

        $service->setParameters($params);

        $feeds = array_merge(
            [['id' => 0, 'title' => '']],
            $service->getFeeds()
        );

        return response()->json($feeds);
    }
}
