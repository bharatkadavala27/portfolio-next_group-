<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactUsDetail;

class ContactUsDetailsController extends Controller
{
    public function create()
    {
        return view('admin.contact-us-details.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        ContactUsDetail::create($request->all());

        return redirect('/admin/contact-us-details/index')->with('message', 'Contact-us details created successfully.');
    }

    public function index()
    {
        $contactUsDetails = ContactUsDetail::all();
        return view('admin.contact-us-details.index', compact('contactUsDetails'));
    }

    public function edit($id)
    {
        $detail = ContactUsDetail::findOrFail($id);
        return view('admin.contact-us-details.edit', compact('detail'));
    }

    public function update(Request $request, $id)
    {
        $detail = ContactUsDetail::findOrFail($id);
        $detail->update($request->all());
        return redirect()->route('contact-us-details.index')->with('message', 'Contact Us Details updated successfully.');
    }

    public function destroy($id)
    {
        $detail = ContactUsDetail::findOrFail($id);
        $detail->delete();

        return redirect()->back()->with('message', 'Contact Us Detail deleted successfully.');
    }
}
