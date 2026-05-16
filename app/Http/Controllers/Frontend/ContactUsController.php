<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Models\ContactUsDetail;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function create()
    {
        return view('frontend.pages.contact-us');
    }

    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        ContactUsDetail::create($request->all());

        return redirect()->back()->with('message', 'Contact Us Details created successfully.');
    }
}
