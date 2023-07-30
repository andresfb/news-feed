<?php

namespace App\Http\Controllers;

use App\Jobs\MarkArticleReadJob;
use App\Models\Article;

class TrackController extends Controller
{
    public function __invoke(Article $article, string $callPage)
    {
        $article->update([
            'read_at' => now(),
        ]);

        MarkArticleReadJob::dispatch($article->id, $callPage);

        return redirect($article->permalink);
    }
}
