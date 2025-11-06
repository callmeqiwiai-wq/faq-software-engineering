<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SectionController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $sections = Section::with('articles')->orderBy('order')->get();
        return view('sections.index', compact('sections'));
    }

    public function show($slug)
    {
        $section = Section::where('slug', $slug)->firstOrFail();
        $articles = $section->articles()->orderBy('order')->get();
        return view('sections.show', compact('section', 'articles'));
    }

    public function create()
    {
        $this->authorize('create', Section::class);
        return view('sections.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Section::class);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:sections|max:255',
            'description' => 'required',
            'order' => 'required|integer|min:0',
        ]);

        Section::create($validated);

        return redirect()->route('sections.index')
            ->with('status', 'Раздел успешно создан');
    }

    public function edit(Section $section)
    {
        $this->authorize('update', $section);
        return view('sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $this->authorize('update', $section);
        
        $validated = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:sections,slug,' . $section->id . '|max:255',
            'description' => 'required',
            'order' => 'required|integer|min:0',
        ]);

        $section->update($validated);

        return redirect()->route('sections.show', $section->slug)
            ->with('status', 'Раздел успешно обновлен');
    }

    public function destroy(Section $section)
    {
        $this->authorize('delete', $section);
        
        $section->delete();

        return redirect()->route('sections.index')
            ->with('status', 'Раздел успешно удален');
    }
}
