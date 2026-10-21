<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::query();
        if (! empty($request->search)) {
            $query->where('name', 'LIKE', '%'.$request->search.'%');
        }
        $enquiries = $query->orderBy('id')->paginate(10);

        return view('admin.screens.enquiries', compact('enquiries'));
    }

    public function destroy(Enquiry $enquiry)
    {
        $enquiry->delete();

        return redirect()->back()->with('success', 'Success! A record has been deleted.');
    }

    public function bulkDelete(Request $request)
    {
        foreach ($request->delIds as $id) {
            $enquiry = Enquiry::find($id);
            $enquiry->delete();
        }

        return redirect()->back()->with('success', 'Success! Selected record(s) has been deleted.');
    }
}
