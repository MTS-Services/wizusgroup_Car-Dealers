<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\RegionShippingTimeline;
use App\Services\Admin\CMSManagement\RegionShippingTimelineService;
use App\Services\Admin\CMSManagement\RegionsService;
use Illuminate\Http\Request;

class RegionPageController extends Controller
{
    protected RegionsService $regionService;
    protected RegionShippingTimelineService $regionShippingTimelineService;

    public function __construct(RegionsService $regionService, RegionShippingTimelineService $regionShippingTimelineService)
    {
        $this->regionService = $regionService;
        $this->regionShippingTimelineService = $regionShippingTimelineService;
    }

    public function region(){
        $data['regions'] = $this->regionService->getRegions()->active()->get();
        return view('frontend.pages.regions', $data);
    }

}
