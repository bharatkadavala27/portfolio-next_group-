<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
     // Handle form submission
     public function submit(Request $request)
     {
         // Validate incoming data
         $validatedData = $request->validate([
             'name' => 'required|string|max:255',
             'e-mail' => 'required|email|max:255',
             'phone' => 'required|string|max:20',
             'text' => 'required|string',
         ]);
 
         // Store the form data in the database
         ContactUS::create([
             'name' => $validatedData['name'],
             'email' => $validatedData['e-mail'],
             'phone' => $validatedData['phone'],
             'message' => $validatedData['text'],
         ]);
 
         // Redirect to the admin panel
         return view('frontend.pages.contact-us');
     }
 
     // Display form submissions in the admin panel
     public function adminPanel()
     {
         $submissions = ContactUs::all();
         return view('admin.contact-us.index', compact('submissions'));
     }
}
