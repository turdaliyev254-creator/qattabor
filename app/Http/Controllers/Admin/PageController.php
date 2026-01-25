<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::ordered()->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug',
            'content_en' => 'required|string',
            'content_uz' => 'required|string',
            'content_ru' => 'required|string',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        Page::create([
            'title' => [
                'en' => $validated['title_en'],
                'uz' => $validated['title_uz'],
                'ru' => $validated['title_ru'],
            ],
            'slug' => $validated['slug'],
            'content' => [
                'en' => $validated['content_en'],
                'uz' => $validated['content_uz'],
                'ru' => $validated['content_ru'],
            ],
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_uz' => 'required|string|max:255',
            'title_ru' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content_en' => 'required|string',
            'content_uz' => 'required|string',
            'content_ru' => 'required|string',
            'is_active' => 'boolean',
            'order' => 'integer|min:0',
        ]);

        $page->update([
            'title' => [
                'en' => $validated['title_en'],
                'uz' => $validated['title_uz'],
                'ru' => $validated['title_ru'],
            ],
            'slug' => $validated['slug'],
            'content' => [
                'en' => $validated['content_en'],
                'uz' => $validated['content_uz'],
                'ru' => $validated['content_ru'],
            ],
            'is_active' => $request->has('is_active'),
            'order' => $validated['order'] ?? 0,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
