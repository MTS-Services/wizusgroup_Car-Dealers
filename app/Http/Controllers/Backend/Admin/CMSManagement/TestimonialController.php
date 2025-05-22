<?php

namespace App\Http\Controllers\Backend\Admin\CMSManagement;

use App\Http\Controllers\Controller;
use App\Services\Admin\CMSManagement\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected TestimonialService $testimonialService;
    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;
    
        $this->middleware('auth:admin');
        $this->middleware('permission:testimonial-list', ['only' => ['index']]);
        $this->middleware('permission:testimonial-details', ['only' => ['show']]);
        $this->middleware('permission:testimonial-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:testimonial-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:testimonial-delete', ['only' => ['destroy']]);
        $this->middleware('permission:testimonial-status', ['only' => ['status']]);
        $this->middleware('permission:testimonial-recycle-bin', ['only' => ['recycleBin']]);
        $this->middleware('permission:testimonial-restore', ['only' => ['restore']]);
        $this->middleware('permission:testimonial-permanent-delete', ['only' => ['permanentDelete']]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
