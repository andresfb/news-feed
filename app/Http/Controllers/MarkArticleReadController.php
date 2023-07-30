<?php

namespace App\Http\Controllers;

use App\Emuns\PageName;
use App\Services\MarkArticleReadService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MarkArticleReadController extends Controller
{
    public function update(Request $request, int $articleId, MarkArticleReadService $service)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(PageName::values())],
            'provider_id' => ['nullable', 'integer'],
        ]);

        $service->markRead($articleId, $validated['page']);

        if (!empty($validated['provider_id'])) {
            return redirect()->route($validated['page'], $validated['provider_id']);
        }

        return redirect()->route($validated['page']);
    }

    public function delete(Request $request, int $articleId, MarkArticleReadService $service)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(PageName::values())],
        ]);

        $service->markRead($articleId, $validated['page']);

        return redirect()->route($validated['page']);
    }
}
