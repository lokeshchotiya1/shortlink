<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ShortLink;
// use DateTime;
// use DateInterval;
// use DatePeriod;
use Carbon\Carbon;
use Str;

class HomeController extends Controller {
    
    public function index()
    {
        $shortLinks = ShortLink::latest()->get();

        return view('home', compact('shortLinks'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
           'link' => 'required|url'
        ]);

        $input['link'] = $request->link;
        $input['code'] = Str::random(6);

        ShortLink::create($input);

        return redirect('generate-shorten-link')
             ->with('success', 'Shorten Link Generated Successfully!');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shortenLink($code)
    {
        $find = ShortLink::where('code', $code)->first();

        return redirect($find->link);
    }


}