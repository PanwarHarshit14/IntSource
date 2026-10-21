<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::whereRaw('1=1')->first();
        request()->replace($contact->toArray());
        request()->flash();

        return view('admin.screens.settings', compact('contact'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        $contact = Contact::firstOrCreate([]);

        return view('admin.screens.settings', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $contact = Contact::firstOrFail();
        $data = $request->except(['_token', '_method', 'logo', 'favicon']);
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            $data['logo'] = '/storage/'.$path;
        }
        if ($request->hasFile('favicon')) {
            $path = $request->file('favicon')->store('settings', 'public');
            $data['favicon'] = '/storage/'.$path;
        }
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('settings', 'public');
            $data['image'] = '/storage/'.$path;
        }
        $contact->update($data);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        //
    }
}
