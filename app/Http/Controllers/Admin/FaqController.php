<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Faq::query();
        if (! empty($request->search)) {
            $query->where('question', 'LIKE', '%'.$request->search.'%');
        }
        $faqs = $query->orderBy('id')->paginate(10);

        return view('admin.screens.faq.index', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        request()->flush();

        return view('admin.screens.faq.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $faq = new Faq;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect(route('admin.faq.index'))->with('success', 'Success! A new record has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faq $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faq $faq)
    {
        request()->replace($faq->toArray());
        request()->flash();

        return view('admin.screens.faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faq $faq)
    {
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect(route('admin.faq.index'))->with('success', 'Success! A record has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();

        return redirect()->back()->with('success', 'Success! A record has been deleted.');
    }

    // Bulk Delete
    public function bulkDelete(Request $request)
    {
        foreach ($request->delIds as $id) {
            $faq = Faq::find($id);
            $faq->delete();
        }

        return redirect()->back()->with('success', 'Success! Selected record(s) has been deleted.');
    }
}
