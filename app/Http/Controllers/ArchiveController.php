<?php

namespace App\Http\Controllers;

use App\Services\ArchiveService;
use Illuminate\Http\Request;

class ArchiveController extends Controller
{
    public function index(Request $request, ArchiveService $service)
    {
        $params = $request->validate([
            'provider' => ['nullable', 'integer', 'exists:providers,id'],
            'feed' => ['nullable', 'integer', 'exists:feeds,id'],
            'from_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'to_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'page' => ['nullable', 'integer'],
        ]);

        $service->setParameters($params);

        return view('archive.index')
            ->with([
                'title' => $service->provider(),
                'model' => $service->getArticles(),
                'articles' => $service->getList(),
                'articleCount' => $service->getArticleCount(),
                'feeds' => $service->getFeeds(),
                'selectedProvider' => $service->providerId(),
                'selectedFeed' => $service->feedId(),
                'fromDate' => $service->fromDate()?->format('Y-m-d') ?? '',
                'toDate' => $service->toDate()?->format('Y-m-d') ?? '',
            ]);
    }
}
