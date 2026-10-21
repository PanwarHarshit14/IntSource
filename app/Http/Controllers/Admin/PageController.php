<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Page::query();
        if (! empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', '%'.$search.'%')
                    ->orWhere('slug', 'LIKE', '%'.$search.'%')
                    ->orWhere('description', 'LIKE', '%'.$search.'%');
            });
        }
        $pages = $query->latest('id')->paginate(10);

        return view('admin.screens.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        request()->flush();

        return view('admin.screens.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $page = new Page;
        $page->title = $request->title;
        $slug = ! empty($request->slug) ? Str::slug($request->slug, '-') : Str::slug($request->title, '-');

        // Ensure unique slug
        $count = Page::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug.'-'.(time() % 10000);
        }
        $page->slug = $slug;
        $page->description = $request->description;

        if ($request->filled('image')) {
            $page->image = saveDataUriImage($request->image, 'Pages');
        }

        $page->save();

        return redirect()->route('admin.page.index')->with('success', 'Page "'.$page->title.'" created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.screens.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $page->title = $request->title;
        $slug = ! empty($request->slug) ? Str::slug($request->slug, '-') : Str::slug($request->title, '-');

        // Ensure unique slug (ignoring current page)
        $count = Page::where('slug', $slug)->where('id', '!=', $page->id)->count();
        if ($count > 0) {
            $slug = $slug.'-'.(time() % 10000);
        }
        $page->slug = $slug;
        $page->description = $request->description;

        if ($request->filled('image')) {
            // Delete old image if exists
            $rawImg = $page->getRawOriginal('image');
            if (! empty($rawImg)) {
                $file = public_path('storage/'.$rawImg);
                if (file_exists($file)) {
                    @unlink($file);
                }
            }
            $page->image = saveDataUriImage($request->image, 'Pages');
        }

        $page->save();

        return redirect()->route('admin.page.index')->with('success', 'Page "'.$page->title.'" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $rawImg = $page->getRawOriginal('image');
        if (! empty($rawImg)) {
            $file = public_path('storage/'.$rawImg);
            if (file_exists($file)) {
                @unlink($file);
            }
        }
        $title = $page->title;
        $page->delete();

        return redirect()->back()->with('success', 'Page "'.$title.'" deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->delIds ?? [];
        if (! empty($ids) && is_array($ids)) {
            $count = 0;
            foreach ($ids as $id) {
                $page = Page::find($id);
                if ($page) {
                    $rawImg = $page->getRawOriginal('image');
                    if (! empty($rawImg)) {
                        $file = public_path('storage/'.$rawImg);
                        if (file_exists($file)) {
                            @unlink($file);
                        }
                    }
                    $page->delete();
                    $count++;
                }
            }

            return redirect()->back()->with('success', "{$count} page(s) deleted successfully.");
        }

        return redirect()->back()->with('error', 'No pages selected for deletion.');
    }

    public function removeImage($id)
    {
        $page = Page::findOrFail($id);
        $rawImg = $page->getRawOriginal('image');
        if (! empty($rawImg)) {
            $file = public_path('storage/'.$rawImg);
            if (file_exists($file)) {
                @unlink($file);
            }
            $page->image = null;
            $page->save();
        }

        return response()->json(['success' => true, 'message' => 'Featured image removed successfully.']);
    }
}
