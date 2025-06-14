<?php

namespace App\View\Components\Backend\SiteSetting;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ContactInformationSetting extends Component
{
    public $contact_info_settings;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->contact_info_settings = SiteSetting::whereIn('key', ['email', 'phone', 'whatsapp', 'address', 'office_infos', 'sort_description', 'description', 'map_url'])->pluck('value', 'key')->all();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.backend.site-setting.contact-information-setting');
    }
}
