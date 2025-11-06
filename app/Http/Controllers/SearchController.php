<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Section;
use App\Models\Test;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        // Support multiple possible input names from different views: 'q' (used in home),
        // 'query' (older), or 'search'. Prefer 'q' then 'query'.
        $query = $request->input('q', $request->input('query', $request->input('search')));
        
        if (empty($query)) {
            return redirect()->back();
        }

        $articles = Article::where('title', 'like', "%{$query}%")
            ->orWhere('content', 'like', "%{$query}%")
            ->with('section')
            ->get();

        $sections = Section::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        $tests = Test::where('title', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();

        return view('search.results', compact('articles', 'sections', 'tests', 'query'));
    }

    // Backwards-compatible alias: some routes call SearchController@index
    public function index(Request $request)
    {
        return $this->search($request);
    }
}
