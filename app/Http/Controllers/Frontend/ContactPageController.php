<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Contact\ContactRequest;
use App\Models\Contact;
use App\Services\Admin\CMSManagement\ContactService;
use Illuminate\Http\Request;

class ContactPageController extends Controller

{

    protected ContactService $contactService;

    public function __construct(ContactService $contactService)
    {

        $this->contactService = $contactService;
    }

    public function store(ContactRequest $request)
    {

        try {
            $validated = $request->validated();
            $this->contactService->createContact($validated, $request);
        } catch (\Throwable $e) {
            session()->flash('error', 'Contact create failed!');
            throw $e;
        }
        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
