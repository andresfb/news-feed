<?php

namespace App\Http\Controllers;

use App\Emuns\PageName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class RefreshController extends Controller
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in(PageName::values())],
        ]);

        Cache::tags($validated['page'])->flush();

        return redirect()->route($validated['page']);
    }
}
