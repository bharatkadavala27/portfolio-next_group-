<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\ContactUsDetail;
use App\Http\Controllers\Controller;

class ContactUsDetailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $contactUsDetail = new ContactUsDetail();
        $contactUsDetail->address = $request->address;
        $contactUsDetail->phone = $request->phone;
        $contactUsDetail->email = $request->email;
        $contactUsDetail->save();

        return redirect()->back()->with('message', 'Contact Us Details created successfully.');
    }
}
