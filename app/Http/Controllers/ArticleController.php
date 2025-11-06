<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->with(['section', 'comments.user', 'comments.replies.user'])
            ->firstOrFail();
        
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $this->authorize('create', Article::class);
        $sections = Section::orderBy('title')->get();
        return view('articles.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Article::class);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:articles|max:255',
            'content' => 'required',
            'section_id' => 'required|exists:sections,id',
            'order' => 'required|integer|min:0',
        ]);

        Article::create($validated);

        return redirect()->route('sections.show', Section::find($validated['section_id'])->slug)
            ->with('status', 'Статья успешно создана');
    }

    public function edit(Article $article)
    {
        $this->authorize('update', $article);
        $sections = Section::orderBy('title')->get();
        return view('articles.edit', compact('article', 'sections'));
    }

    public function update(Request $request, Article $article)
    {
        $this->authorize('update', $article);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:articles,slug,' . $article->id . '|max:255',
            'content' => 'required',
            'section_id' => 'required|exists:sections,id',
            'order' => 'required|integer|min:0',
        ]);

        $article->update($validated);

        return redirect()->route('articles.show', $article->slug)
            ->with('status', 'Статья успешно обновлена');
    }

    public function destroy(Article $article)
    {
        $this->authorize('delete', $article);
        
        $sectionSlug = $article->section->slug;
        $article->delete();

        return redirect()->route('sections.show', $sectionSlug)
            ->with('status', 'Статья успешно удалена');
    }
}
