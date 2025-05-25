<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MultiLangController extends Controller
{
    public function langChange(Request $request): RedirectResponse
    {

        $lang = $request->lang;
        if (!in_array($lang, ['en', 'bn'])) {
            abort(400);
        }

        Session::put('locale', $lang);

        App::setLocale($lang);

        return redirect()->back();
    }
}
