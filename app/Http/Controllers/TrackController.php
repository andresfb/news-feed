<?php

namespace App\Http\Controllers;

use App\Models\Article;

class TrackController extends Controller
{
    public function __invoke(Article $article)
    {
        $article->update([
            'read_at' => now(),
        ]);

        return redirect($article->permalink);
    }
}
