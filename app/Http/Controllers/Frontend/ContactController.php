<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller

{
    public function store(ContactRequest $request)
    {
         $data = $request->validated();
           Contact::create($data);
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }

    // public function index()
    // {
    //     // Display the contact form
    //     return view('frontend.contact');
    // }
}
