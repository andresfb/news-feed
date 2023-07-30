<?php

namespace App\Http\Controllers;

use App\Services\ArchiveService;

class ArchiveController extends Controller
{
    // TODO: add Meilisearch
    // TODO: in the archive controller add a search engine
    // TODO: in the archive controller add a filters by provider, feed, and date range.

    public function index(ArchiveService $service)
    {
        $perPage = 50;

        return view('archive.index')
            ->with([
                'model' => $service->getArticles($perPage),
                'articles' => $service->getList($perPage),
                'articleCount' => $service->getCount(),
            ]);
    }
}
