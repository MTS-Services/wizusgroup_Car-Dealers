<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ContactRequest;
use App\Mail\ContactMail;
use App\Models\Contact;
use App\Services\Admin\CMSManagement\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactPageController extends Controller
{

    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {

        $this->contactService = $contactService;
    }

    public function contact()
    {
        return view('frontend.pages.contact');
    }

    public function store(ContactRequest $request)
    {

        try {
            $validated = $request->validated();
            if (Auth::guard('web')->check()) {
                $validated['creater_id'] = user()->id;
                $validated['creater_type'] = get_class(user());
            }
            $contact = $this->contactService->createContact($validated);
            Mail::to('oasiffre@gmail.com')->send(new ContactMail($contact));
        } catch (\Throwable $e) {
            session()->flash('error', 'Contact create failed!');
            throw $e;
        }


        session()->flash('success', 'Join request submitted successfully! We will contact you soon.');
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
