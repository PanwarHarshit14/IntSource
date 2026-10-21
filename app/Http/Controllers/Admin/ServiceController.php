<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::query();
        if (! empty($request->search)) {
            $query->where('title', 'LIKE', '%'.$request->search.'%');
        }
        $services = $query->latest()->paginate(10);

        return view('admin.screens.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->hasSession()) {
            request()->flush();
        }

        return view('admin.screens.services.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'short_description' => 'required|string|max:1000',
            'description' => 'required|string',
        ]);

        $service = new Service;
        $service->title = $validated['title'];
        $service->icon = $validated['icon'] ?? null;
        $service->short_description = $validated['short_description'];
        $service->description = $validated['description'];
        $service->save();

        return redirect(route('admin.service.index'))->with('success', 'Success! A new service has been added.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return redirect()->route('admin.service.edit', $service);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        request()->replace($service->toArray());
        request()->flash();

        return view('admin.screens.services.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'icon' => 'nullable|string',
            'short_description' => 'required|string|max:1000',
            'description' => 'required|string',
        ]);

        $service->title = $validated['title'];
        $service->icon = $validated['icon'] ?? null;
        $service->short_description = $validated['short_description'];
        $service->description = $validated['description'];
        $service->save();

        return redirect(route('admin.service.index'))->with('success', 'Success! Service has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->back()->with('success', 'Success! Service has been deleted.');
    }

    /**
     * Bulk Delete for Multi Delete
     */
    public function bulkDelete(Request $request)
    {
        if (! empty($request->delIds) && is_array($request->delIds)) {
            Service::whereIn('id', $request->delIds)->delete();

            return redirect()->back()->with('success', 'Success! Selected service(s) have been deleted.');
        }

        return redirect()->back()->with('error', 'No services were selected for deletion.');
    }
}
